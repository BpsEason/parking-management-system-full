<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('rate_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained()->comment('所屬停車場');
            $table->string('name')->comment('費率方案名稱，如: 時租費率, 月租方案');
            $table->string('description')->nullable();
            $table->enum('type', ['hourly', 'daily', 'monthly', 'special'])->comment('費率類型');
            $table->json('rules')->comment('費率規則 (JSON格式)');
            $table->boolean('is_active')->default(true)->comment('是否啟用');
            $table->timestamps();
            $table->date('effective_date')->nullable()->comment('生效日期');
            $table->date('expiry_date')->nullable()->comment('失效日期');
        });
    }
    public function down(): void { Schema::dropIfExists('rate_plans'); }
};
