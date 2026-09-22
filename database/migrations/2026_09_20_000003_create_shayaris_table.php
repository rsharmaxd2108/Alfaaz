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
        Schema::create('shayaris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('User who wrote or submitted');
            $table->foreignId('poet_id')->nullable()->constrained('poets')->nullOnDelete()->comment('Master poet if applicable');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->comment('Emotion/Theme category');
            $table->text('quote')->comment('Primary couplet text in Roman Hindi or English');
            $table->text('quote_urdu')->nullable()->comment('Nastaliq Urdu calligraphy script');
            $table->text('english_translation')->nullable()->comment('English meaning');
            $table->string('language', 40)->default('Roman Hindi');
            $table->string('author_name', 100)->nullable()->comment('Cached author name');
            $table->string('card_size', 20)->default('small')->comment('small, large for asymmetric bento layout');
            $table->string('status', 20)->default('published')->comment('published, draft, private');
            $table->unsignedInteger('likes_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'category_id']);
            $table->index('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shayaris');
    }
};
