<?php

namespace App\Http\Controllers;

use App\Models\Shayari;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the Alfaaz landing page.
     */
    public function index(): View
    {
        $featuredShayaris = Shayari::getExploreVerses();
        $heroVerses = Shayari::getHeroVerses();
        $categories = Shayari::getCategories();
        $dailyVerse = Shayari::getDailyVerse();
        $dailyArchive = Shayari::getDailyArchive();

        return view('home', compact(
            'featuredShayaris',
            'heroVerses',
            'categories',
            'dailyVerse',
            'dailyArchive'
        ));
    }
}
