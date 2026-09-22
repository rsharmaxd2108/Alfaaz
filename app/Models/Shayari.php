<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class Shayari extends Model
{
    use HasFactory;

    protected $table = 'shayaris';

    protected $fillable = [
        'user_id',
        'poet_id',
        'category_id',
        'title',
        'quote',
        'quote_urdu',
        'english_translation',
        'language',
        'author_name',
        'card_size',
        'status',
        'likes_count',
    ];

    /**
     * Poet relationship.
     */
    public function poet(): BelongsTo
    {
        return $this->belongsTo(Poet::class);
    }

    /**
     * Category relationship.
     */
    public function categoryModel(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Author User relationship.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Comments relationship.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Approved top-level comments with replies.
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->where('status', 'approved')
            ->whereNull('parent_id')
            ->with(['replies', 'user']);
    }

    /**
     * Likes relationship.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Bookmarks relationship.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Accessor for author name.
     */
    public function getAuthorAttribute(): string
    {
        if (!empty($this->attributes['author_name'])) {
            return $this->attributes['author_name'];
        }
        if (!empty($this->attributes['author'])) {
            return $this->attributes['author'];
        }
        if ($this->relationLoaded('poet') && $this->poet) {
            return $this->poet->name;
        }
        return 'Alfaaz';
    }

    /**
     * Accessor for category display name.
     */
    public function getCategoryAttribute(): string
    {
        if ($this->relationLoaded('categoryModel') && $this->categoryModel) {
            return $this->categoryModel->name;
        }
        return $this->attributes['category'] ?? 'Ishq';
    }

    /**
     * Accessor for category slug/type.
     */
    public function getCategoryTypeAttribute(): string
    {
        if ($this->relationLoaded('categoryModel') && $this->categoryModel) {
            return $this->categoryModel->slug;
        }
        return $this->attributes['category_type'] ?? 'ishq';
    }

    /**
     * Accessor for avatar color.
     */
    public function getAvatarColorAttribute(): string
    {
        if (!empty($this->attributes['avatar_color'])) {
            return $this->attributes['avatar_color'];
        }
        if ($this->relationLoaded('poet') && $this->poet && $this->poet->avatar_color) {
            return $this->poet->avatar_color;
        }
        return '#EFA282';
    }

    /**
     * Accessor for likes counter (matching template $item->likes).
     */
    public function getLikesCounterAttribute(): int
    {
        return (int) ($this->attributes['likes_count'] ?? $this->attributes['likes'] ?? 0);
    }

    /**
     * Intercept attribute $item->likes.
     */
    public function getLikesAttribute()
    {
        // If loaded as relation, return relation; if called in view as property, return count
        if (array_key_exists('likes_count', $this->attributes)) {
            return $this->attributes['likes_count'];
        }
        if (array_key_exists('likes', $this->attributes)) {
            return $this->attributes['likes'];
        }
        return 0;
    }

    /**
     * Accessor for formatted date.
     */
    public function getDateAttribute(): string
    {
        if (!empty($this->attributes['date'])) {
            return $this->attributes['date'];
        }
        if ($this->created_at) {
            return $this->created_at->format('n/j/Y');
        }
        return '9/20/2026';
    }

    /**
     * Curated rotating daily sets of 4 verses for the Explore section.
     * Balanced with 2 large cards (slots 0 & 3) and 2 small cards (slots 1 & 2),
     * exclusively featuring love, relationship, sadness, and longing.
     */
    public static function getExploreDailySets(): array
    {
        return [
            // Set 0
            [
                [
                    'id' => 4,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Hazaron khwahishein aisi ki har khwahish pe dam nikle,\nbahut nikle mere armaan lekin phir bhi kam nikle.",
                    'author' => 'Mirza Ghalib',
                    'date_offset' => 2,
                    'likes' => 84,
                    'avatar_color' => '#8D9AE5',
                ],
                [
                    'id' => 1,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => 'Tere ishq mein doob gaye hum, ab lautne ka rasta bhool gaye.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 19,
                    'avatar_color' => '#EFA282',
                ],
                [
                    'id' => 2,
                    'card_size' => 'small',
                    'category' => 'Dosti',
                    'category_type' => 'dosti',
                    'language' => 'English',
                    'quote' => 'Some friendships are the quiet songs your soul never stops humming.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 31,
                    'avatar_color' => '#8FC7A2',
                ],
                [
                    'id' => 5,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Dil na-ummed toh nahi, nakaam hi toh hai;\nLambi hai gham ki shaam, magar shaam hi toh hai.",
                    'author' => 'Faiz Ahmad Faiz',
                    'date_offset' => 3,
                    'likes' => 67,
                    'avatar_color' => '#DF7656',
                ],
            ],

            // Set 1
            [
                [
                    'id' => 101,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Suna hai log use aankh bhar ke dekhte hain,\nso us ke shahr mein kuchh din thehar ke dekhte hain.",
                    'author' => 'Ahmad Faraz',
                    'date_offset' => 2,
                    'likes' => 92,
                    'avatar_color' => '#E8AE68',
                ],
                [
                    'id' => 102,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'English',
                    'quote' => 'You exist in the quiet gaps between every thought I have.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 42,
                    'avatar_color' => '#DF7656',
                ],
                [
                    'id' => 103,
                    'card_size' => 'small',
                    'category' => 'Tanhai',
                    'category_type' => 'tanhai',
                    'language' => 'Roman Hindi',
                    'quote' => 'Faasle aise bhi honge yeh kabhi socha na tha, samne baitha tha mere aur woh mera na tha.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 38,
                    'avatar_color' => '#7052FF',
                ],
                [
                    'id' => 104,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Ranjish hi sahi dil hi dukhane ke liye aa,\naa phir se mujhe chhod ke jaane ke liye aa.",
                    'author' => 'Ahmad Faraz',
                    'date_offset' => 3,
                    'likes' => 96,
                    'avatar_color' => '#C44D34',
                ],
            ],

            // Set 2
            [
                [
                    'id' => 201,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Ishq ne ‘Ghalib’ nikamma kar diya,\nwarna hum bhi aadmi the kaam ke.",
                    'author' => 'Mirza Ghalib',
                    'date_offset' => 2,
                    'likes' => 88,
                    'avatar_color' => '#5C63B7',
                ],
                [
                    'id' => 202,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => 'Bas ek tera ehsaas hi kaafi hai, mere bikhre huye din ko sametne ke liye.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 27,
                    'avatar_color' => '#EFA282',
                ],
                [
                    'id' => 203,
                    'card_size' => 'small',
                    'category' => 'Dosti',
                    'category_type' => 'dosti',
                    'language' => 'Roman Hindi',
                    'quote' => 'Dosti woh sukoon hai jahan lafzon ki zaroorat nahi padti.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 34,
                    'avatar_color' => '#8FC7A2',
                ],
                [
                    'id' => 204,
                    'card_size' => 'large',
                    'category' => 'Tanhai',
                    'category_type' => 'tanhai',
                    'language' => 'Roman Hindi',
                    'quote' => "Ek hi shakhs tha jahan mein kya,\njo mujhe chhod gaya tanha sa.",
                    'author' => 'Jaun Elia',
                    'date_offset' => 3,
                    'likes' => 94,
                    'avatar_color' => '#7052FF',
                ],
            ],

            // Set 3
            [
                [
                    'id' => 301,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Ghazab kiya tere vaade pe aitbaar kiya,\ntamaam raat bada intezaar kiya.",
                    'author' => 'Dagh Dehlvi',
                    'date_offset' => 2,
                    'likes' => 79,
                    'avatar_color' => '#7052FF',
                ],
                [
                    'id' => 302,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => 'Teri khamoshi bhi kitni baatein keh jaati hai, jo lafz kabhi na keh sake.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 23,
                    'avatar_color' => '#E8AE68',
                ],
                [
                    'id' => 303,
                    'card_size' => 'small',
                    'category' => 'Tanhai',
                    'category_type' => 'tanhai',
                    'language' => 'English',
                    'quote' => 'We loved each other through the silence of unsent letters.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 45,
                    'avatar_color' => '#DF7656',
                ],
                [
                    'id' => 304,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Woh toh khushboo hai hawaon mein bikhar jayega;\nMasla phool ka hai phool kidhar jayega.",
                    'author' => 'Parveen Shakir',
                    'date_offset' => 3,
                    'likes' => 87,
                    'avatar_color' => '#DF7656',
                ],
            ],

            // Set 4
            [
                [
                    'id' => 401,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Patta patta boota boota haal humara jaane hai,\njaane na jaane gul hi na jaane baagh toh saara jaane hai.",
                    'author' => 'Meer Taqi Meer',
                    'date_offset' => 2,
                    'likes' => 91,
                    'avatar_color' => '#C44D34',
                ],
                [
                    'id' => 402,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => 'Nigaahon se shuru hui thi jo dastaan, ab rooh tak utar chuki hai.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 29,
                    'avatar_color' => '#8D9AE5',
                ],
                [
                    'id' => 403,
                    'card_size' => 'small',
                    'category' => 'Dosti',
                    'category_type' => 'dosti',
                    'language' => 'English',
                    'quote' => 'In a crowded room of strangers, your laughter was my home.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 37,
                    'avatar_color' => '#8FC7A2',
                ],
                [
                    'id' => 404,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Ujaale apni yaadon ke humare saath rehne do,\nna jaane kis gali mein zindagi ki shaam ho jaye.",
                    'author' => 'Bashir Badr',
                    'date_offset' => 3,
                    'likes' => 83,
                    'avatar_color' => '#DF7656',
                ],
            ],

            // Set 5
            [
                [
                    'id' => 501,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Kitni dilkash ho tum kitna dil-juu hoon main,\nkya sitam hai ki hum log mar jaayenge.",
                    'author' => 'Jaun Elia',
                    'date_offset' => 2,
                    'likes' => 95,
                    'avatar_color' => '#7052FF',
                ],
                [
                    'id' => 502,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'English',
                    'quote' => 'To love you without expectation is the softest prayer I know.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 33,
                    'avatar_color' => '#EFA282',
                ],
                [
                    'id' => 503,
                    'card_size' => 'small',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => 'Muskurahat ke peeche ka dard har koi nahi samajh sakta.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 24,
                    'avatar_color' => '#DF7656',
                ],
                [
                    'id' => 504,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Kaise keh doon ki mujhe chhod diya hai us ne,\nbaat toh sach hai magar baat hai ruswaai ki.",
                    'author' => 'Parveen Shakir',
                    'date_offset' => 3,
                    'likes' => 89,
                    'avatar_color' => '#8D9AE5',
                ],
            ],

            // Set 6
            [
                [
                    'id' => 601,
                    'card_size' => 'large',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => "Ibtida-e-ishq hai rota hai kya,\naage aage dekhiye hota hai kya.",
                    'author' => 'Meer Taqi Meer',
                    'date_offset' => 2,
                    'likes' => 86,
                    'avatar_color' => '#DF7656',
                ],
                [
                    'id' => 602,
                    'card_size' => 'small',
                    'category' => 'Ishq',
                    'category_type' => 'ishq',
                    'language' => 'Roman Hindi',
                    'quote' => 'Paas na hokar bhi tum mere har lamhe mein shaamil ho.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 26,
                    'avatar_color' => '#E8AE68',
                ],
                [
                    'id' => 603,
                    'card_size' => 'small',
                    'category' => 'Tanhai',
                    'category_type' => 'tanhai',
                    'language' => 'English',
                    'quote' => 'Silence has a dialect that only a heavy heart can comprehend.',
                    'author' => 'Alfaaz',
                    'date_offset' => 1,
                    'likes' => 41,
                    'avatar_color' => '#7052FF',
                ],
                [
                    'id' => 604,
                    'card_size' => 'large',
                    'category' => 'Dard',
                    'category_type' => 'dard',
                    'language' => 'Roman Hindi',
                    'quote' => "Na kisi ki aankh ka noor hoon na kisi ke dil ka qaraar hoon;\nJo kisi ke kaam na aa sake main woh ek musht-e-ghubaar hoon.",
                    'author' => 'Bahadur Shah Zafar',
                    'date_offset' => 3,
                    'likes' => 82,
                    'avatar_color' => '#C44D34',
                ],
            ],
        ];
    }

    /**
     * Get 4 curated verses for the Explore section with asymmetric sizing,
     * rotating deterministically every day at midnight.
     */
    public static function getExploreVerses(?Carbon $date = null): Collection
    {
        $targetDate = $date ? $date->copy() : Carbon::today();
        $sets = self::getExploreDailySets();
        $daysSinceEpoch = (int) floor($targetDate->copy()->startOfDay()->timestamp / 86400);
        $setIndex = abs($daysSinceEpoch) % count($sets);
        $items = $sets[$setIndex];

        return collect($items)->map(function ($item, $idx) use ($targetDate) {
            $offset = $item['date_offset'] ?? 0;
            $cardDate = $targetDate->copy()->subDays($offset)->format('n/j/Y');

            $shayari = new static();
            $shayari->forceFill([
                'id' => $item['id'] ?? ($idx + 1),
                'card_size' => $item['card_size'] ?? (in_array($idx, [0, 3]) ? 'large' : 'small'),
                'category' => $item['category'],
                'category_type' => $item['category_type'],
                'language' => $item['language'],
                'quote' => $item['quote'],
                'author' => $item['author'],
                'date' => $cardDate,
                'likes' => $item['likes'],
                'avatar_color' => $item['avatar_color'],
            ]);
            return $shayari;
        });
    }

    /**
     * Get featured shayaris for the landing page.
     */
    public static function getFeatured(): Collection
    {
        return static::getAll()->take(3);
    }

    /**
     * Get all curated shayaris.
     */
    public static function getAll(): Collection
    {
        try {
            $dbItems = static::with(['poet', 'categoryModel'])->orderBy('id')->get();
            if ($dbItems->isNotEmpty()) {
                return $dbItems;
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        $items = [
            [
                'id' => 1,
                'category' => 'Ishq',
                'category_type' => 'ishq',
                'language' => 'Roman Hindi',
                'quote' => 'Tere ishq mein doob gaye hum, ab lautne ka rasta bhool gaye.',
                'author' => 'Alfaaz',
                'date' => '9/20/2026',
                'likes' => 14,
                'avatar_color' => '#EFA282',
            ],
            [
                'id' => 2,
                'category' => 'Dosti',
                'category_type' => 'dosti',
                'language' => 'English',
                'quote' => 'Some friendships are the quiet songs your soul never stops humming.',
                'author' => 'Alfaaz',
                'date' => '9/20/2026',
                'likes' => 28,
                'avatar_color' => '#8FC7A2',
            ],
            [
                'id' => 3,
                'category' => 'Umeed',
                'category_type' => 'umeed',
                'language' => 'Roman Hindi',
                'quote' => 'Har toote hue kandhe mein chhupa hai ek naya sooraj, bas dekho.',
                'author' => 'Alfaaz',
                'date' => '9/20/2026',
                'likes' => 32,
                'avatar_color' => '#E8AE68',
            ],
            [
                'id' => 4,
                'category' => 'Ishq',
                'category_type' => 'ishq',
                'language' => 'Roman Hindi',
                'quote' => 'Hazaron khwahishein aisi ki har khwahish pe dam nikle, bahut nikle mere armaan lekin phir bhi kam nikle.',
                'author' => 'Mirza Ghalib',
                'date' => '9/19/2026',
                'likes' => 84,
                'avatar_color' => '#8D9AE5',
            ],
            [
                'id' => 5,
                'category' => 'Dard',
                'category_type' => 'dard',
                'language' => 'Roman Hindi',
                'quote' => 'Dil na-ummed toh nahi, nakaam hi toh hai; Lambi hai gham ki shaam, magar shaam hi toh hai.',
                'author' => 'Faiz Ahmad Faiz',
                'date' => '9/18/2026',
                'likes' => 67,
                'avatar_color' => '#DF7656',
            ],
            [
                'id' => 6,
                'category' => 'Tanhai',
                'category_type' => 'tanhai',
                'language' => 'Roman Hindi',
                'quote' => 'Ek hi shakhs tha jahan mein kya, jo mujhe chhod gaya tanha sa.',
                'author' => 'Jaun Elia',
                'date' => '9/17/2026',
                'likes' => 92,
                'avatar_color' => '#7052FF',
            ],
            [
                'id' => 7,
                'category' => 'Zindagi',
                'category_type' => 'zindagi',
                'language' => 'Roman Hindi',
                'quote' => 'Zindagi dhoop bhi hai, chhaon bhi hai, ek safar hai jahan thehrao bhi hai.',
                'author' => 'Alfaaz',
                'date' => '9/16/2026',
                'likes' => 45,
                'avatar_color' => '#5C8271',
            ],
            [
                'id' => 8,
                'category' => 'Ishq',
                'category_type' => 'ishq',
                'language' => 'English',
                'quote' => 'You exist in the quiet gaps between every thought I have.',
                'author' => 'Alfaaz',
                'date' => '9/15/2026',
                'likes' => 53,
                'avatar_color' => '#EFA282',
            ],
            [
                'id' => 9,
                'category' => 'Umeed',
                'category_type' => 'umeed',
                'language' => 'Roman Hindi',
                'quote' => 'Sitaaron se aage jahan aur bhi hain, abhi ishq ke imtehan aur bhi hain.',
                'author' => 'Allama Iqbal',
                'date' => '9/14/2026',
                'likes' => 76,
                'avatar_color' => '#8FC7A2',
            ],
            [
                'id' => 10,
                'category' => 'Dard',
                'category_type' => 'dard',
                'language' => 'Roman Hindi',
                'quote' => 'Ujaale apni yaadon ke humare saath rehne do, na jaane kis gali mein zindagi ki shaam ho jaye.',
                'author' => 'Bashir Badr',
                'date' => '9/13/2026',
                'likes' => 61,
                'avatar_color' => '#DF7656',
            ],
            [
                'id' => 11,
                'category' => 'Tanhai',
                'category_type' => 'tanhai',
                'language' => 'English',
                'quote' => 'Silence has a dialect that only a heavy heart can comprehend.',
                'author' => 'Alfaaz',
                'date' => '9/12/2026',
                'likes' => 39,
                'avatar_color' => '#7052FF',
            ],
            [
                'id' => 12,
                'category' => 'Dosti',
                'category_type' => 'dosti',
                'language' => 'Roman Hindi',
                'quote' => 'Dosti woh sukoon hai jahan lafzon ki zaroorat nahi padti.',
                'author' => 'Alfaaz',
                'date' => '9/11/2026',
                'likes' => 41,
                'avatar_color' => '#8FC7A2',
            ],
        ];

        return collect($items)->map(function ($item) {
            $shayari = new static();
            $shayari->forceFill($item);
            return $shayari;
        });
    }

    /**
     * Filter shayaris by category, language, and search query.
     */
    public static function filter(?string $category = null, ?string $language = null, ?string $search = null): Collection
    {
        return static::getAll()->filter(function ($item) use ($category, $language, $search) {
            if ($category && strtolower($category) !== 'all' && strtolower($item->category_type) !== strtolower($category)) {
                return false;
            }

            if ($language && strtolower($language) !== 'all') {
                $itemLangSlug = strtolower(str_replace(' ', '-', $item->language));
                $targetLangSlug = strtolower($language);
                if ($itemLangSlug !== $targetLangSlug && strtolower($item->language) !== $targetLangSlug) {
                    return false;
                }
            }

            if ($search) {
                $term = strtolower(trim($search));
                $inQuote = str_contains(strtolower($item->quote), $term);
                $inAuthor = str_contains(strtolower($item->author), $term);
                $inCategory = str_contains(strtolower($item->category), $term);
                if (!$inQuote && !$inAuthor && !$inCategory) {
                    return false;
                }
            }

            return true;
        })->values();
    }

    /**
     * Get categories list with descriptive metadata.
     */
    public static function getCategories(): Collection
    {
        try {
            $dbCategories = Category::all();
            if ($dbCategories->isNotEmpty()) {
                return $dbCategories;
            }
        } catch (\Throwable $e) {
            // Fallback
        }

        $categories = [
            [
                'slug' => 'ishq',
                'name' => 'Ishq',
                'subtitle' => 'Love, Passion & Longing',
                'description' => 'The eternal ecstasy and aching devotion of hearts intertwined.',
                'accent_color' => '#7052FF',
                'bg_color' => '#F4F0FF',
                'verse_count' => 38,
                'sample_quote' => 'Tere ishq mein doob gaye hum, ab lautne ka rasta bhool gaye.',
            ],
            [
                'slug' => 'dosti',
                'name' => 'Dosti',
                'subtitle' => 'Companionship & Trust',
                'description' => 'Gentle souls who walk with us through light and storm.',
                'accent_color' => '#2E9D61',
                'bg_color' => '#EEF8F2',
                'verse_count' => 24,
                'sample_quote' => 'Some friendships are the quiet songs your soul never stops humming.',
            ],
            [
                'slug' => 'umeed',
                'name' => 'Umeed',
                'subtitle' => 'Hope, Light & Healing',
                'description' => 'A flicker of dawn when the night seems unending.',
                'accent_color' => '#DF7656',
                'bg_color' => '#FCF1ED',
                'verse_count' => 29,
                'sample_quote' => 'Har toote hue kandhe mein chhupa hai ek naya sooraj, bas dekho.',
            ],
            [
                'slug' => 'dard',
                'name' => 'Dard',
                'subtitle' => 'Heartache & Wounds',
                'description' => 'Quiet tears and unspoken grief distilled into poetic beauty.',
                'accent_color' => '#C44D34',
                'bg_color' => '#FAEEEE',
                'verse_count' => 31,
                'sample_quote' => 'Dil na-ummed toh nahi, nakaam hi toh hai; Lambi hai gham ki shaam, magar shaam hi toh hai.',
            ],
            [
                'slug' => 'zindagi',
                'name' => 'Zindagi',
                'subtitle' => 'Life & Philosophy',
                'description' => 'Reflections on the winding journey, fleeting moments, and wisdom.',
                'accent_color' => '#405B53',
                'bg_color' => '#EDF4F1',
                'verse_count' => 22,
                'sample_quote' => 'Zindagi dhoop bhi hai, chhaon bhi hai, ek safar hai jahan thehrao bhi hai.',
            ],
            [
                'slug' => 'tanhai',
                'name' => 'Tanhai',
                'subtitle' => 'Solitude & Stillness',
                'description' => 'Conversations with oneself when the entire world falls asleep.',
                'accent_color' => '#5C63B7',
                'bg_color' => '#EFF1FC',
                'verse_count' => 19,
                'sample_quote' => 'Ek hi shakhs tha jahan mein kya, jo mujhe chhod gaya tanha sa.',
            ],
        ];

        return collect($categories);
    }

    /**
     * Curated catalog of timeless verses for the daily rotation.
     */
    public static function getDailyAnthology(): array
    {
        return [
            [
                'quote' => 'Dil na-ummed toh nahi, nakaam hi toh hai; Lambi hai gham ki shaam, magar shaam hi toh hai.',
                'quote_urdu' => 'دل نا امید تو نہیں ناکام ہی تو ہے، لمبی ہے غم کی شام مگر شام ہی تو ہے',
                'english_translation' => 'The heart is not without hope, it has only met defeat; prolonged is this evening of sorrow, but it is only an evening after all.',
                'author' => 'Faiz Ahmad Faiz',
                'poet_era' => '1911 – 1984 • Sialkot / Lahore',
                'poet_bio' => 'Urdu literature\'s master of deep romantic yearning, who wove heartfelt melancholy into timeless lyrical verse.',
                'category' => 'Sadness & Heartbreak',
                'reflection' => 'Faiz offers solace to a wounded heart. Heartbreak casts a long, heavy twilight over the soul, but grief too has an ending—dawn will always return.',
                'avatar_color' => '#DF7656',
            ],
            [
                'quote' => 'Hazaron khwahishein aisi ki har khwahish pe dam nikle; Bahut nikle mere armaan lekin phir bhi kam nikle.',
                'quote_urdu' => 'ہزاروں خواہشیں ایسی کہ ہر خواہش پہ دم نکلے، بہت نکلے مرے ارمان لیکن پھر بھی کم نکلے',
                'english_translation' => 'Thousands of desires, each so profound that life would part for it; many yearning longings were fulfilled, yet so few they still seemed.',
                'author' => 'Mirza Ghalib',
                'poet_era' => '1797 – 1869 • Agra / Delhi',
                'poet_bio' => 'The preeminent classical poet of Urdu, famed for exploring the profound depths of human desire, passion, and the eternal ache of love.',
                'category' => 'Love & Desire',
                'reflection' => 'Ghalib captures the infinite thirst of love. In every relationship, the depth of what we yearn to experience will always outstrip the fleeting moments we hold.',
                'avatar_color' => '#8D9AE5',
            ],
            [
                'quote' => 'Ranjish hi sahi dil hi dukhane ke liye aa; Aa phir se mujhe chhod ke jaane ke liye aa.',
                'quote_urdu' => 'رنجش ہی سہی دل ہی دکھانے کے لیے آ، آ پھر سے مجھے چھوڑ کے جانے کے لیے آ',
                'english_translation' => 'Even if with bitterness, even if only to break my heart, do come; come, even if it is only to leave me once again.',
                'author' => 'Ahmad Faraz',
                'poet_era' => '1931 – 2008 • Kohat / Islamabad',
                'poet_bio' => 'A master of modern romantic lyricism whose emotionally raw ghazals became definitive anthems of love, devotion, and painful separation.',
                'category' => 'Heartbreak & Separation',
                'reflection' => 'Faraz immortalizes the unbearable desperation of love after parting. Even the acute pain of being broken once more is far sweeter than the cold silence of absence.',
                'avatar_color' => '#C44D34',
            ],
            [
                'quote' => 'Suna hai log use aankh bhar ke dekhte hain; So us ke shahr mein kuchh din thehar ke dekhte hain.',
                'quote_urdu' => 'سنا ہے لوگ اسے آنکھ بھر کے دیکھتے ہیں، سو اس کے شہر میں کچھ دن ٹھہر کے دیکھتے ہیں',
                'english_translation' => 'I hear people gaze upon her with wonder; so in her city, I think I shall linger for a while to behold her.',
                'author' => 'Ahmad Faraz',
                'poet_era' => '1931 – 2008 • Kohat / Islamabad',
                'poet_bio' => 'Celebrated voice of romantic tenderness whose melodies captured every delicate nuance of falling in love.',
                'category' => 'Love & Romance',
                'reflection' => 'Faraz paints love in its purest, tender beginnings. It is the quiet willingness to alter one\'s own journey simply to share the same sky as the one you adore.',
                'avatar_color' => '#E8AE68',
            ],
            [
                'quote' => 'Patta patta boota boota haal humara jaane hai; Jaane na jaane gul hi na jaane baagh toh saara jaane hai.',
                'quote_urdu' => 'پتا پتا بوٹا بوٹا حال ہمارا جانے ہے، جانے نہ جانے گل ہی نہ جانے باغ تو سارا جانے ہے',
                'english_translation' => 'Every leaf and every branch knows the story of my heartache; only the beloved blossom remains unaware, while the entire garden knows my longing.',
                'author' => 'Meer Taqi Meer',
                'poet_era' => '1723 – 1810 • Agra / Lucknow',
                'poet_bio' => 'Urdu\'s supreme master of sorrow (Khuda-e-Sukhan), who turned heartbreak and unrequited love into immortal poetry.',
                'category' => 'Sad & Heartbreak',
                'reflection' => 'Meer paints the tragic irony of unspoken devotion: the entire world witnesses how deeply you love and ache, yet the single soul you care about remains oblivious.',
                'avatar_color' => '#DF7656',
            ],
            [
                'quote' => 'Ek hi shakhs tha jahan mein kya; Jo mujhe chhod gaya tanha sa.',
                'quote_urdu' => 'ایک ہی شخص تھا جہاں میں کیا، جو مجھے چھوڑ گیا تنہا سا',
                'english_translation' => 'Was there truly only one solitary person in the whole wide world, whose departure could leave me feeling this completely alone?',
                'author' => 'Jaun Elia',
                'poet_era' => '1931 – 2002 • Amroha / Karachi',
                'poet_bio' => 'Urdu\'s philosopher of loneliness, revered for unvarnished verses of romantic disillusionment, loss, and raw human heartache.',
                'category' => 'Sad & Solitude',
                'reflection' => 'Jaun exposes the devastating math of love: a city may be crowded with millions of strangers, but when the one who held your soul walks away, the entire earth feels empty.',
                'avatar_color' => '#7052FF',
            ],
            [
                'quote' => 'Woh toh khushboo hai hawaon mein bikhar jayega; Masla phool ka hai phool kidhar jayega.',
                'quote_urdu' => 'وہ تو خوشبو ہے ہواؤں میں بکھر جائے گا، مسئلہ پھول کا ہے پھول کدھر جائے گا',
                'english_translation' => 'He is like a fragrant breeze that wanders freely away; the true sorrow is the flower left behind, wondering where it shall turn.',
                'author' => 'Parveen Shakir',
                'poet_era' => '1952 – 1994 • Karachi / Islamabad',
                'poet_bio' => 'Pioneering voice of feminine tenderness, capturing the vulnerability, heartbreak, and emotional courage of modern relationships.',
                'category' => 'Relationship & Parting',
                'reflection' => 'Parveen Shakir captures the quiet tragedy of being the one left behind in a relationship. One partner moves forward untethered, while the other bears the enduring weight of memory.',
                'avatar_color' => '#DF7656',
            ],
            [
                'quote' => 'Kaise keh doon ki mujhe chhod diya hai us ne; Baat toh sach hai magar baat hai ruswaai ki.',
                'quote_urdu' => 'کیسے کہہ دوں کہ مجھے چھوڑ دیا ہے اس نے، بات تو سچ ہے مگر بات ہے رسوائی کی',
                'english_translation' => 'How can I bring myself to admit that they have walked away from me? The truth it surely is, but speaking it breaks what remains of my pride.',
                'author' => 'Parveen Shakir',
                'poet_era' => '1952 – 1994 • Karachi / Islamabad',
                'poet_bio' => 'Her ghazals explore intimacy, secret confessions, and the bitter-sweet compromises of modern love.',
                'category' => 'Heartbreak & Sadness',
                'reflection' => 'Shakir gives voice to the painful instinct to shield a past lover from judgment, quietly enduring heartbreak alone rather than exposing the fragility of the bond you shared.',
                'avatar_color' => '#8D9AE5',
            ],
            [
                'quote' => 'Ujaale apni yaadon ke humare saath rehne do; Na jaane kis gali mein zindagi ki shaam ho jaye.',
                'quote_urdu' => 'اجالے اپنی یادوں کے ہمارے ساتھ رہنے دو، نہ جانے کس گلی میں زندگی کی شام ہو جائے',
                'english_translation' => 'Let the soft light of your memories stay by my side; who knows in which quiet street life\'s evening may find me.',
                'author' => 'Bashir Badr',
                'poet_era' => '1935 – Present • Ayodhya / Bhopal',
                'poet_bio' => 'Celebrated for lyrical intimacy and unforgettable couplets on human affection, nostalgia, and relationships.',
                'category' => 'Love & Memories',
                'reflection' => 'Bashir Badr touches on the sacred comfort of love remembered. Even when two people are separated by time and distance, the gentle glow of their shared days shields against cold loneliness.',
                'avatar_color' => '#EFA282',
            ],
            [
                'quote' => 'Koi haath bhi na milayega jo gale miloge tapaak se; Yeh naye mizaaj ka shahr hai zara faasle se mila karo.',
                'quote_urdu' => 'کوئی ہاتھ بھی نہ ملائے گا جو گلے ملو گے تپاک سے، یہ نئے مزاج کا شہر ہے ذرا فاصلے سے ملا کرو',
                'english_translation' => 'None will even offer a hand if you rush to embrace them with warmth; this modern world has grown distant—learn to guard your heart and keep a gentle space.',
                'author' => 'Bashir Badr',
                'poet_era' => '1935 – Present • Ayodhya / Bhopal',
                'poet_bio' => 'Renowned for capturing the unspoken emotional shifts and quiet distance that creep into modern human relationships.',
                'category' => 'Relationship & Distance',
                'reflection' => 'A tender warning about love and connection: when people grow guarded, overflowing affection can be misunderstood. To protect your bond, give love the room it needs to breathe.',
                'avatar_color' => '#DF7656',
            ],
            [
                'quote' => 'Ghazab kiya tere vaade pe aitbaar kiya; Tamaam raat bada intezaar kiya.',
                'quote_urdu' => 'غضب کیا ترے وعدے پہ اعتبار کیا، تمام رات بڑا انتظار کیا',
                'english_translation' => 'What foolishness it was to place my faith in your promise; all through the endless night, I waited in helpless longing for you.',
                'author' => 'Dagh Dehlvi',
                'poet_era' => '1831 – 1905 • Delhi / Hyderabad',
                'poet_bio' => 'A master of romantic expression, known for his playful musicality, conversational honesty, and depiction of love\'s passionate tantrums.',
                'category' => 'Love & Longing',
                'reflection' => 'Dagh captures the sweet torment of romantic waiting. Every tick of the clock amplifies the ache between trust and betrayal, yet the heart still waits by the door.',
                'avatar_color' => '#7052FF',
            ],
            [
                'quote' => 'Ishq ne ‘Ghalib’ nikamma kar diya; Warna hum bhi aadmi the kaam ke.',
                'quote_urdu' => 'عشق نے غالبؔ نکما کر دیا، ورنہ ہم بھی آدمی تھے کام کے',
                'english_translation' => 'Love has rendered me utterly helpless and disarmed, Ghalib; otherwise, I too was once a person of ambition and worldly consequence.',
                'author' => 'Mirza Ghalib',
                'poet_era' => '1797 – 1869 • Agra / Delhi',
                'poet_bio' => 'The unmatched poet of heartbreak, intimacy, and the ironies of devotion.',
                'category' => 'Love & Devotion',
                'reflection' => 'With ironic humor and supreme vulnerability, Ghalib acknowledges how all-consuming romantic love can be. It upends life\'s practical pursuits and surrenders every priority to the beloved.',
                'avatar_color' => '#5C63B7',
            ],
            [
                'quote' => 'Na kisi ki aankh ka noor hoon na kisi ke dil ka qaraar hoon; Jo kisi ke kaam na aa sake main woh ek musht-e-ghubaar hoon.',
                'quote_urdu' => 'نہ کسی کی آنکھ کا نور ہوں نہ کسی کے دل کا قرار ہوں، جو کسی کے کام نہ آ سکے میں وہ ایک مشت غبار ہوں',
                'english_translation' => 'I am neither the light of anyone\'s eyes nor the solace of anyone\'s heart; I am merely a handful of drifting dust, forgotten and uncherished.',
                'author' => 'Bahadur Shah Zafar',
                'poet_era' => '1775 – 1862 • Delhi / Rangoon',
                'poet_bio' => 'His melancholic ghazals capture the profound sadness of lost love, unreciprocated devotion, and heartbreak.',
                'category' => 'Sadness & Heartbreak',
                'reflection' => 'Zafar gives voice to the deepest ache of heartbreak—the feeling of becoming a ghost to the very people whose approval and love you once lived for.',
                'avatar_color' => '#C44D34',
            ],
            [
                'quote' => 'Gaye dinon ka suraagh le kar kidhar se aaya kidhar gaya woh; Ajeeb shakhs tha shahr chhod kar na jaane kidhar gaya woh.',
                'quote_urdu' => 'گئے دنوں کا سراغ لے کر کدھر سے آیا کدھر گیا وہ، عجیب شخص تھا شہر چھوڑ کر نہ جانے کدھر گیا وہ',
                'english_translation' => 'Carrying traces of days gone by, where did he come from and where did he go? What an unforgettable lover, who walked out of my city and vanished into the night.',
                'author' => 'Nasir Kazmi',
                'poet_era' => '1925 – 1972 • Ambala / Lahore',
                'poet_bio' => 'Urdu\'s poet of quiet dusk and separation, known for capturing the sorrow of fleeting lovers and distant footsteps.',
                'category' => 'Sad & Memories',
                'reflection' => 'Kazmi mourns the lovers who drift through our lives like fleeting seasons, leaving an imprint so deep that every street corner forever remembers their absence.',
                'avatar_color' => '#8D9AE5',
            ],
            [
                'quote' => 'Ibtida-e-ishq hai rota hai kya; Aage aage dekhiye hota hai kya.',
                'quote_urdu' => 'ابتداۓ عشق ہے روتا ہے کیا، آگے آگے دیکھیے ہوتا ہے کیا',
                'english_translation' => 'This is only the beginning of love, why do you weep already? Wait and see what greater trials and passions unfold ahead.',
                'author' => 'Meer Taqi Meer',
                'poet_era' => '1723 – 1810 • Agra / Lucknow',
                'poet_bio' => 'Urdu\'s legendary romantic poet who captured the perilous beauty and unavoidable heartbreak of loving deeply.',
                'category' => 'Love & Heartbreak',
                'reflection' => 'Meer reminds every lover that suffering is not an accident in romance—it is the very fire that tempers devotion into something timeless.',
                'avatar_color' => '#DF7656',
            ],
            [
                'quote' => 'Kitni dilkash ho tum kitna dil-juu hoon main; Kya sitam hai ki hum log mar jaayenge.',
                'quote_urdu' => 'کتنی دلکش ہو تم کتنا دل جو ہوں میں، کیا ستم ہے کہ ہم لوگ مر جائیں گے',
                'english_translation' => 'How enchanting you are, how deeply devoted my heart is; what a quiet tragedy that life will slip away before we ever truly unite.',
                'author' => 'Jaun Elia',
                'poet_era' => '1931 – 2002 • Amroha / Karachi',
                'poet_bio' => 'Famous for capturing the tragic gaps, unspoken feelings, and fragile beauty within romantic relationships.',
                'category' => 'Relationship & Longing',
                'reflection' => 'Jaun captures the urgency and fragility of human relationships. Two souls may cherish one another immensely, yet unspoken hesitation and pride let precious time drift away forever.',
                'avatar_color' => '#7052FF',
            ],
        ];
    }

    /**
     * Get featured daily couplet for a given date (defaults to today).
     */
    public static function getDailyVerse(?Carbon $date = null): array
    {
        $targetDate = $date ? $date->copy() : Carbon::today();

        try {
            $dbVerse = DailyVerse::whereDate('featured_date', $targetDate)->with(['shayari.poet'])->first();
            if ($dbVerse && $dbVerse->shayari) {
                $sher = $dbVerse->shayari;
                $authorName = $sher->author_name ?: ($sher->user->name ?? ($sher->poet->name ?? 'Alfaaz Poet'));
                return [
                    'date' => $targetDate->format('l, F j, Y'),
                    'quote' => $sher->quote,
                    'quote_urdu' => $sher->quote_urdu,
                    'english_translation' => $sher->english_translation,
                    'author' => $authorName,
                    'poet_era' => $sher->poet->era ?? 'Alfaaz Platform',
                    'poet_bio' => $sher->poet->bio ?? 'Alfaaz Community Poet',
                    'category' => $sher->categoryModel->name ?? ($sher->language ?? 'Couplet'),
                    'reflection' => $dbVerse->reflection ?: 'A poignant reflection on life, memory, and heartfelt human emotion.',
                    'avatar_color' => $sher->user->avatar_color ?? '#DF7656',
                ];
            }
        } catch (\Throwable $e) {
            // Proceed to curated dynamic calendar rotation
        }

        $anthology = self::getDailyAnthology();
        $daysSinceEpoch = (int) floor($targetDate->copy()->startOfDay()->timestamp / 86400);
        $index = abs($daysSinceEpoch) % count($anthology);
        $item = $anthology[$index];

        return [
            'date' => $targetDate->format('l, F j, Y'),
            'quote' => $item['quote'],
            'quote_urdu' => $item['quote_urdu'],
            'english_translation' => $item['english_translation'],
            'author' => $item['author'],
            'poet_era' => $item['poet_era'],
            'poet_bio' => $item['poet_bio'],
            'category' => $item['category'],
            'reflection' => $item['reflection'],
            'avatar_color' => $item['avatar_color'] ?? '#7052FF',
        ];
    }

    /**
     * Get recent daily verses archive for preceding days.
     */
    public static function getDailyArchive(?Carbon $date = null): Collection
    {
        $targetDate = $date ? $date->copy() : Carbon::today();
        $anthology = self::getDailyAnthology();
        $archive = collect();

        for ($i = 1; $i <= 4; $i++) {
            $pastDate = $targetDate->copy()->subDays($i);

            $dbVerse = null;
            try {
                $dbVerse = DailyVerse::whereDate('featured_date', $pastDate)->with(['shayari.poet'])->first();
            } catch (\Throwable $e) {}

            if ($dbVerse && $dbVerse->shayari) {
                $sher = $dbVerse->shayari;
                $archive->push([
                    'date' => $pastDate->format('M j, Y'),
                    'quote' => $sher->quote,
                    'author' => $sher->author_name ?: ($sher->user->name ?? ($sher->poet->name ?? 'Alfaaz Poet')),
                    'category' => $sher->categoryModel->name ?? ($sher->language ?? 'Couplet'),
                    'quote_urdu' => $sher->quote_urdu,
                    'english_translation' => $sher->english_translation,
                    'reflection' => $dbVerse->reflection,
                ]);
            } else {
                $daysSinceEpoch = (int) floor($pastDate->copy()->startOfDay()->timestamp / 86400);
                $index = abs($daysSinceEpoch) % count($anthology);
                $item = $anthology[$index];

                $archive->push([
                    'date' => $pastDate->format('M j, Y'),
                    'quote' => $item['quote'],
                    'author' => $item['author'],
                    'category' => $item['category'],
                    'quote_urdu' => $item['quote_urdu'],
                    'english_translation' => $item['english_translation'],
                    'reflection' => $item['reflection'],
                ]);
            }
        }

        return $archive;
    }

    /**
     * Get hero speech bubble verses matching the design.
     */
    public static function getHeroVerses(): array
    {
        return [
            'top' => [
                'quote' => 'Khamoshi bhi ek jawab hoti hai, jab dil na kare kehna.',
                'author' => 'Alfaaz',
            ],
            'bottom' => [
                'quote' => 'Tumhare bina ka intezaar, ek aadat ban gaya.',
                'author' => 'Alfaaz',
            ],
        ];
    }
}
