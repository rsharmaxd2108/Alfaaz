<?php

namespace App\Http\Controllers;

use App\Models\Shayari;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    /**
     * Display the Explore Shayari page with filters and search.
     */
    public function index(Request $request): View
    {
        $shayaris = Shayari::getExploreVerses();

        return view('explore', compact('shayaris'));
    }
}
