<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Models\AdditionalPayment;
use App\Models\DamageClaim;
use App\Models\Item;
use App\Models\Rental;
use App\Models\RentalCancellation;
use App\Models\RentalDocument;
use App\Models\RentalExtension;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatTransaksiController extends Controller
{
    // filter penyewa

    // filter status untuk tab penyewa

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

    // label status yang tampil di penyewa

    private function labelStatusPenyewa(string $status): string
    {
        return match ($status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'pesanan_masuk' => 'Diproses',
            'diproses' => 'Diproses',
            'dikirim' => 'Dikirim',
            'menunggu_penerimaan' => 'Dikirim',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'kerusakan' => 'Kerusakan',
            'dibatalkan' => 'Dibatalkan',
            'belum_dikembalikan' => 'Belum Dikembalikan',
            'selesai' => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }

    // filter pemilik

    // filter status untuk tab pemilik

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

    // label status yang tampil di pemilik

    private function labelStatusPemilik(string $status): string
    {
        return match ($status) {
            'pesanan_masuk' => 'Pesanan Masuk',
            'dikirim' => 'Dikirim',
            'menunggu_penerimaan' => 'Menunggu Penerimaan',
            'disewa' => 'Disewa',
            'pengembalian' => 'Pengembalian',
            'kerusakan' => 'Kerusakan',
            'dibatalkan' => 'Dibatalkan',
            'belum_dikembalikan' => 'Belum Dikembalikan',
            'selesai' => 'Selesai',
            default => 'Pesanan Masuk',
        };
    }

    // query rental relasi

    // query rental beserta relasinya

    private function queryRentalDenganRelasi()
    {
        return Rental::with([
            'item',
            'owner',
            'owner.toko',
            'tenant',
            'payment',
            'documents',
            'latestExtension',
            'damageClaim',
            'additionalPayments',
            'cancellation',
        ]);
    }

    // ambil kelengkapan barang

    // ambil daftar kelengkapan barang

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

    // simpan dokumentasi rental

    // simpan foto bukti transaksi

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

    // riwayat transaksi penyewa

    // halaman riwayat transaksi penyewa

    public function penyewa(Request $request)
    {
        $statusAktif = $request->query('status', 'semua');
        $filters = $this->filtersPenyewa();

        $query = $this->queryRentalDenganRelasi();

        if ($statusAktif !== 'semua') {
            if ($statusAktif === 'diproses') {
                $query->whereIn('status', [
                    'menunggu_pembayaran',
                    'pesanan_masuk',
                    'dikirim',
                    'menunggu_penerimaan',
                ]);
            } elseif ($statusAktif === 'bermasalah') {
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

    // riwayat transaksi pemilik

    // halaman riwayat transaksi pemilik

    public function pemilik(Request $request)
    {
        $statusAktif = $request->query('status', 'semua');
        $filters = $this->filtersPemilik();

        $query = $this->queryRentalDenganRelasi()
            ->where('status', '!=', 'menunggu_pembayaran');

        if ($statusAktif !== 'semua') {
            if ($statusAktif === 'pesanan_masuk') {
                $query->where('status', 'pesanan_masuk');
            } elseif ($statusAktif === 'bermasalah') {
                $query->whereIn('status', [
                    'belum_dikembalikan',
                    'kerusakan',
                    'dibatalkan',
                ]);
            } else {
                $query->where('status', $statusAktif);
            }
        }

        $rentals = $query->latest()->paginate(5)->withQueryString();

        return view('pages.transactions.transactions-history.riwayatTransaksiPemilik', compact(
            'rentals',
            'filters',
            'statusAktif'
        ));
    }

    // halaman panduan penyewa

    public function panduanPenyewa()
    {
        $role = 'penyewa';

        return view('pages.transactions.guide.panduanTransaksi', compact('role'));
    }

    // halaman panduan pemilik

    public function panduanPemilik()
    {
        $role = 'pemilik';

        return view('pages.transactions.guide.panduanTransaksi', compact('role'));
    }

    // konfirmasi pembayaran

    // form pembayaran manual lama

    public function formKonfirmasiPembayaran($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        if ($rental->status !== 'menunggu_pembayaran') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Pembayaran hanya bisa dilakukan untuk transaksi yang menunggu pembayaran.');
        }

        return view('pages.payment.konfirmasiPembayaran', compact('rental'));
    }

    // simpan pembayaran manual lama

    public function simpanKonfirmasiPembayaran(Request $request, $id)
    {
        // validasi input form
        $request->validate([
            'payment_type' => 'required|in:full,paylater',
            'payment_method' => 'required|in:qris,paylater',
            'installment_plan' => 'nullable|in:2,4',
        ]);

        $rental = Rental::with('payment')->findOrFail($id);

        if ($rental->status !== 'menunggu_pembayaran') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Transaksi ini sudah tidak berada pada status menunggu pembayaran.');
        }

        if ($request->payment_type === 'paylater') {
            $installmentPlan = (int) $request->installment_plan;

            if (!in_array($installmentPlan, [2, 4])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Pilih cicilan PayLater 2x atau 4x.');
            }

            $rental->payment()->updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'payment_method' => 'PayLater',
                    'payment_type' => 'paylater',
                    'installment_plan' => $installmentPlan,
                    'installment_paid' => 1,
                    'installment_due_days' => 14,
                    'next_due_date' => now()->addDays(14)->format('Y-m-d'),
                    'amount' => $rental->total_price,
                    'status' => 'paid',
                    'payment_status' => 'partially_paid',
                ]
            );
        } else {
            $rental->payment()->updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'payment_method' => 'QRIS',
                    'payment_type' => 'full',
                    'installment_plan' => null,
                    'installment_paid' => 0,
                    'installment_due_days' => null,
                    'next_due_date' => null,
                    'amount' => $rental->total_price,
                    'status' => 'paid',
                    'payment_status' => 'paid',
                ]
            );
        }

        $rental->update([
            'status' => 'pesanan_masuk',
        ]);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Pembayaran Berhasil')
            ->with('success_message', 'Pembayaran berhasil dikonfirmasi. Pesanan sedang diproses.');
    }

    // detail transaksi

    // halaman detail transaksi

    public function detail($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.transactions.transactions-detail.detailTransaksi', compact('rental'));
    }

    // pembatalan pesanan

    // form pembatalan pesanan

    public function formBatalkanPesanan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        if ($rental->status !== 'menunggu_pembayaran') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Pesanan hanya bisa dibatalkan sebelum pembayaran dilakukan.');
        }

        $refund = [
            'total_harga' => (float) ($rental->total_price ?? 0),
            'deposit' => 0,
            'potongan_pembatalan' => 0,
            'refund_amount' => 0,
            'keterangan' => 'Pesanan belum dibayar, sehingga tidak ada dana yang perlu dikembalikan.',
        ];

        return view('pages.cancel.cancelRental', compact(
            'rental',
            'refund'
        ));
    }

    // simpan pembatalan pesanan

    public function simpanBatalkanPesanan(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $rental = Rental::with(['payment', 'item'])->findOrFail($id);

        if ($rental->status !== 'menunggu_pembayaran') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Pesanan hanya bisa dibatalkan sebelum pembayaran dilakukan.');
        }

        RentalCancellation::updateOrCreate(
            ['rental_id' => $rental->id],
            [
                'cancelled_by' => 'penyewa',
                'reason' => $request->reason,
                'note' => $request->note,
                'refund_amount' => 0,
                'refund_status' => 'tidak_ada_refund',
            ]
        );

        $rental->update([
            'status' => 'dibatalkan',
        ]);

        if ($rental->item) {
            $rental->item->update([
                'status' => 'available',
            ]);
        }

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Pesanan Dibatalkan')
            ->with('success_message', 'Pesanan berhasil dibatalkan. Karena pesanan belum dibayar, tidak ada pengembalian dana.');
    }
    
    // form konfirmasi penerimaan

    // form konfirmasi penerimaan

    public function formKonfirmasiPenerimaan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPenerimaan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    // simpan konfirmasi penerimaan

    public function simpanKonfirmasiPenerimaan(Request $request, $id)
    {
        $request->validate([
            'acceptance_complete' => 'required|in:ya,tidak',

            'kelengkapan' => 'nullable|array',
            'kelengkapan.*' => 'nullable|string',

            'acceptance_note' => 'nullable|string',

            // foto bukti minimal 3 dan maksimal 5
            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        $rental = Rental::with('item')->findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'tenant_acceptance');

        $penerimaanLengkap = $request->input('acceptance_complete');
        $kelengkapanDiterima = $request->input('kelengkapan', []);
        $catatanPenerimaan = $request->input('acceptance_note');

        if ($penerimaanLengkap === 'ya') {
            // barang lengkap
            $rental->update([
                'status' => 'disewa',
                'acceptance_complete' => true,
                'acceptance_note' => $catatanPenerimaan,
                'accepted_checklist' => $kelengkapanDiterima,
            ]);

            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $rental->owner_id,
                    'Barang Diterima',
                    'Penyewa telah menerima barang.',
                    'receive',
                    'berhasil',
                    '/riwayatTransaksiPemilik',
                    $rental->id
                );
            }

            if ($rental->item) {
                $rental->item->update([
                    'status' => 'rented',
                ]);
            }

            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('success_title', 'Konfirmasi Penerimaan Berhasil')
                ->with('success_message', 'Penerimaan berhasil dikonfirmasi. Status transaksi berubah menjadi Disewa.');
        } else {
            // barang tidak lengkap
            $rental->update([
                'status' => 'pengembalian',
                'acceptance_complete' => false,
                'acceptance_note' => $catatanPenerimaan,
                'accepted_checklist' => $kelengkapanDiterima,
            ]);

            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $rental->owner_id,
                    'Penerimaan Tidak Lengkap',
                    'Penyewa melaporkan barang tidak lengkap dan perlu melakukan pengembalian.',
                    'return',
                    'baru',
                    '/riwayatTransaksiPemilik',
                    $rental->id
                );
            }

            if ($rental->item) {
                $rental->item->update([
                    'status' => 'rented',
                ]);
            }

            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('success_title', 'Penerimaan Tidak Lengkap')
                ->with('success_message', 'Barang tidak lengkap. Silakan lanjutkan proses Pesanan Dikembalikan dengan mengunggah bukti pengembalian.');
        }
    }

    // form pesanan dikembalikan

    // form pesanan dikembalikan

    public function formPesananDikembalikan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        $bolehDikembalikan = in_array($rental->status, ['disewa', 'belum_dikembalikan'])
            || ($rental->status === 'pengembalian' && (int) $rental->acceptance_complete === 0);

        if (!$bolehDikembalikan) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Pesanan belum bisa dikembalikan pada status ini.');
        }

        $sudahUploadPengembalian = $rental->documents
            ->where('process', 'tenant_return')
            ->isNotEmpty();

        if ($sudahUploadPengembalian) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Bukti pengembalian sudah dikirim. Tunggu pemilik mengonfirmasi pengembalian.');
        }

        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.pesananDikembalikan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    // simpan bukti pengembalian penyewa

    public function simpanPesananDikembalikan(Request $request, $id)
    {
        $request->validate([
            'kelengkapan_dikembalikan' => 'nullable|array',
            'kelengkapan_dikembalikan.*' => 'nullable|string',

            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        $bolehDikembalikan = in_array($rental->status, ['disewa', 'belum_dikembalikan'])
            || ($rental->status === 'pengembalian' && (int) $rental->acceptance_complete === 0);

        if (!$bolehDikembalikan) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Pesanan belum bisa dikembalikan pada status ini.');
        }

        $sudahUploadPengembalian = $rental->documents
            ->where('process', 'tenant_return')
            ->isNotEmpty();

        if ($sudahUploadPengembalian) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Bukti pengembalian sudah pernah dikirim. Tunggu pemilik mengonfirmasi pengembalian.');
        }

        $this->simpanDokumenRental($request, $rental, 'tenant_return');

        $rental->update([
            'status' => 'pengembalian',
            'return_note' => null,
            'tenant_return_checklist' => $request->input('kelengkapan_dikembalikan', []),
        ]);

        NotificationService::send(

    $rental->owner_id,

    "Barang Dikembalikan",

    "Penyewa telah mengembalikan barang.",

    "return",

    "baru",

    "/riwayat-transaksi/pemilik",

    $rental->id

);

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Pengembalian Barang Berhasil')
            ->with('success_message', 'Bukti pengembalian berhasil dikirim. Menunggu pemilik memeriksa dan mengonfirmasi pengembalian.');
    }

    // perpanjangan sewa

    // ambil tanggal yang tidak bisa dipilih

    private function ambilTanggalTidakTersedia(Rental $rental): array
    {
        $tanggalTidakTersedia = [];

        $rentalsLain = Rental::where('item_id', $rental->item_id)
            ->where('id', '!=', $rental->id)
            ->whereIn('status', [
                'pesanan_masuk',
                'dikirim',
                'menunggu_penerimaan',
                'disewa',
            ])
            ->get();

        foreach ($rentalsLain as $booking) {
            if (!$booking->start_date || !$booking->end_date) {
                continue;
            }

            $start = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);

            while ($start->lte($end)) {
                $tanggalTidakTersedia[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return array_values(array_unique($tanggalTidakTersedia));
    }

    // form perpanjangan sewa

    public function formPerpanjanganSewa($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        if ($rental->status !== 'disewa') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Perpanjangan hanya bisa dilakukan saat barang sedang disewa.');
        }

        $tanggalTidakTersedia = $this->ambilTanggalTidakTersedia($rental);

        return view('pages.perpanjanganSewa.perpanjanganSewa', compact(
            'rental',
            'tanggalTidakTersedia'
        ));
    }

    // simpan pilihan tanggal perpanjangan

    public function lanjutPembayaranPerpanjangan(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai_baru' => 'required|date',
        ]);

        $rental = Rental::with(['item', 'payment'])->findOrFail($id);

        if ($rental->status !== 'disewa') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Perpanjangan hanya bisa dilakukan saat status transaksi Disewa.');
        }

        $tanggalTidakTersedia = $this->ambilTanggalTidakTersedia($rental);

        if (in_array($request->tanggal_selesai_baru, $tanggalTidakTersedia)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal yang dipilih tidak tersedia.');
        }

        $oldEndDate = Carbon::parse($rental->end_date);
        $newEndDate = Carbon::parse($request->tanggal_selesai_baru);

        if ($newEndDate->lte($oldEndDate)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal selesai baru harus lebih besar dari tanggal selesai saat ini.');
        }

        $extraDays = $oldEndDate->diffInDays($newEndDate);
        $pricePerDay = optional($rental->item)->price_per_day ?? 0;
        $extensionPrice = $extraDays * $pricePerDay;

        session([
            'perpanjangan_' . $rental->id => [
                'old_end_date' => $oldEndDate->format('Y-m-d'),
                'new_end_date' => $newEndDate->format('Y-m-d'),
                'extra_days' => $extraDays,
                'extension_price' => $extensionPrice,
            ],
        ]);

        return redirect()
            ->route('transaksi.formPembayaranPerpanjangan', $rental->id);
    }

    // halaman pembayaran perpanjangan

    public function formPembayaranPerpanjangan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        $dataPerpanjangan = session('perpanjangan_' . $rental->id);

        if (!$dataPerpanjangan) {
            return redirect()
                ->route('transaksi.formPerpanjanganSewa', $rental->id)
                ->with('error', 'Silakan pilih tanggal perpanjangan terlebih dahulu.');
        }

        return view('pages.perpanjanganSewa.pembayaranPerpanjangan', compact(
            'rental',
            'dataPerpanjangan'
        ));
    }

    // buat transaksi pembayaran perpanjangan

    public function simpanPembayaranPerpanjangan(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:qris,paylater',
            'installment_plan' => 'nullable|in:2,4',
        ]);

        $rental = Rental::with(['item'])->findOrFail($id);
        $dataPerpanjangan = session('perpanjangan_' . $rental->id);

        if (!$dataPerpanjangan) {
            return response()->json(['error' => 'Data perpanjangan tidak ditemukan atau sesi telah kedaluwarsa.'], 400);
        }

        $orderId = 'EXT-' . $rental->id . '-' . time();
        $amountToPayNow = $dataPerpanjangan['extension_price'];

        // hitung dp paylater
        if ($request->metode_pembayaran === 'paylater') {
            $installmentPlan = (int) $request->installment_plan;
            $amountToPayNow = ceil($amountToPayNow / $installmentPlan);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amountToPayNow,
            ],
            'customer_details' => [
                'first_name' => \Illuminate\Support\Facades\Auth::user()->name,
                'email' => \Illuminate\Support\Facades\Auth::user()->email,
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            RentalExtension::create([
                'rental_id' => $rental->id,
                'old_end_date' => $dataPerpanjangan['old_end_date'],
                'new_end_date' => $dataPerpanjangan['new_end_date'],
                'extra_days' => $dataPerpanjangan['extra_days'],
                'extension_price' => $dataPerpanjangan['extension_price'],
                'payment_type' => $request->metode_pembayaran === 'qris' ? 'full' : 'paylater',
                'payment_method' => $request->metode_pembayaran,
                'payment_status' => 'pending', // menunggu callback midtrans
                'installment_plan' => $request->metode_pembayaran === 'paylater' ? $request->installment_plan : null,
                'installment_paid' => 0,
                'installment_due_days' => $request->metode_pembayaran === 'paylater' ? 14 : null,
                'next_due_date' => $request->metode_pembayaran === 'paylater' ? now()->addDays(14)->format('Y-m-d') : null,
                'order_id' => $orderId,
                'snap_token' => $snapToken,
            ]);

            // hapus session perpanjangan
            session()->forget('perpanjangan_' . $rental->id);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            // tampilkan error asli
            return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    // simpan perpanjangan versi lama

    public function simpanPerpanjanganSewa(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai_baru' => 'required|date',
            'metode_pembayaran' => 'required|in:qris,paylater',
            'installment_plan' => 'nullable|in:2,4',
        ]);

        $rental = Rental::with(['item', 'payment'])->findOrFail($id);

        if ($rental->status !== 'disewa') {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Perpanjangan hanya bisa dilakukan saat status transaksi Disewa.');
        }

        $tanggalTidakTersedia = $this->ambilTanggalTidakTersedia($rental);

        if (in_array($request->tanggal_selesai_baru, $tanggalTidakTersedia)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal yang dipilih tidak tersedia.');
        }

        $oldEndDate = Carbon::parse($rental->end_date);
        $newEndDate = Carbon::parse($request->tanggal_selesai_baru);

        if ($newEndDate->lte($oldEndDate)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Tanggal selesai baru harus lebih besar dari tanggal selesai saat ini.');
        }

        $extraDays = $oldEndDate->diffInDays($newEndDate);
        $pricePerDay = optional($rental->item)->price_per_day ?? 0;
        $extensionPrice = $extraDays * $pricePerDay;

        if ($request->metode_pembayaran === 'paylater') {
            $installmentPlan = (int) $request->installment_plan;

            if (!in_array($installmentPlan, [2, 4])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Pilih cicilan PayLater 2x atau 4x.');
            }

            RentalExtension::create([
                'rental_id' => $rental->id,
                'old_end_date' => $dataPerpanjangan['old_end_date'],
                'new_end_date' => $dataPerpanjangan['new_end_date'],
                'extra_days' => $dataPerpanjangan['extra_days'],
                'extension_price' => $dataPerpanjangan['extension_price'],
                'payment_type' => $request->metode_pembayaran === 'qris' ? 'full' : 'paylater',
                'payment_method' => $request->metode_pembayaran,
                'payment_status' => 'pending', 
                'installment_plan' => $request->metode_pembayaran === 'paylater' ? $request->installment_plan : null,
                'installment_paid' => 0,
                'installment_due_days' => $request->metode_pembayaran === 'paylater' ? 14 : null,
                'next_due_date' => $request->metode_pembayaran === 'paylater' ? now()->addDays(14)->format('Y-m-d') : null,
                'order_id' => $orderId,
                'snap_token' => $snapToken,
            ]);
        } else {
            RentalExtension::create([
                'rental_id' => $rental->id,
                'old_end_date' => $oldEndDate->format('Y-m-d'),
                'new_end_date' => $newEndDate->format('Y-m-d'),
                'extra_days' => $extraDays,
                'extension_price' => $extensionPrice,
                'payment_type' => 'full',
                'payment_method' => 'qris',
                'payment_status' => 'paid',
                'installment_plan' => null,
                'installment_paid' => 0,
                'installment_due_days' => null,
                'next_due_date' => null,
            ]);
        }

        NotificationService::send(

    $rental->owner_id,

    "Permintaan Perpanjangan",

    "Penyewa meminta perpanjangan sewa.",

    "extend",

    "baru",

    "/riwayat-transaksi/pemilik",

    $rental->id

);

        $rental->update([
            'end_date' => $newEndDate->format('Y-m-d'),
            'status' => 'disewa',
        ]);

        return redirect()
            ->route('transaksi.perpanjanganBerhasil', $rental->id)
            ->with('success_title', 'Perpanjangan Sewa Berhasil')
            ->with('success_message', 'Perpanjangan sewa berhasil. Tanggal pengembalian sudah diperbarui.');
    }

    // halaman berhasil perpanjangan

    public function perpanjanganBerhasil($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.perpanjanganSewa.perpanjanganBerhasil', compact('rental'));
    }

    // form konfirmasi pengiriman

    // form konfirmasi pengiriman

    public function formKonfirmasiPengiriman($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPengiriman', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    // simpan konfirmasi pengiriman dan nomor resi

    public function simpanKonfirmasiPengiriman(Request $request, $id)
    {
        $request->validate([
            'nomor_resi' => 'nullable|string|max:100',

            'kelengkapan_keluar' => 'nullable|array',
            'kelengkapan_keluar.*' => 'nullable|string',

            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_shipping');

        $rental->update([
            'status' => 'dikirim',
            'nomor_resi' => $request->nomor_resi,
            'outgoing_checklist' => $request->input('kelengkapan_keluar', []),
        ]);

        return redirect()
            ->route('riwayat.transaksi.pemilik')
            ->with('success_title', 'Konfirmasi Pengiriman Berhasil')
            ->with('success_message', 'Pengiriman berhasil dikonfirmasi. Menunggu penyewa mengonfirmasi penerimaan.');
    }

    // form konfirmasi penyerahan

    // form konfirmasi penyerahan COD

    public function formKonfirmasiPenyerahan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPenyerahan', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    // simpan konfirmasi penyerahan COD

    public function simpanKonfirmasiPenyerahan(Request $request, $id)
    {
        $request->validate([
            'kelengkapan_keluar' => 'nullable|array',
            'kelengkapan_keluar.*' => 'nullable|string',

            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        $rental = Rental::findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_handover');

        $rental->update([
            'status' => 'menunggu_penerimaan',
            'outgoing_checklist' => $request->input('kelengkapan_keluar', []),
        ]);

        NotificationService::send(

    $rental->tenant_id,

    "Barang Dikirim",

    "Pemilik telah mengirim barang.",

    "shipping",

    "proses",

    "/riwayat-transaksi/penyewa",

    $rental->id

);

        return redirect()
            ->route('riwayat.transaksi.pemilik')
            ->with('success_title', 'Konfirmasi Penyerahan Berhasil')
            ->with('success_message', 'Penyerahan berhasil dikonfirmasi. Menunggu penerimaan dari penyewa.');
    }

    // form konfirmasi pengembalian

    // form konfirmasi pengembalian pemilik

    public function formKonfirmasiPengembalian($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);
        $kelengkapanBarang = $this->ambilKelengkapanBarang($rental);

        return view('pages.confirmation.konfirmasiPengembalian', compact(
            'rental',
            'kelengkapanBarang'
        ));
    }

    // simpan hasil pemeriksaan pengembalian

    public function simpanKonfirmasiPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_barang' => 'required|in:aman,rusak',

            'kelengkapan_kembali' => 'nullable|array',
            'kelengkapan_kembali.*' => 'nullable|string',

            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
        ]);

        $rental = Rental::with('item')->findOrFail($id);

        $this->simpanDokumenRental($request, $rental, 'owner_return_check');

        $kondisiBarang = $request->input('kondisi_barang');
        $kelengkapanKembali = $request->input('kelengkapan_kembali', []);

        if ($kondisiBarang === 'aman') {
            $rental->update([
                'status' => 'selesai',
                'return_note' => null,
                'returned_checklist' => $kelengkapanKembali,
            ]);

            NotificationService::send(

    $rental->tenant_id,

    "Transaksi Selesai",

    "Transaksi penyewaan telah selesai.",

    "finish",

    "selesai",

    "/riwayat-transaksi/penyewa",

    $rental->id

);

            if ($rental->item) {
                $rental->item->update([
                    'status' => 'available',
                ]);
            }

            return redirect()
                ->route('riwayat.transaksi.pemilik')
                ->with('success_title', 'Konfirmasi Pengembalian Berhasil')
                ->with('success_message', 'Pengembalian berhasil dikonfirmasi. Transaksi selesai.');
        }

        $rental->update([
            'status' => 'kerusakan',
            'return_note' => null,
            'returned_checklist' => $kelengkapanKembali,
        ]);

        return redirect()
            ->route('transaksi.formPengajuanKerusakan', $rental->id)
            ->with('success_title', 'Barang Bermasalah')
            ->with('success_message', 'Barang bermasalah. Silakan ajukan klaim kerusakan.');
    }

    // form pengajuan kerusakan

    // form pengajuan kerusakan

    public function formPengajuanKerusakan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.damage-submission.pengajuanKerusakan', compact('rental'));
    }

    // simpan klaim kerusakan

    public function simpanPengajuanKerusakan(Request $request, $id)
    {
        $request->validate([
            'damage_type' => 'required_without:jenis_kerusakan|nullable|string',
            'damage_part' => 'required_without:bagian_rusak|nullable|string',
            'description' => 'required_without:deskripsi|nullable|string',
            'repair_fee' => 'nullable|numeric|min:0',

            'jenis_kerusakan' => 'nullable|string',
            'bagian_rusak' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'biaya_perbaikan' => 'nullable|numeric|min:0',

            'foto_bukti' => 'required|array|min:3|max:5',
            'foto_bukti.*' => 'required|file|mimes:jpeg,png|max:10240',
        ], [
            'foto_bukti.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.array' => 'Format upload foto tidak valid.',
            'foto_bukti.min' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.max' => 'Maksimal upload 5 foto.',
            'foto_bukti.*.required' => 'Minimal upload 3 foto bukti.',
            'foto_bukti.*.file' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.mimes' => 'Format file harus JPEG atau PNG.',
            'foto_bukti.*.max' => 'Ukuran setiap file maksimal 10MB.',
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

        NotificationService::send(

    $rental->tenant_id,

    "Klaim Kerusakan",

    "Pemilik mengajukan klaim kerusakan.",

    "damage",

    "baru",

    "/riwayat-transaksi/penyewa",

    $rental->id

);  

        $rental->update([
            'status' => 'kerusakan',
            'damage_description' => $description,
            'damage_fee' => $repairFee,
        ]);

        return redirect()
            ->route('transaksi.lihatKlaim', $rental->id)
            ->with('success_title', 'Klaim Kerusakan Berhasil Diajukan')
            ->with('success_message', 'Klaim kerusakan berhasil diajukan dan menunggu persetujuan penyewa.');
    }

    // lihat klaim kerusakan

    // halaman lihat klaim kerusakan

    public function lihatKlaim($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        return view('pages.damage-submission.klaimKerusakan', compact('rental'));
    }

    // setujui klaim kerusakan

    // setujui klaim kerusakan

    public function setujuiKlaim($id)
    {
        $rental = Rental::with(['item', 'damageClaim'])->findOrFail($id);

        $deposit = 500000;
        $damageFee = optional($rental->damageClaim)->repair_fee ?? $rental->damage_fee ?? 0;
        $sisaTagihan = max($damageFee - $deposit, 0);

        if ($rental->damageClaim) {
            $rental->damageClaim->update([
                'status' => 'accepted',
            ]);
        }

        if ($sisaTagihan > 0) {
            AdditionalPayment::updateOrCreate(
                ['rental_id' => $rental->id],
                [
                    'damage_claim_id' => optional($rental->damageClaim)->id,
                    'amount' => $sisaTagihan,
                    'payment_method' => 'qris',
                    'payment_status' => 'menunggu_pembayaran',
                ]
            );

            return redirect()
                ->route('transaksi.formPembayaranTagihanTambahan', $rental->id)
                ->with('success_title', 'Klaim Disetujui')
                ->with('success_message', 'Klaim disetujui. Silakan lanjutkan pembayaran tagihan tambahan.');
        }

        $rental->update([
            'status' => 'selesai',
        ]);

        NotificationService::send(

    $rental->owner_id,

    "Klaim Disetujui",

    "Penyewa menyetujui klaim kerusakan.",

    "damage",

    "accepted",

    "/riwayat-transaksi/pemilik",

    $rental->id

);

        if ($rental->item) {
            $rental->item->update([
                'status' => 'available',
            ]);
        }

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Klaim Kerusakan Disetujui')
            ->with('success_message', 'Klaim kerusakan berhasil disetujui. Transaksi selesai.');
    }

    // pembayaran tagihan tambahan

    // form pembayaran tagihan tambahan

    public function formPembayaranTagihanTambahan($id)
    {
        $rental = $this->queryRentalDenganRelasi()->findOrFail($id);

        $additionalPayment = AdditionalPayment::where('rental_id', $rental->id)
            ->where('payment_status', 'menunggu_pembayaran')
            ->latest()
            ->first();

        if (!$additionalPayment) {
            return redirect()
                ->route('riwayat.transaksi.penyewa')
                ->with('error', 'Tidak ada tagihan tambahan yang perlu dibayar.');
        }

        return view('pages.payment.pembayaranTagihanTambahan', compact(
            'rental',
            'additionalPayment'
        ));
    }

    // simpan pembayaran tagihan tambahan

    public function simpanPembayaranTagihanTambahan($id)
    {
        $rental = Rental::with('item')->findOrFail($id);

        $additionalPayment = AdditionalPayment::where('rental_id', $rental->id)
            ->where('payment_status', 'menunggu_pembayaran')
            ->latest()
            ->firstOrFail();

        $additionalPayment->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        $rental->update([
            'status' => 'selesai',
        ]);

        NotificationService::send(

    $rental->owner_id,

    "Tagihan Dibayar",

    "Tagihan kerusakan telah dibayar.",

    "payment",

    "paid",

    "/riwayat-transaksi/pemilik",

    $rental->id

);

        if ($rental->item) {
            $rental->item->update([
                'status' => 'available',
            ]);
        }

        return redirect()
            ->route('riwayat.transaksi.penyewa')
            ->with('success_title', 'Tagihan Tambahan Berhasil Dibayar')
            ->with('success_message', 'Tagihan tambahan berhasil dibayar. Transaksi selesai.');
    }
}