<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Neon pooler: disable DDL transaction wrapping */
    public bool $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shayaris', function (Blueprint $table) {
            $table->string('title', 150)->nullable()->after('category_id')->comment('Title or Unwan of the couplet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shayaris', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
