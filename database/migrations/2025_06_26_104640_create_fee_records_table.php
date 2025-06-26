<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('fee_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_exit_record_id')->constrained()->onDelete('cascade')->comment('關聯的出入記錄');
            $table->decimal('amount', 8, 2)->comment('應收費用');
            $table->decimal('paid_amount', 8, 2)->nullable()->comment('實際支付費用');
            $table->enum('payment_method', ['cash', 'credit_card', 'mobile_pay', 'monthly_deduction'])->nullable()->comment('支付方式');
            $table->timestamp('paid_at')->nullable()->comment('支付時間');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('fee_records'); }
};
