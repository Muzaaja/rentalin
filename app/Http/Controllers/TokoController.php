<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;

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
            'nama_toko'   => 'required|string|max:50',
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
            'nama_lengkap_ktp'      => 'required|string|max:60',
            'foto_ktp'              => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'foto_selfie'           => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'nama_bank'             => 'required|string|max:20',
            'nomor_rekening'        => 'required|string|max:20',
            'nama_pemilik_rekening' => 'required|string|max:60',
        ]);

        $namaKtp = strtolower(trim($request->nama_lengkap_ktp));
        $namaRekening = strtolower(trim($request->nama_pemilik_rekening));

        if ($namaKtp !== $namaRekening) {
            return back()
                ->withErrors(['nama_pemilik_rekening' => 'Gagal! Nama Pemilik Rekening harus sama persis dengan Nama di KTP.'])
                ->withInput(); 
        }

        $pathKtp    = $request->file('foto_ktp')->store('toko/ktp', 'public');
        $pathSelfie = $request->file('foto_selfie')->store('toko/selfie', 'public');

        $step1 = session('toko_step1');

        // Gunakan updateOrCreate untuk mencegah duplikasi, mereset status, dan menghapus notes lama
        \App\Models\Toko::updateOrCreate(
            ['user_id' => \Illuminate\Support\Facades\Auth::id()],
            [
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
                'status'                => 'pending', // Reset kembali ke pending
                'notes'                 => null,      // Kosongkan alasan penolakan sebelumnya
            ]
        );

        session()->forget(['toko_step1', 'toko_step2']);

        return redirect()->route('store.selesaiToko');
    }

    // ─────────────────────────────────────────
    // GET /toko/buat/selesai
    // Halaman konfirmasi toko (Pending / Rejected)
    // ─────────────────────────────────────────
    public function selesai()
    {
        // Ambil data toko user yang sedang login
        $toko = Auth::user()->toko;

        // Jika tidak ada toko, kembali ke step 1
        if (!$toko) {
            return redirect()->route('store.bukaToko');
        }

        // Jika status toko sudah disetujui (approved), arahkan ke dashboard
        if ($toko->status === 'approved') {
            return redirect()->route('store.dashboardToko');
        }

        // Tampilkan halaman selesai dengan membawa data toko (untuk cek status pending/rejected)
        return view('pages.store.selesaiToko', compact('toko'));
    }

    // ─────────────────────────────────────────
    // Cek apakah user sudah punya toko dan statusnya
    // ─────────────────────────────────────────
    public function cekToko()
    {
        $toko = \App\Models\Toko::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();

        if ($toko) {
            // Cek statusnya. Jika belum approved, arahkan ke halaman selesai (menunggu verifikasi / ditolak)
            if ($toko->status !== 'approved') {
                return redirect()->route('store.selesaiToko');
            }
            // Jika sudah approved, baru arahkan ke dashboard
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

        if (!$toko || $toko->status !== 'approved') {
            return redirect()->route('store.selesaiToko')->with('error', 'Toko Anda belum diverifikasi.');
        }

        // 1. Ambil data produk dinamis milik user
        $products = \App\Models\Item::where('user_id', Auth::id())->get();

        // 2. Ambil notifikasi dinamis milik user
        $notifications = \App\Models\Notification::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        // 3. HITUNG PENILAIAN SECARA DINAMIS ASLI DARI DATABASE
        // Menghitung jumlah ulasan asli yang masuk untuk barang-barang milik toko ini
        // Jika kelompokmu belum membuat tabel review, default-nya akan bernilai 0
        try {
            $countPenilaian = \App\Models\Review::where('toko_id', $toko->id)->count();
            
            // Opsional: Jika ingin mengambil rata-rata bintang (misal: 4.8)
            $averageRating = \App\Models\Review::where('toko_id', $toko->id)->avg('rating') ?? 0;
            $averageRating = round($averageRating, 1);
        } catch (\Exception $e) {
            // Fallback aman jika migrasi tabel review kelompokmu belum ada / berbeda nama
            $countPenilaian = 0;
            $averageRating = 0;
        }

        // Sisa counter transaksi lainnya (sesuaikan dengan variabel kelompokmu jika ada)
        $countPerluDikirim = 0; 
        $countBermasalah = 0;
        $countPengembalian = 0;

        return view('pages.store.dashboardStore.dashboardToko', compact(
            'toko', 
            'products', 
            'notifications', 
            'countPenilaian', 
            'averageRating',
            'countPerluDikirim',
            'countBermasalah',
            'countPengembalian'
        ));
    }

    /// ─────────────────────────────────────────
    // GET /toko/buat/pengaturan
    // Halaman Informasi Toko
    // ─────────────────────────────────────────
    public function pengaturan(Request $request) // <-- Tambahkan parameter Request di sini
    {
        $toko = Auth::user()->toko;
        
        // Tangkap parameter 'tab' dari URL. Jika tidak ada klik dari dashboard, default ke 'profil'
        $activeTab = $request->query('tab', 'profil');
        
        // PERBAIKAN: Kirim $activeTab ke dalam view bersama $toko
        return view('pages.store.dashboardStore.informasiToko', compact('toko', 'activeTab'));
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
    
    public function ulasan()
    {
        // Menggunakan ID User yang sedang login karena tabel items terikat ke user_id
        $userId = \Illuminate\Support\Facades\Auth::id();
        
        $reviews = Review::whereHas('item', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('user')->latest()->paginate(10);
        
        $totalUlasan = Review::whereHas('item', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();
            
        $averageRating = Review::whereHas('item', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->avg('rating') ?? 0.0;
                
        $ratingDistribution = [];
        foreach ([5, 4, 3, 2, 1] as $star) {
            $ratingDistribution[$star] = Review::whereHas('item', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('rating', $star)->count();
        }
        
        return view('pages.store.dashboardStore.ulasanToko', compact('reviews', 'totalUlasan', 'averageRating', 'ratingDistribution'));
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