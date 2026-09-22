<?php

namespace Database\Seeders;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\DailyVerse;
use App\Models\Like;
use App\Models\Poet;
use App\Models\Shayari;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User
        $admin = User::updateOrCreate(
            ['email' => 'r.sharmaxd2108@gmail.com'],
            [
                'name' => 'Rahul Sharma',
                'password' => Hash::make('Rahul@123'),
                'pen_name' => 'Rahul',
                'bio' => 'Lead Curator and Administrator at Alfaaz.',
                'avatar_color' => '#1B1815',
                'role' => 'admin',
            ]
        );

        // Delete any deprecated dummy test accounts
        User::whereIn('email', ['author@alfaaz.com', 'reader@alfaaz.com'])->delete();

        // 2. Seed Categories
        $categoriesData = [
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

        $categoryMap = [];
        foreach ($categoriesData as $cat) {
            $created = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
            $categoryMap[$cat['slug']] = $created->id;
        }

        // 3. Seed Poets
        $poetsData = [
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

        $poetMap = [];
        foreach ($poetsData as $poet) {
            $created = Poet::updateOrCreate(['slug' => $poet['slug']], $poet);
            $poetMap[$poet['name']] = $created->id;
        }

        // Clean out any existing dummy/stale shayaris and related child records
        Comment::query()->delete();
        Like::query()->delete();
        Bookmark::query()->delete();
        DailyVerse::query()->delete();
        Shayari::query()->delete();
    }
}
