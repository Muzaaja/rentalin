<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    // halaman form ulasan
    public function create(Rental $rental)
    {
        $rental->load([
            'item',
            'owner',
            'owner.toko',
            'tenant',
        ]);

        // cek penyewa
        if ((int) $rental->tenant_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // cek status transaksi
        if ($rental->status !== 'selesai') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Penilaian hanya bisa diberikan setelah transaksi selesai.');
        }

        // cek ulasan dobel
        $sudahAdaUlasan = Review::where('rental_id', $rental->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahAdaUlasan) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Anda sudah memberikan penilaian untuk transaksi ini.');
        }

        return view('pages.reviews.create', compact('rental'));
    }

    // simpan ulasan penyewa

    public function store(Request $request, Rental $rental)
    {
        $rental->load([
            'item',
            'owner',
            'owner.toko',
            'tenant',
        ]);

        // cek penyewa
        if ((int) $rental->tenant_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // cek status transaksi
        if ($rental->status !== 'selesai') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Penilaian hanya bisa diberikan setelah transaksi selesai.');
        }

        // validasi input form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|file|mimes:jpeg,png|max:10240',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.integer' => 'Rating tidak valid.',
            'rating.min' => 'Rating minimal 1.',
            'rating.max' => 'Rating maksimal 5.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
            'images.array' => 'Format upload foto tidak valid.',
            'images.max' => 'Maksimal upload 5 foto.',
            'images.*.file' => 'Format file harus JPEG atau PNG.',
            'images.*.mimes' => 'Format file harus JPEG atau PNG.',
            'images.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        // cek ulasan dobel
        $sudahAdaUlasan = Review::where('rental_id', $rental->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($sudahAdaUlasan) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Anda sudah memberikan penilaian untuk transaksi ini.');
        }

        $data = [
            'rental_id' => $rental->id,
            'item_id' => $rental->item_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('images')) {
            $reviewImages = [];

            foreach ($request->file('images') as $image) {
                $reviewImages[] = $image->store('reviews', 'public');
            }

            $data['image'] = json_encode($reviewImages);
        }

        Review::create($data);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Ulasan Terkirim')
            ->with('success_message', 'Terima kasih atas penilaian Anda!');
    }
}
