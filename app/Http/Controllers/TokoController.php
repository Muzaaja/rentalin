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
        // Ambil data step 1 dari session jika user kembali mengedit
        $data = session('toko_step1', []);
        
        // UBAH: Mengarah ke file step1Toko.blade.php di folder store
        return view('pages.store.step1Toko', compact('data'));
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/step-1
    // Simpan sementara data Step 1 ke session, lanjut ke Step 2
    // ─────────────────────────────────────────
    public function simpanStep1(Request $request)
    {
        $validated = $request->validate([
            'nama_toko'          => 'required|string|max:100',
            'alamat_toko'        => 'required|string|max:255',
            'deskripsi'          => 'nullable|string|max:500',
            'no_telepon'         => 'required|string|max:20',
            'metode_pengiriman'  => 'required|string|max:100',
        ]);

        // Simpan di session sementara (belum masuk DB)
        session(['toko_step1' => $validated]);

        return redirect()->route('toko.step2');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/step-2
    // Tampilkan form Verifikasi (Step 2)
    // ─────────────────────────────────────────
    public function step2()
    {
        // Jika step 1 belum diisi, redirect balik ke step 1
        if (!session('toko_step1')) {
            return redirect()->route('toko.step1')
                ->with('error', 'Harap isi informasi toko terlebih dahulu.');
        }

        $data = session('toko_step2', []);
        
        // UBAH: Mengarah ke file step2Toko.blade.php di folder store
        return view('pages.store.step2Toko', compact('data'));
    }

    // ─────────────────────────────────────────
    // POST /toko/buat/step-2
    // Simpan semua data ke DB, hapus session, redirect ke selesai
    // ─────────────────────────────────────────
    public function simpanStep2(Request $request)
    {
        $validated = $request->validate([
            'nik'                    => 'required|digits:16',
            'nama_lengkap_ktp'       => 'required|string|max:100',
            'foto_ktp'               => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_selfie'            => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'nama_bank'              => 'required|string|max:50',
            'nomor_rekening'         => 'required|string|max:30',
            'nama_pemilik_rekening'  => 'required|string|max:100',
        ]);

        // Upload foto KTP & selfie ke storage
        $pathKtp    = $request->file('foto_ktp')->store('toko/ktp', 'public');
        $pathSelfie = $request->file('foto_selfie')->store('toko/selfie', 'public');

        // Ambil data step 1 dari session
        $step1 = session('toko_step1');

        // Gabungkan semua dan simpan ke database
        Toko::create([
            'user_id'               => Auth::id(),
            // Step 1
            'nama_toko'             => $step1['nama_toko'],
            'alamat_toko'           => $step1['alamat_toko'],
            'deskripsi'             => $step1['deskripsi'] ?? null,
            'no_telepon'            => $step1['no_telepon'],
            'metode_pengiriman'     => $step1['metode_pengiriman'],
            // Step 2 identitas
            'nik'                   => $validated['nik'],
            'nama_lengkap_ktp'      => $validated['nama_lengkap_ktp'],
            'foto_ktp'              => $pathKtp,
            'foto_selfie'           => $pathSelfie,
            // Step 2 rekening
            'nama_bank'             => $validated['nama_bank'],
            'nomor_rekening'        => $validated['nomor_rekening'],
            'nama_pemilik_rekening' => $validated['nama_pemilik_rekening'],
            // Status default pending (menunggu verifikasi admin)
            'status'                => 'pending',
        ]);

        // Hapus session setelah tersimpan
        session()->forget(['toko_step1', 'toko_step2']);

        return redirect()->route('toko.selesai');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/selesai
    // Halaman konfirmasi toko berhasil dibuat
    // ─────────────────────────────────────────
    public function selesai()
    {
        // UBAH: Mengarah ke file selesaiToko.blade.php di folder store
        return view('pages.store.selesaiToko');
    }
}