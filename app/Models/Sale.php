<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'cashier_id',
        'store_id',
        'sold_at',
        'total_amount',
        'amount_paid',
        'amount_due',
        'payment_method',
        'status',
        'due_date',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sold_at' => 'datetime',
            'due_date' => 'date',
        ];
    }

    /**
     * Get the user (cashier) that processed the sale.
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }

    /**
     * Get the store where the sale was created.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the items for the sale.
     */
    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get the installment payments for the sale.
     */
    public function installmentPayments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    /**
     * Check if this sale is an installment.
     */
    public function isInstallment(): bool
    {
        return $this->status === 'installment';
    }

    /**
     * Check if this sale is fully paid.
     */
    public function isFullyPaid(): bool
    {
        return $this->status === 'completed';
    }
}
