<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Poet extends Model
{
    use HasFactory;

    protected $table = 'poets';

    protected $fillable = [
        'name',
        'slug',
        'era',
        'bio',
        'signature_sher',
        'shayari_count',
        'avatar_color',
        'avatar_initials',
    ];

    /**
     * Shayaris penned by this poet.
     */
    public function shayaris(): HasMany
    {
        return $this->hasMany(Shayari::class);
    }

    /**
     * Get curated list of renowned poets and platform voices.
     */
    public static function getAll(): Collection
    {
        try {
            $dbPoets = static::all();
            if ($dbPoets->isNotEmpty()) {
                return $dbPoets;
            }
        } catch (\Throwable $e) {
            // Fallback if database is not migrated yet
        }

        $poets = [
            [
                'name' => 'Mirza Ghalib',
                'slug' => 'mirza-ghalib',
                'era' => '1797 – 1869 • Agra / Delhi',
                'bio' => 'The immortal master of Urdu and Persian ghazals during the twilight of the Mughal era. His verses delve into love, existential dread, and cosmic irony.',
                'signature_sher' => 'Hazaron khwahishein aisi ki har khwahish pe dam nikle, bahut nikle mere armaan lekin phir bhi kam nikle.',
                'shayari_count' => 142,
                'avatar_color' => '#8D9AE5',
                'avatar_initials' => 'MG',
            ],
            [
                'name' => 'Faiz Ahmad Faiz',
                'slug' => 'faiz-ahmad-faiz',
                'era' => '1911 – 1984 • Sialkot / Lahore',
                'bio' => 'Lenin Peace Prize laureate who masterfully wove revolutionary fervor and social consciousness into the tender metaphors of traditional romance.',
                'signature_sher' => 'Dil na-ummed toh nahi, nakaam hi toh hai; Lambi hai gham ki shaam, magar shaam hi toh hai.',
                'shayari_count' => 96,
                'avatar_color' => '#DF7656',
                'avatar_initials' => 'FF',
            ],
            [
                'name' => 'Jaun Elia',
                'slug' => 'jaun-elia',
                'era' => '1931 – 2002 • Amroha / Karachi',
                'bio' => 'An iconoclast philosopher-poet revered for his raw cynicism, melancholic honesty, and fierce interrogation of intimacy and solitude.',
                'signature_sher' => 'Ek hi shakhs tha jahan mein kya, jo mujhe chhod gaya tanha sa.',
                'shayari_count' => 88,
                'avatar_color' => '#7052FF',
                'avatar_initials' => 'JE',
            ],
            [
                'name' => 'Allama Iqbal',
                'slug' => 'allama-iqbal',
                'era' => '1877 – 1938 • Sialkot / Lahore',
                'bio' => 'The spiritual thinker and national poet known as Shair-e-Mashriq (Poet of the East), inspiring self-realization (Khudi) and boundless aspiration.',
                'signature_sher' => 'Sitaaron se aage jahan aur bhi hain, abhi ishq ke imtehan aur bhi hain.',
                'shayari_count' => 112,
                'avatar_color' => '#2E9D61',
                'avatar_initials' => 'AI',
            ],
            [
                'name' => 'Bashir Badr',
                'slug' => 'bashir-badr',
                'era' => '1935 – Present • Ayodhya / Bhopal',
                'bio' => 'Celebrated for bringing lyrical simplicity and conversational clarity to modern Urdu couplets that lodge instantly in the human heart.',
                'signature_sher' => 'Ujaale apni yaadon ke humare saath rehne do, na jaane kis gali mein zindagi ki shaam ho jaye.',
                'shayari_count' => 64,
                'avatar_color' => '#E8AE68',
                'avatar_initials' => 'BB',
            ],
            [
                'name' => 'Alfaaz Community',
                'slug' => 'alfaaz',
                'era' => 'Contemporary • Quiet Writers',
                'bio' => 'Original contemporary couplets created and submitted by readers, modern dreamers, and soulful voices within the Alfaaz collective.',
                'signature_sher' => 'Kuch rishte bas khamoshiyon mein dam tod dete hain, na koi shikayat hoti hai, na koi alvida.',
                'shayari_count' => 210,
                'avatar_color' => '#EFA282',
                'avatar_initials' => 'AF',
            ],
        ];

        return collect($poets)->map(function ($data) {
            $poet = new static();
            $poet->forceFill($data);
            return $poet;
        });
    }
}
