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
        Schema::table('dictionaries', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('words', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('dictionaries', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('words', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
