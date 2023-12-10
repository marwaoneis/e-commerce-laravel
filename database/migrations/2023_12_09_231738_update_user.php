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
        Schema::table('users', function (Blueprint $table){
            // Add or modify columns
            $table->boolean('gender')->default(false);
            $table->integer('user_role')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes made in the 'up' method if the columns exists
            $table->dropColumn('gender');
            $table->dropColumn('user_role');
        });
    }
};
