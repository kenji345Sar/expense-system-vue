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
        Schema::create('transportation_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('use_date');
            $table->string('departure');
            $table->string('arrival');
            $table->string('route')->nullable();
            $table->decimal('amount', 10, 2);
            $table->text('remarks')->nullable();
            $table->timestamps(); // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_expenses');
    }
};
