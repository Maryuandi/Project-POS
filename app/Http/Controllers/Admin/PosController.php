<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        $search = $request->query('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(distributor) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $products = $query->take(24)->get();

        return view('admin.pos.terminal', compact('products', 'search'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|integer|exists:products,id',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.price' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'amount_received' => 'required|numeric',
            'is_installment' => 'sometimes|boolean',
            'down_payment' => 'exclude_unless:is_installment,true|required|numeric|min:1',
            'due_date' => 'exclude_unless:is_installment,true|required|date|after_or_equal:today',
        ]);

        $cart = $request->cart;
        $paymentMethod = $request->payment_method;
        $amountReceived = $request->amount_received;
        $isInstallment = $request->boolean('is_installment', false);
        $downPayment = $request->input('down_payment', 0);
        $dueDate = $request->input('due_date');

        $totalAmount = 0;
        $itemsToProcess = [];

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            $qty = (int) $item['qty'];
            $unitPrice = (float) $item['price'];

            if (!$product || $product->stock < $qty) {
                session()->flash('error', 'Stok tidak mencukupi untuk ' . ($product ? $product->name : 'produk tidak ditemukan') . '.');
                return response()->json(['message' => 'Stock insufficient'], 400);
            }

            $subtotal = $unitPrice * $qty;
            $totalAmount += $subtotal;

            $itemsToProcess[] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ];
        }

        // Validation for non-installment cash payments
        if (!$isInstallment && $paymentMethod === 'cash' && $amountReceived < $totalAmount) {
            session()->flash('error', 'Uang yang dibayarkan kurang!');
            return response()->json(['message' => 'Amount received is less than total'], 400);
        }

        // Validation for installment
        if ($isInstallment && ($downPayment <= 0 || $downPayment > $totalAmount)) {
            return response()->json(['message' => 'Down payment harus antara 1 dan total belanja'], 400);
        }

        try {
            DB::transaction(function () use ($totalAmount, $paymentMethod, $itemsToProcess, $isInstallment, $downPayment, $amountReceived, $dueDate) {

                if ($isInstallment) {
                    $amountPaid = $downPayment;
                    $amountDue = $totalAmount - $downPayment;
                    $status = $amountDue <= 0 ? 'completed' : 'installment';
                    $finalDueDate = $dueDate;
                } else {
                    $amountPaid = $totalAmount;
                    $amountDue = 0;
                    $status = 'completed';
                    $finalDueDate = null;
                }

                $sale = Sale::create([
                    'invoice_no' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                    'cashier_id' => Auth::id() ?? 1,
                    'sold_at' => now(),
                    'total_amount' => $totalAmount,
                    'amount_paid' => $amountPaid,
                    'amount_due' => $amountDue,
                    'payment_method' => $paymentMethod,
                    'status' => $status,
                    'due_date' => $finalDueDate,
                ]);

                foreach ($itemsToProcess as $item) {
                    SaleItem::create([
                        'sale_id' => $sale->id,
                        'product_id' => $item['product_id'],
                        'qty' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    Product::where('id', $item['product_id'])->decrement('stock', $item['quantity']);
                }

                // Record the first payment (DP or full)
                \App\Models\InstallmentPayment::create([
                    'sale_id' => $sale->id,
                    'amount' => $amountPaid,
                    'payment_method' => $paymentMethod,
                    'paid_at' => now(),
                    'notes' => $isInstallment ? 'DP / Pembayaran Awal' : 'Pembayaran Lunas',
                ]);
            });

            session()->flash('message', $isInstallment ? 'Transaksi cicilan berhasil! DP tercatat.' : 'Transaksi berhasil!');
            return response()->json(['message' => 'Success'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function payInstallment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|in:cash,qris,transfer',
        ]);

        $sale = Sale::findOrFail($id);

        if ($sale->status !== 'installment') {
            return response()->json(['message' => 'Transaksi ini sudah lunas'], 400);
        }

        if ($request->amount > $sale->amount_due) {
            return response()->json(['message' => 'Jumlah bayar melebihi sisa tagihan'], 400);
        }

        try {
            DB::transaction(function () use ($sale, $request) {
                \App\Models\InstallmentPayment::create([
                    'sale_id' => $sale->id,
                    'amount' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'paid_at' => now(),
                    'notes' => 'Cicilan ke-' . ($sale->installmentPayments()->count() + 1),
                ]);

                $newAmountPaid = $sale->amount_paid + $request->amount;
                $newAmountDue = $sale->total_amount - $newAmountPaid;

                $sale->update([
                    'amount_paid' => $newAmountPaid,
                    'amount_due' => max(0, $newAmountDue),
                    'status' => $newAmountDue <= 0 ? 'completed' : 'installment',
                ]);
            });

            return response()->json(['message' => 'Pembayaran cicilan berhasil!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }
}
