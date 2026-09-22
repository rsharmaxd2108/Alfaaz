<?php

namespace App\Http\Controllers;

use App\Models\Poet;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PoetController extends Controller
{
    /**
     * Display all poets and platform voices.
     */
    public function index(): View
    {
        $poets = Poet::getAll();

        return view('poets', compact('poets'));
    }
}
