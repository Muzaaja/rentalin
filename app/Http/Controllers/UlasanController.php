<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UlasanController extends Controller
{
    // Halaman daftar ulasan
    public function index()
    {
        // BENAR: Mengarah ke store/dashboardStore/ulasanToko.blade.php
        return view('pages.store.dashboardStore.ulasanToko'); 
    }

    // Halaman balas ulasan
    public function balas($id)
    {
        $review = (object) [
            'id' => $id,
            'nama_penyewa' => 'Cap America',
            'tanggal' => '14 April 1944',
            'rating' => 5,
            'komentar' => 'Buat menumpas nazi juga bisa',
            'produk' => 'labubu'
        ];

        // BENAR: Mengarah ke store/dashboardStore/balasUlasanToko.blade.php
        return view('pages.store.dashboardStore.balasUlasanToko', compact('review'));
    }

    // Proses simpan balasan
    public function simpanBalasan(Request $request, $id)
    {
        $request->validate([
            'reply_text' => 'required|string|min:5'
        ]);

        // Logika simpan ke DB nantinya taruh di sini

        return redirect()->route('store.pengaturan.ulasan')->with('success', 'Balasan berhasil dikirim!');
    }
}