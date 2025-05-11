<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('supplies_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('expense_id')->after('id')->nullable();

            // 外部キー制約（必要であれば）
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('supplies_expenses', function (Blueprint $table) {
            $table->dropForeign(['expense_id']);
            $table->dropColumn('expense_id');
        });
    }
};
