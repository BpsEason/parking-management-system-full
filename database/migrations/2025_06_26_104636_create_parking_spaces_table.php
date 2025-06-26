<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('parking_spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained()->comment('所屬停車場');
            $table->string('space_number')->comment('車位編號，如: A01, B20');
            $table->enum('type', ['general', 'handicapped', 'charging', 'motorcycle'])
                  ->default('general')->comment('車位類型');
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])
                  ->default('available')->comment('車位狀態');
            $table->timestamps();
            $table->unique(['parking_lot_id', 'space_number']);
            $table->index(['parking_lot_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('parking_spaces'); }
};
