<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $produkTerpopuler = Item::where('status', 'available')
            ->with(['category', 'rentals'])
            ->withCount('rentals')
            ->orderByDesc('rentals_count')
            ->take(10)
            ->get();

        $rekomendasi = Item::where('status', 'available')
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('pages.home', compact('categories', 'produkTerpopuler', 'rekomendasi'));
    }
}