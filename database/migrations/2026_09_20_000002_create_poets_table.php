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
        Schema::create('poets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->string('era', 120)->nullable();
            $table->text('bio')->nullable();
            $table->text('signature_sher')->nullable();
            $table->unsignedInteger('shayari_count')->default(0);
            $table->string('avatar_color', 25)->default('#8D9AE5');
            $table->string('avatar_initials', 6);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poets');
    }
};
