<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    // ─────────────────────────────────────────
    // GET /toko/keuangan
    // Halaman keuangan + riwayat penarikan
    // ─────────────────────────────────────────
    public function index()
    {
        $toko = Toko::where('user_id', Auth::id())->first();

        // Riwayat penarikan milik user ini
        $withdrawals = Withdrawal::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Hitung total pendapatan dari rental selesai (simulasi)
        $totalPendapatan = \App\Models\Rental::where('owner_id', Auth::id())
            ->where('status', 'selesai')
            ->sum('total_price');

        // Hitung total yang sudah ditarik (status selesai)
        $totalDitarik = Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'diproses'])
            ->sum('jumlah');

        // Saldo = pendapatan - penarikan
        $saldo = max(0, $totalPendapatan - $totalDitarik);

        return view('pages.store.dashboardStore.keuanganToko', compact(
            'toko', 'withdrawals', 'totalPendapatan', 'saldo'
        ));
    }

    // ─────────────────────────────────────────
    // GET /toko/keuangan/tarik
    // Form tarik saldo
    // ─────────────────────────────────────────
    public function formTarik()
    {
        $toko = Toko::where('user_id', Auth::id())->first();

        if (!$toko) {
            return redirect()->route('store.bukaToko')
                ->with('error', 'Kamu belum memiliki toko.');
        }

        // Hitung saldo tersedia
        $totalPendapatan = \App\Models\Rental::where('owner_id', Auth::id())
            ->where('status', 'selesai')
            ->sum('total_price');

        $totalDitarik = Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'diproses'])
            ->sum('jumlah');

        $saldo = max(0, $totalPendapatan - $totalDitarik);

        return view('pages.store.dashboardStore.tarikSaldo', compact('toko', 'saldo'));
    }

    // ─────────────────────────────────────────
    // POST /toko/keuangan/tarik
    // Proses tarik saldo
    // ─────────────────────────────────────────
    public function prosesTarik(Request $request)
    {
        $request->validate([
            'jumlah'          => 'required|numeric|min:10000',
            'nama_bank'       => 'required|string|max:100',
            'nomor_rekening'  => 'required|string|max:50',
            'nama_pemilik'    => 'required|string|max:100',
        ], [
            'jumlah.min' => 'Minimum penarikan adalah Rp 10.000',
        ]);

        // Hitung saldo tersedia
        $totalPendapatan = \App\Models\Rental::where('owner_id', Auth::id())
            ->where('status', 'selesai')
            ->sum('total_price');

        $totalDitarik = Withdrawal::where('user_id', Auth::id())
            ->whereIn('status', ['selesai', 'diproses'])
            ->sum('jumlah');

        $saldo = max(0, $totalPendapatan - $totalDitarik);

        if ($request->jumlah > $saldo) {
            return back()->withErrors(['jumlah' => 'Jumlah penarikan melebihi saldo tersedia.'])->withInput();
        }

        $withdrawal = Withdrawal::create([
            'user_id'        => Auth::id(),
            'jumlah'         => $request->jumlah,
            'nama_bank'      => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik'   => $request->nama_pemilik,
            'ref_code'       => Withdrawal::generateRefCode(),
            'status'         => 'diproses',
        ]);

        return redirect()->route('store.tarikSaldo.sukses', $withdrawal->id);
    }

    // ─────────────────────────────────────────
    // GET /toko/keuangan/tarik/sukses/{id}
    // Halaman sukses setelah tarik saldo
    // ─────────────────────────────────────────
    public function suksesTarik(Withdrawal $withdrawal)
    {
        // Pastikan hanya pemilik yang bisa lihat
        if ($withdrawal->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.store.dashboardStore.tarikSaldoSukses', compact('withdrawal'));
    }
}