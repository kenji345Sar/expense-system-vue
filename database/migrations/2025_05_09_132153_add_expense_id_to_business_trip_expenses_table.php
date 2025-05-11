<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('business_trip_expenses', function (Blueprint $table) {
            // ユーザー紐付け用
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 経費共通テーブルとの紐付け用
            $table->unsignedBigInteger('expense_id')->nullable()->after('user_id');
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('business_trip_expenses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->dropForeign(['expense_id']);
            $table->dropColumn('expense_id');
        });
    }
};
