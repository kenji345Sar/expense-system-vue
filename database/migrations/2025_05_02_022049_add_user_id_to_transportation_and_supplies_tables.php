<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transportation_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('amount');
        });

        Schema::table('supplies_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('total_price');
        });

        Schema::table('entertainment_expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('entertainment_expenses', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('transportation_expenses', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('supplies_expenses', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });

        Schema::table('entertainment_expenses', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
};
