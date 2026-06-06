<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TokoController extends Controller
{
    // ─────────────────────────────────────────
    // GET /toko/mulai
    // Halaman landing "Mulai sewakan barangmu"
    // ─────────────────────────────────────────
    public function mulai()
    {
        return view('pages.store.bukaToko');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/step-1
    // Tampilkan form Info Toko (Step 1)
    // ─────────────────────────────────────────
    public function step1()
    {
        $data = session('toko_step1', []);
        return view('pages.store.step1Toko', compact('data'));
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/step-1
    // Simpan sementara data Step 1 ke session, lanjut ke Step 2
    // ─────────────────────────────────────────
    public function simpanStep1(Request $request)
    {
        $validated = $request->validate([
            'nama_toko'   => 'required|string|max:100',
            'alamat_toko' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string|max:500',
            'no_telepon'  => 'required|string|max:20',
        ]);

        session(['toko_step1' => $validated]);

        return redirect()->route('store.step2Toko');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/step-2
    // Tampilkan form Verifikasi (Step 2)
    // ─────────────────────────────────────────
    public function step2()
    {
        if (!session('toko_step1')) {
            return redirect()->route('store.step1Toko')
                ->with('error', 'Harap isi informasi toko terlebih dahulu.');
        }

        $data = session('toko_step2', []);
        return view('pages.store.step2Toko', compact('data'));
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/step-2
    // Simpan semua data ke DB, hapus session, redirect ke selesai
    // ─────────────────────────────────────────
    public function simpanStep2(Request $request)
    {
        $validated = $request->validate([
            'nik'                   => 'required|digits:16',
            'nama_lengkap_ktp'      => 'required|string|max:100',
            'foto_ktp'              => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_selfie'           => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'nama_bank'             => 'required|string|max:50',
            'nomor_rekening'        => 'required|string|max:30',
            'nama_pemilik_rekening' => 'required|string|max:100',
        ]);

        $pathKtp    = $request->file('foto_ktp')->store('toko/ktp', 'public');
        $pathSelfie = $request->file('foto_selfie')->store('toko/selfie', 'public');

        $step1 = session('toko_step1');

        \App\Models\Toko::create([
            'user_id'               => Auth::id(),
            'nama_toko'             => $step1['nama_toko'],
            'alamat_toko'           => $step1['alamat_toko'],
            'deskripsi'             => $step1['deskripsi'] ?? null,
            'no_telepon'            => $step1['no_telepon'],
            'nik'                   => $validated['nik'],
            'nama_lengkap_ktp'      => $validated['nama_lengkap_ktp'],
            'foto_ktp'              => $pathKtp,
            'foto_selfie'           => $pathSelfie,
            'nama_bank'             => $validated['nama_bank'],
            'nomor_rekening'        => $validated['nomor_rekening'],
            'nama_pemilik_rekening' => $validated['nama_pemilik_rekening'],
            'status'                => 'pending',
        ]);

        session()->forget(['toko_step1', 'toko_step2']);

        return redirect()->route('store.selesaiToko');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/selesai
    // Halaman konfirmasi toko berhasil dibuat
    // ─────────────────────────────────────────
    public function selesai()
    {
        return view('pages.store.selesaiToko');
    }

    // ─────────────────────────────────────────
    // Cek apakah user sudah punya toko
    // ─────────────────────────────────────────
    public function cekToko()
    {
        $toko = Toko::where('user_id', Auth::id())->first();

        if ($toko) {
            return redirect()->route('store.dashboardToko');
        }

        return redirect()->route('store.bukaToko');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/dashboard
    // Dashboard utama toko
    // ─────────────────────────────────────────
    public function dashboardToko()
    {
        $toko = Auth::user()->toko;
        return view('pages.store.dashboard.dashboardToko', compact('toko'));
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/pengaturan
    // Halaman Informasi Toko
    // ─────────────────────────────────────────
    public function pengaturan()
    {
        $toko = Auth::user()->toko;
        return view('pages.store.pengaturan.informasiToko', compact('toko'));
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/pengaturan/update-nama
    // ─────────────────────────────────────────
    public function updateNama(Request $request)
    {
        $request->validate(['nama_toko' => 'required|string|max:100']);

        Auth::user()->toko->update(['nama_toko' => $request->nama_toko]);

        return response()->json(['success' => true, 'nama_toko' => $request->nama_toko]);
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/pengaturan/update-deskripsi
    // ─────────────────────────────────────────
    public function updateDeskripsi(Request $request)
    {
        $request->validate(['deskripsi' => 'required|string|max:500']);

        Auth::user()->toko->update(['deskripsi' => $request->deskripsi]);

        return response()->json(['success' => true, 'deskripsi' => $request->deskripsi]);
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/pengaturan/update-foto
    // ─────────────────────────────────────────
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_toko' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $toko = Auth::user()->toko;

        // Hapus foto lama kalau ada
        if ($toko->foto_toko) {
            Storage::disk('public')->delete($toko->foto_toko);
        }

        $path = $request->file('foto_toko')->store('toko/foto', 'public');
        $toko->update(['foto_toko' => $path]);

        return response()->json([
            'success'  => true,
            'foto_url' => asset('storage/' . $path),
        ]);
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/pengaturan/update-rekening
    // ─────────────────────────────────────────
    public function updateRekening(Request $request)
    {
        $request->validate([
            'nama_bank'             => 'required|string|max:50',
            'nomor_rekening'        => 'required|string|max:30',
            'nama_pemilik_rekening' => 'required|string|max:100',
        ]);

        Auth::user()->toko->update($request->only([
            'nama_bank',
            'nomor_rekening',
            'nama_pemilik_rekening',
        ]));

        return response()->json(['success' => true]);
    }
}