<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('parking_lots', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('停車場名稱');
            $table->string('address')->nullable()->comment('停車場地址');
            $table->integer('total_spaces')->comment('總車位數');
            $table->string('contact_person')->nullable()->comment('聯絡人');
            $table->string('contact_phone')->nullable()->comment('聯絡電話');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('parking_lots'); }
};
