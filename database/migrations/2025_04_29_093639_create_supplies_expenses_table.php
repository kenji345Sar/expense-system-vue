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
        Schema::create('supplies_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('unit_price');
            $table->integer('total_price');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplies_expenses');
    }
};
