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
        Schema::create('entertainment_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');              // 利用日
            $table->string('client_name');      // 接待相手
            $table->string('place');            // 場所
            $table->integer('amount');          // 金額
            $table->text('content')->nullable(); // 内容（任意）
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entertainment_expenses');
    }
};
