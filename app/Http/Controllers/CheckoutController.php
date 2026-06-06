<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Rental $rental)
    {
        // Proteksi agar hanya penyewa atau pemilik yang bisa melihat halaman ini
        if ($rental->tenant_id !== Auth::id() && $rental->owner_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Muat relasi item agar data barang bisa ditampilkan di halaman checkout
        $rental->load('item');

        return view('pages.checkout.checkout', compact('rental'));
    }
}