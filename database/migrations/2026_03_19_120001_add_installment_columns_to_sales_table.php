<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('amount_paid', 12, 2)->unsigned()->default(0)->after('total_amount');
            $table->decimal('amount_due', 12, 2)->unsigned()->default(0)->after('amount_paid');
            $table->string('status')->default('completed')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['amount_paid', 'amount_due', 'status']);
        });
    }
};
