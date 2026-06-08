<?php

namespace App\Http\Controllers;

use App\Models\Rental;
// Pastikan model Review/Ulasan Anda di-import, misalnya:
// use App\Models\Review; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // ... (fungsi lain yang mungkin sudah ada) ...

    public function create(Rental $rental)
    {
        // Pastikan hanya penyewa yang bisa memberikan ulasan
        if ($rental->tenat_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // Pastikan transaksi sudah selesai
        if ($rental->status !== 'selesai') {
            return redirect()->route('riwayat.transaksi.penyewa')->with('error', 'Transaksi belum selesai.');
        }

        // Opsional: Cek apakah ulasan sudah pernah diberikan untuk mencegah duplikasi
        // if (Review::where('rental_id', $rental->id)->exists()) {
        //     return redirect()->route('riwayat.transaksi.penyewa')->with('error', 'Anda sudah memberikan penilaian untuk transaksi ini.');
        // }

        return view('pages.reviews.create', compact('rental'));
    }

    public function store(Request $request, Rental $rental)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Max 10MB
        ]);

        $data = [
            'rental_id' => $rental->id,
            'item_id'   => $rental->item_id,
            'user_id'   => Auth::id(),
            'rating'    => $request->rating,
            'comment'   => $request->comment,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        \App\Models\Review::create($data);

        return redirect()->route('riwayat.transaksi.penyewa')->with('success_title', 'Ulasan Terkirim')->with('success_message', 'Terima kasih atas penilaian Anda!');
    }
}