<?php

namespace App\Http\Controllers;

use App\Models\Shayari;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DailyVerseController extends Controller
{
    /**
     * Display the Daily Verse feature and archive.
     */
    public function index(): View
    {
        $dailyVerse = Shayari::getDailyVerse();
        $archive = Shayari::getDailyArchive();

        return view('daily-verse', compact('dailyVerse', 'archive'));
    }
}
