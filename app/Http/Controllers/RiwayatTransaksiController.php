<?php

namespace App\Http\Controllers;

use App\Models\DamageClaim;
use App\Models\Item;
use App\Models\Rental;
use App\Models\RentalDocument;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Filter Status Penyewa
    |--------------------------------------------------------------------------
    */

    private function filtersPenyewa(): array
    {
        return [
            'semua' => 'Semua',
            'diproses' => 'Diproses',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'selesai' => 'Selesai',
            'bermasalah' => 'Bermasalah',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Filter Status Pemilik
    |--------------------------------------------------------------------------
    */

    private function filtersPemilik(): array
    {
        return [
            'semua' => 'Semua',
            'pesanan_masuk' => 'Pesanan Masuk',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'selesai' => 'Selesai',
            'bermasalah' => 'Bermasalah',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Query Rental dengan Relasi
    |--------------------------------------------------------------------------
    */

    private function queryRentalDenganRelasi()
    {
        return Rental::with([
            'item',
            'owner',
            'tenant',
            'payment',
            'documents',
            'damageClaim',
        ])->latest();
    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Kelengkapan Barang dari Item
    |--------------------------------------------------------------------------
    | Data utama diambil dari items.kelengkapan.
    | Bisa berbentuk array, JSON, atau teks dipisah koma/enter.
    */

    private function ambilKelengkapanBarang(Rental $rental): array
    {
        $kelengkapan = optional($rental->item)->kelengkapan;

        if (!$kelengkapan) {
            return [];
        }

        if (is_array($kelengkapan)) {
            return array_values(array_filter(array_map('trim', $kelengkapan)));
        }

        $decoded = json_decode($kelengkapan, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter(array_map('trim', $decoded)));
        }

        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n|,/', $kelengkapan))));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Dokumentasi Rental
    |--------------------------------------------------------------------------
    */

    private function simpanDokumenRental(Request $request, Rental $rental, string $process): void
    {
        if (!$request->hasFile('foto_bukti')) {
            return;
        }

        foreach ($request->file('foto_bukti') as $file) {
            $path = $file->store('rental-documents', 'public');

            RentalDocument::create([
                'rental_id' => $rental->id,
                'process' => $process,
                'image' => $path,
            ]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat Transaksi Penyewa
    |--------------------------------------------------------------------------
    */

    public function penyewa(Request $request)
    {
        $statusAktif = $request->query('status', 'semua');
        $filters = $this->filtersPenyewa();

        $query = $this->queryRentalDenganRelasi();

        if ($statusAktif !== 'semua') {
            if ($statusAktif === 'bermasalah') {
                $query->whereIn('status', [
                    'belum_dikembalikan',
                    'kerusakan',
                    'dibatalkan',
                ]);
            } else {
                $query->where('status', $statusAktif);
            }
        }

        $rentals = $query->paginate(5)->withQueryString();

        return view('pages.transactions.transactions-history.riwayatTransaksiPenyewa', compact(
            'rentals',
            'filters',
            'statusAktif'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Riwayat Transaksi Pemilik
    |--------------------------------------------------------------------------
    */

    public function pemilik(Request $request)
    {
        $statusAktif = $request->query('status', 'semua');
        $filters = $this->filtersPemilik();

        $query = $this->queryRentalDenganRelasi();

        if ($statusAktif !== 'semua') {
            if ($statusAktif === 'bermasalah') {
                $query->whereIn('status', [
                    'belum_dikembalikan',
                    'kerusakan',
                    'dibatalkan',
                ]);
            } else {
                $query->where('status', $statusAktif);
            }
        }

        $rentals = $query->paginate(5)->withQueryString();

        return view('pages.transactions.transactions-history.riwayatTransaksiPemilik', compact(
            'rentals',
            'filters',
            'statusAktif'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Detail Transaksi
    |--------------------------------------------------------------------------
    */

    public function detail($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.transactions.transactions-detail.detailTransaksi', compact('rental'));
    }

    /*
    |--------------------------------------------------------------------------
    | Form Konfirmasi Penerimaan Penyewa
    |--------------------------------------------------------------------------
    */

    public function formKonfirmasiPenerimaan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPenerimaan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Konfirmasi Penerimaan Penyewa
    |--------------------------------------------------------------------------
    | Catatan dihapus.
    | Data yang disimpan:
    | - foto dokumentasi
    | - checklist kelengkapan diterima
    | - status lengkap/tidak lengkap
    */

    public function simpanKonfirmasiPenerimaan(Request $request, $id)
    {
        $request->validate([
            'acceptance_complete' => 'nullable|in:ya,tidak',
            'penerimaan_lengkap' => 'nullable|in:ya,tidak',

            'kelengkapan' => 'nullable|array',
            'kelengkapan.*' => 'nullable|string',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'tenant_acceptance');

        $penerimaanLengkap = $request->input('acceptance_complete')
            ?? $request->input('penerimaan_lengkap')
            ?? 'ya';

        $kelengkapanDiterima = $request->input('kelengkapan', []);

        if ($penerimaanLengkap === 'ya') {
            $rental->update([
                'status' => 'disewa',
                'acceptance_complete' => true,
                'acceptance_note' => null,
                'accepted_checklist' => $kelengkapanDiterima,
            ]);

            Item::where('id', $rental->item_id)->update([
                'status' => 'rented',
            ]);

            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('success', 'Penerimaan berhasil dikonfirmasi. Status transaksi berubah menjadi Disewa.');
        }

        $rental->update([
            'status' => 'pengembalian',
            'acceptance_complete' => false,
            'acceptance_note' => null,
            'accepted_checklist' => $kelengkapanDiterima,
        ]);

        Item::where('id', $rental->item_id)->update([
            'status' => 'rented',
        ]);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success', 'Barang tidak lengkap. Transaksi dialihkan ke proses pengembalian.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Pesanan Dikembalikan Penyewa
    |--------------------------------------------------------------------------
    */

    public function formPesananDikembalikan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.pesananDikembalikan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Pesanan Dikembalikan Penyewa
    |--------------------------------------------------------------------------
    | Catatan dihapus.
    | Data yang disimpan:
    | - foto dokumentasi pengembalian
    | - checklist barang yang dikembalikan penyewa
    */

    public function simpanPesananDikembalikan(Request $request, $id)
    {
        $request->validate([
            'kelengkapan_dikembalikan' => 'nullable|array',
            'kelengkapan_dikembalikan.*' => 'nullable|string',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'tenant_return');

        $rental->update([
            'status' => 'pengembalian',
            'return_note' => null,
            'tenant_return_checklist' => $request->input('kelengkapan_dikembalikan', []),
        ]);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success', 'Pesanan berhasil ditandai dikembalikan. Menunggu konfirmasi pemilik.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Perpanjangan Sewa
    |--------------------------------------------------------------------------
    */

    public function formPerpanjanganSewa($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.perpanjanganSewa.perpanjanganSewa', compact('rental'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Perpanjangan Sewa
    |--------------------------------------------------------------------------
    */

    public function simpanPerpanjanganSewa(Request $request, $id)
    {
        $request->validate([
            'end_date' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'durasi_tambahan' => 'nullable|integer|min:1',
        ]);

        $rental = Rental::findOrFail($id);

        if ($request->filled('durasi_tambahan')) {
            $tanggalBaru = \Carbon\Carbon::parse($rental->end_date)
                ->addDays((int) $request->durasi_tambahan)
                ->format('Y-m-d');
        } else {
            $tanggalBaru = $request->input('end_date')
                ?? $request->input('tanggal_selesai');
        }

        if (!$tanggalBaru) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal atau durasi perpanjangan belum dipilih.');
        }

        $rental->update([
            'end_date' => $tanggalBaru,
        ]);

        return redirect()
            ->route('transaksi.detail', $rental->id)
            ->with('success', 'Perpanjangan sewa berhasil. Tanggal pengembalian diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Konfirmasi Pengiriman Pemilik
    |--------------------------------------------------------------------------
    */

    public function formKonfirmasiPengiriman($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPengiriman', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Konfirmasi Pengiriman Pemilik
    |--------------------------------------------------------------------------
    | Catatan dihapus.
    | Data yang disimpan:
    | - nomor resi
    | - foto dokumentasi
    | - checklist kelengkapan barang keluar
    */

    public function simpanKonfirmasiPengiriman(Request $request, $id)
    {
        $request->validate([
            'nomor_resi' => 'nullable|string|max:100',

            'kelengkapan_keluar' => 'nullable|array',
            'kelengkapan_keluar.*' => 'nullable|string',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_shipping');

        $rental->update([
            'status' => 'menunggu_penerimaan',
            'outgoing_checklist' => $request->input('kelengkapan_keluar', []),
        ]);

        return redirect()
            ->route('riwayat.transaksi.pemilik')
            ->with('success', 'Pengiriman berhasil dikonfirmasi. Menunggu penerimaan dari penyewa.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Konfirmasi Penyerahan Pemilik
    |--------------------------------------------------------------------------
    */

    public function formKonfirmasiPenyerahan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPenyerahan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Konfirmasi Penyerahan Pemilik
    |--------------------------------------------------------------------------
    | Catatan dihapus.
    | Data yang disimpan:
    | - foto dokumentasi
    | - checklist kelengkapan barang keluar
    */

    public function simpanKonfirmasiPenyerahan(Request $request, $id)
    {
        $request->validate([
            'kelengkapan_keluar' => 'nullable|array',
            'kelengkapan_keluar.*' => 'nullable|string',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_handover');

        $rental->update([
            'status' => 'menunggu_penerimaan',
            'outgoing_checklist' => $request->input('kelengkapan_keluar', []),
        ]);

        return redirect()
            ->route('riwayat.transaksi.pemilik')
            ->with('success', 'Penyerahan berhasil dikonfirmasi. Menunggu penerimaan dari penyewa.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Konfirmasi Pengembalian Pemilik
    |--------------------------------------------------------------------------
    */

    public function formKonfirmasiPengembalian($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPengembalian', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Konfirmasi Pengembalian Pemilik
    |--------------------------------------------------------------------------
    | Catatan dihapus.
    | Data yang disimpan:
    | - foto dokumentasi pemeriksaan
    | - checklist kelengkapan kembali
    | - kondisi aman/rusak
    */

    public function simpanKonfirmasiPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_barang' => 'nullable|in:aman,rusak',
            'kondisi_pengembalian' => 'nullable|in:aman,rusak',

            'kelengkapan_kembali' => 'nullable|array',
            'kelengkapan_kembali.*' => 'nullable|string',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_return_check');

        $kondisiBarang = $request->input('kondisi_barang')
            ?? $request->input('kondisi_pengembalian')
            ?? 'aman';

        $kelengkapanKembali = $request->input('kelengkapan_kembali', []);

        if ($kondisiBarang === 'aman') {
            $rental->update([
                'status' => 'selesai',
                'return_note' => null,
                'returned_checklist' => $kelengkapanKembali,
            ]);

            Item::where('id', $rental->item_id)->update([
                'status' => 'available',
            ]);

            return redirect()
                ->route('riwayat.transaksi.pemilik')
                ->with('success', 'Pengembalian berhasil dikonfirmasi. Transaksi selesai.');
        }

        $rental->update([
            'status' => 'kerusakan',
            'return_note' => null,
            'returned_checklist' => $kelengkapanKembali,
        ]);

        return redirect()
            ->route('transaksi.formPengajuanKerusakan', $rental->id)
            ->with('success', 'Barang bermasalah. Silakan ajukan klaim kerusakan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Form Pengajuan Kerusakan Pemilik
    |--------------------------------------------------------------------------
    */

    public function formPengajuanKerusakan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.damage-submission.pengajuanKerusakan', compact('rental'));
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Pengajuan Kerusakan Pemilik
    |--------------------------------------------------------------------------
    | Deskripsi tetap dipakai karena ini bukan catatan konfirmasi biasa,
    | tapi laporan kerusakan.
    */

    public function simpanPengajuanKerusakan(Request $request, $id)
    {
        $request->validate([
            'damage_type' => 'nullable|string',
            'damage_part' => 'nullable|string',
            'description' => 'nullable|string',
            'repair_fee' => 'nullable|numeric|min:0',

            'jenis_kerusakan' => 'nullable|string',
            'bagian_rusak' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'biaya_perbaikan' => 'nullable|numeric|min:0',

            'foto_bukti.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'damage_claim');

        $damageType = $request->input('damage_type')
            ?? $request->input('jenis_kerusakan');

        $damagePart = $request->input('damage_part')
            ?? $request->input('bagian_rusak');

        $description = $request->input('description')
            ?? $request->input('deskripsi');

        $repairFee = $request->input('repair_fee')
            ?? $request->input('biaya_perbaikan')
            ?? 0;

        if (!$damageType || !$damagePart || !$description) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Jenis kerusakan, bagian rusak, dan deskripsi wajib diisi.');
        }

        DamageClaim::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'damage_type' => $damageType,
                'damage_part' => $damagePart,
                'description' => $description,
                'repair_fee' => $repairFee,
                'status' => 'submitted',
            ]
        );

        $rental->update([
            'status' => 'kerusakan',
            'damage_description' => $description,
            'damage_fee' => $repairFee,
        ]);

        return redirect()
            ->route('transaksi.lihatKlaim', $rental->id)
            ->with('success', 'Klaim kerusakan berhasil diajukan.');
    }

    /*
    |--------------------------------------------------------------------------
    | Lihat Klaim Kerusakan Penyewa
    |--------------------------------------------------------------------------
    */

    public function lihatKlaim($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.damage-submission.klaimKerusakan', compact('rental'));
    }

    /*
    |--------------------------------------------------------------------------
    | Setujui Klaim Kerusakan Penyewa
    |--------------------------------------------------------------------------
    */

    public function setujuiKlaim($id)
    {
        $rental = Rental::with(['item', 'damageClaim'])->findOrFail($id);

        if ($rental->damageClaim) {
            $rental->damageClaim->update([
                'status' => 'accepted',
            ]);
        }

        $rental->update([
            'status' => 'selesai',
        ]);

        Item::where('id', $rental->item_id)->update([
            'status' => 'available',
        ]);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success', 'Klaim kerusakan berhasil disetujui. Transaksi diselesaikan.');
    }
}