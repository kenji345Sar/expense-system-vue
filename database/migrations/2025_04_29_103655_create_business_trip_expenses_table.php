<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('business_trip_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('departure');               // 出発地
            $table->date('date');                      // 出張日
            $table->string('destination');             // 目的地
            $table->string('purpose');                 // 目的
            $table->string('transportation')->nullable(); // 交通手段（任意）
            $table->boolean('accommodation')->nullable(); // ← 変更        // 宿泊有無
            $table->integer('amount');                 // 金額
            $table->text('remarks')->nullable();       // 備考（任意）
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_trip_expenses');
    }
};
