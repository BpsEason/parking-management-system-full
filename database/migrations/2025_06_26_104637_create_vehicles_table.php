<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained()->comment('所屬停車場');
            $table->string('license_plate_number')->unique()->comment('車牌號碼');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->comment('車主ID，月租車');
            $table->string('model')->nullable()->comment('車輛型號');
            $table->timestamps();
            $table->softDeletes();
            $table->index('parking_lot_id');
            $table->index('user_id');
        });
    }
    public function down(): void { Schema::dropIfExists('vehicles'); }
};
