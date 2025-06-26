<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('entry_exit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained()->comment('所屬停車場');
            $table->foreignId('vehicle_id')->constrained()->comment('車輛ID');
            $table->foreignId('parking_space_id')->nullable()->constrained()->onDelete('set null')->comment('佔用車位ID');
            $table->timestamp('entry_time')->comment('入場時間');
            $table->timestamp('exit_time')->nullable()->comment('出場時間');
            $table->string('entry_gate')->nullable()->comment('入口名稱');
            $table->string('exit_gate')->nullable()->comment('出口名稱');
            $table->decimal('total_fee', 8, 2)->nullable()->comment('總費用');
            $table->boolean('is_paid')->default(false)->comment('是否已付費');
            $table->timestamps();
            $table->softDeletes();
            $table->index('entry_time');
            $table->index('exit_time');
            $table->index(['parking_lot_id', 'is_paid']);
        });
    }
    public function down(): void { Schema::dropIfExists('entry_exit_records'); }
};
