<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'subtitle',
        'description',
        'accent_color',
        'bg_color',
        'verse_count',
        'sample_quote',
    ];

    /**
     * Shayaris under this category.
     */
    public function shayaris(): HasMany
    {
        return $this->hasMany(Shayari::class);
    }
}
