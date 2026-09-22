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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->comment('Author of the comment');
            $table->foreignId('shayari_id')->constrained('shayaris')->cascadeOnDelete()->comment('Target couplet');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete()->comment('Parent comment for threaded replies');
            $table->text('body')->comment('Comment text content');
            $table->string('status', 20)->default('approved')->comment('approved, pending, hidden');
            $table->timestamps();

            $table->index(['shayari_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
