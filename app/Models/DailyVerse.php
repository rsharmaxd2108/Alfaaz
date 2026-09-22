<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyVerse extends Model
{
    use HasFactory;

    protected $table = 'daily_verses';

    protected $fillable = [
        'shayari_id',
        'featured_date',
        'reflection',
    ];

    protected $casts = [
        'featured_date' => 'date',
    ];

    public function shayari(): BelongsTo
    {
        return $this->belongsTo(Shayari::class);
    }

    public function getQuoteAttribute(): string
    {
        return $this->shayari->quote ?? '';
    }

    public function getQuoteUrduAttribute(): ?string
    {
        return $this->shayari->quote_urdu ?? null;
    }

    public function getEnglishTranslationAttribute(): ?string
    {
        return $this->shayari->english_translation ?? null;
    }

    public function getAuthorAttribute(): string
    {
        return $this->shayari->author ?? 'Alfaaz';
    }

    public function getPoetEraAttribute(): string
    {
        return $this->shayari && $this->shayari->poet ? ($this->shayari->poet->era ?? '') : '';
    }

    public function getPoetBioAttribute(): string
    {
        return $this->shayari && $this->shayari->poet ? ($this->shayari->poet->bio ?? '') : '';
    }

    public function getCategoryAttribute(): string
    {
        return $this->shayari->category ?? 'Umeed';
    }

    public function getLikesCountAttribute(): int
    {
        return $this->shayari->likes_count ?? 100;
    }
}
