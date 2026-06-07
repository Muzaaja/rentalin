<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kyc;
use App\Models\Toko;
use Illuminate\Http\Request;

class KycAdminController extends Controller
{
    // ==========================================
    // BAGIAN KYC USER
    // ==========================================

    /**
     * Menampilkan tabel antrean verifikasi KYC User.
     */
    public function userIndex()
    {
        // Mengambil semua KYC yang masih pending, beserta data user-nya
        // Diurutkan dari yang paling lama mengajukan (First In, First Out)
        $pendingKycs = Kyc::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.admin.kyc_user.index', compact('pendingKycs'));
    }

    /**
     * Memproses persetujuan KYC User.
     */
    public function approveUser(Request $request, $id)
    {
        $kyc = Kyc::findOrFail($id);
        
        // Memperbarui status di tabel kycs
        $kyc->update(['status' => 'approved']);

        // Opsional: Jika Anda ingin menandai user sebagai terverifikasi di tabel users
        // $kyc->user->update(['is_verified' => true]);

        return redirect()->route('admin.kyc_user.index')->with('success', 'Verifikasi KYC User berhasil disetujui.');
    }

    /**
     * Memproses penolakan KYC User.
     */
    public function rejectUser(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $kyc = Kyc::findOrFail($id);
        
        // Memperbarui status
        $kyc->update(['status' => 'rejected']);

        // Catatan: Karena di tabel kycs Anda tidak ada kolom 'rejection_reason',
        // alasan penolakan saat ini tidak tersimpan ke database.
        // Jika ingin menyimpan alasan ini, Anda perlu membuat migration untuk menambah kolom 'rejection_reason' di tabel kycs.

        return redirect()->route('admin.kyc_user.index')->with('success', 'Verifikasi KYC User telah ditolak.');
    }


    // ==========================================
    // BAGIAN KYC TOKO
    // ==========================================

    /**
     * Menampilkan tabel antrean verifikasi KYC Toko.
     */
    public function tokoIndex()
    {
        // Mengambil semua pendaftaran toko yang masih pending
        $pendingToko = Toko::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('pages.admin.kyc_toko.index', compact('pendingToko'));
    }

    /**
     * Memproses persetujuan KYC Toko.
     */
    public function approveToko(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);
        
        // Memperbarui status toko
        $toko->update(['status' => 'approved']);

        return redirect()->route('admin.kyc_toko.index')->with('success', 'Verifikasi Toko berhasil disetujui.');
    }

    /**
     * Memproses penolakan KYC Toko.
     */
    public function rejectToko(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000'
        ]);

        $toko = Toko::findOrFail($id);
        
        // Memperbarui status toko
        $toko->update(['status' => 'rejected']);

        // Sama seperti KYC User, alasan penolakan belum tersimpan di tabel toko
        // karena belum ada kolom 'rejection_reason'.

        return redirect()->route('admin.kyc_toko.index')->with('success', 'Verifikasi Toko telah ditolak.');
    }
}