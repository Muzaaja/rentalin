<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\TokoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Legacy HTML Redirects
|--------------------------------------------------------------------------
*/

Route::redirect('/index.html', '/');
Route::redirect('/homepage-user.html', '/');

Route::redirect('/login.html', '/login');
Route::redirect('/register.html', '/register');
Route::redirect('/profile.html', '/profile');

Route::redirect('/chat.html', '/chat');
Route::redirect('/page_toko.html', '/toko');

Route::redirect('/page_checkout.html', '/checkout');
Route::redirect('/page_cancel.html', '/cancel-refund');

Route::redirect('/page_detail_barang.html', '/items');
Route::redirect('/page_create_edit_barang.html', '/items/create');

Route::redirect('/kyc-step1.html', '/kyc/step-1');
Route::redirect('/kyc-step2.html', '/kyc/step-2');

Route::redirect('/riwayat_transaksi_pemilik.html', '/transaksi/pemilik');
Route::redirect('/riwayat_transaksi_pemilik2.html', '/transaksi/pemilik/halaman-2');

Route::redirect('/riwayat_transaksi_penyewa.html', '/transaksi/penyewa');
Route::redirect('/riwayat_transaksi_penyewa2.html', '/transaksi/penyewa/halaman-2');

Route::redirect('/page_detail_transaksiCOD.html', '/transaksi/detail/cod');
Route::redirect('/page_detail_transaksiDelivery.html', '/transaksi/detail/delivery');

Route::redirect('/page_konfirmasi_pengiriman.html', '/konfirmasi/pengiriman');
Route::redirect('/page_konfirmasi_penyerahan.html', '/konfirmasi/penyerahan');
Route::redirect('/page_konfirmasi_penerimaan_penyewa.html', '/konfirmasi/penerimaan');
Route::redirect('/page_konfirmasi_pengembalian_pemilik.html', '/konfirmasi/pengembalian');

Route::redirect('/pengajuan_kerusakan.html', '/klaim-kerusakan');

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::view('/chat', 'pages.chat.chat')
    ->name('chat');

Route::view('/toko', 'pages.store.store')
    ->name('store');

Route::view('/checkout', 'pages.checkout.checkout')
    ->name('checkout');

Route::view('/cancel-refund', 'pages.cancel.cancel')
    ->name('cancel');

/*
|--------------------------------------------------------------------------
| KYC
|--------------------------------------------------------------------------
*/

Route::prefix('kyc')->name('kyc.')->group(function () {

    Route::view('/step-1', 'pages.kyc.step1')
        ->name('step1');

    Route::view('/step-2', 'pages.kyc.step2')
        ->name('step2');

});

// 1. Rute Halaman Utama Riwayat
Route::get('/transaksi/penyewa', [RiwayatTransaksiController::class, 'penyewa'])->name('riwayat.transaksi.penyewa');
Route::get('/transaksi/pemilik', [RiwayatTransaksiController::class, 'pemilik'])->name('riwayat.transaksi.pemilik');
Route::get('/transaksi/detail/{id}', [RiwayatTransaksiController::class, 'detail'])->name('transaksi.detail');

// 2. Rute Aksi Penyewa
Route::get('/transaksi/{id}/terima', [RiwayatTransaksiController::class, 'formKonfirmasiPenerimaan'])->name('transaksi.formPenerimaan');
Route::post('/transaksi/{id}/terima', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenerimaan'])->name('transaksi.simpanPenerimaan');

Route::get('/transaksi/{id}/perpanjang', [RiwayatTransaksiController::class, 'formPerpanjanganSewa'])->name('transaksi.formPerpanjang');
Route::post('/transaksi/{id}/perpanjang', [RiwayatTransaksiController::class, 'simpanPerpanjanganSewa'])->name('transaksi.simpanPerpanjang');

Route::get('/transaksi/{id}/kembalikan', [RiwayatTransaksiController::class, 'formPesananDikembalikan'])->name('transaksi.formDikembalikan');
Route::post('/transaksi/{id}/kembalikan', [RiwayatTransaksiController::class, 'simpanPesananDikembalikan'])->name('transaksi.simpanDikembalikan');

// 3. Rute Aksi Pemilik
Route::get('/transaksi/{id}/kirim', [RiwayatTransaksiController::class, 'formKonfirmasiPengiriman'])->name('transaksi.formPengiriman');
Route::post('/transaksi/{id}/kirim', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengiriman'])->name('transaksi.simpanPengiriman');

Route::get('/transaksi/{id}/serahkan', [RiwayatTransaksiController::class, 'formKonfirmasiPenyerahan'])->name('transaksi.formPenyerahan');
Route::post('/transaksi/{id}/serahkan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenyerahan'])->name('transaksi.simpanPenyerahan');

Route::get('/transaksi/{id}/konfirmasi-pengembalian', [RiwayatTransaksiController::class, 'formKonfirmasiPengembalian'])->name('transaksi.formKonfirmasiPengembalian');
Route::post('/transaksi/{id}/konfirmasi-pengembalian', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengembalian'])->name('transaksi.simpanKonfirmasiPengembalian');

// 4. Rute Kerusakan
Route::get('/transaksi/{id}/pengajuan-kerusakan', [RiwayatTransaksiController::class, 'formPengajuanKerusakan'])->name('transaksi.formPengajuanKerusakan');
Route::post('/transaksi/{id}/pengajuan-kerusakan', [RiwayatTransaksiController::class, 'simpanPengajuanKerusakan'])->name('transaksi.simpanPengajuanKerusakan');
Route::get('/transaksi/{id}/klaim', [RiwayatTransaksiController::class, 'lihatKlaim'])->name('transaksi.lihatKlaim');

// Route untuk halaman riwayat transaksi.
Route::get('/riwayatTransaksiPenyewa', [RiwayatTransaksiController::class, 'penyewa'])
    ->name('riwayat.transaksi.penyewa');

Route::get('/riwayatTransaksiPemilik', [RiwayatTransaksiController::class, 'pemilik'])
    ->name('riwayat.transaksi.pemilik');

// Detail Transaksi
Route::get('/transaksi/{id}/detailTransaksi', [RiwayatTransaksiController::class, 'detail'])
    ->name('transaksi.detail');

// Penyewa - Konfirmasi Penerimaan
Route::get('/transaksi/{id}/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'formKonfirmasiPenerimaan'])
    ->name('transaksi.formKonfirmasiPenerimaan');

Route::put('/transaksi/{id}/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenerimaan'])
    ->name('transaksi.simpanKonfirmasiPenerimaan');

// Penyewa - Perpanjangan Sewa
Route::get('/transaksi/{id}/perpanjanganSewa', [RiwayatTransaksiController::class, 'formPerpanjanganSewa'])
    ->name('transaksi.formPerpanjanganSewa');

Route::put('/transaksi/{id}/perpanjanganSewa', [RiwayatTransaksiController::class, 'simpanPerpanjanganSewa'])
    ->name('transaksi.simpanPerpanjanganSewa');

// Penyewa - Pesanan Dikembalikan
Route::get('/transaksi/{id}/pesananDikembalikan', [RiwayatTransaksiController::class, 'formPesananDikembalikan'])
    ->name('transaksi.formPesananDikembalikan');

Route::put('/transaksi/{id}/pesananDikembalikan', [RiwayatTransaksiController::class, 'simpanPesananDikembalikan'])
    ->name('transaksi.simpanPesananDikembalikan');

// Pemilik - Konfirmasi Pengiriman
Route::get('/transaksi/{id}/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'formKonfirmasiPengiriman'])
    ->name('transaksi.formKonfirmasiPengiriman');

Route::put('/transaksi/{id}/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengiriman'])
    ->name('transaksi.simpanKonfirmasiPengiriman');

// Pemilik - Konfirmasi Penyerahan COD
Route::get('/transaksi/{id}/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'formKonfirmasiPenyerahan'])
    ->name('transaksi.formKonfirmasiPenyerahan');

Route::put('/transaksi/{id}/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenyerahan'])
    ->name('transaksi.simpanKonfirmasiPenyerahan');

// Pemilik - Konfirmasi Pengembalian
Route::get('/transaksi/{id}/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'formKonfirmasiPengembalian'])
    ->name('transaksi.formKonfirmasiPengembalian');

Route::put('/transaksi/{id}/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengembalian'])
    ->name('transaksi.simpanKonfirmasiPengembalian');

// Pemilik - Pengajuan Kerusakan
Route::get('/transaksi/{id}/pengajuanKerusakan', [RiwayatTransaksiController::class, 'formPengajuanKerusakan'])
    ->name('transaksi.formPengajuanKerusakan');

Route::put('/transaksi/{id}/pengajuanKerusakan', [RiwayatTransaksiController::class, 'simpanPengajuanKerusakan'])
    ->name('transaksi.simpanPengajuanKerusakan');

// Klaim Kerusakan
Route::get('/transaksi/{id}/klaimKerusakan', [RiwayatTransaksiController::class, 'lihatKlaim'])
    ->name('transaksi.lihatKlaim');

// Rute pemicu navbar:
Route::get('/toko/mulai', [TokoController::class, 'mulai'])->name('store.bukaToko');

// Rute fungsionalitas pembuatan toko:
Route::get('/toko/buat/step-1', [TokoController::class, 'step1'])->name('toko.step1');
Route::post('/toko/buat/step-1', [TokoController::class, 'simpanStep1'])->name('toko.simpanStep1');
Route::get('/toko/buat/step-2', [TokoController::class, 'step2'])->name('toko.step2');
Route::post('/toko/buat/step-2', [TokoController::class, 'simpanStep2'])->name('toko.simpanStep2');
Route::get('/toko/buat/selesai', [TokoController::class, 'selesai'])->name('toko.selesai');

// Impor autentikasi Laravel bawaan
require __DIR__.'/auth.php';


/*
|--------------------------------------------------------------------------
| Items CRUD
|--------------------------------------------------------------------------
*/

Route::resource('items', ItemController::class);

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')
        ->name('dashboard');

});

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Buka Toko (Multi-step)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('toko/buat')->name('toko.')->group(function () {

    // Halaman landing "Mulai sewakan barangmu"
    Route::get('/mulai', [TokoController::class, 'mulai'])
        ->name('mulai');

    // Step 1: Info Toko
    Route::get('/step-1',  [TokoController::class, 'step1'])
        ->name('step1');
    Route::post('/step-1', [TokoController::class, 'simpanStep1'])
        ->name('step1.simpan');

    // Step 2: Verifikasi
    Route::get('/step-2',  [TokoController::class, 'step2'])
        ->name('step2');
    Route::post('/step-2', [TokoController::class, 'simpanStep2'])
        ->name('step2.simpan');

    // Selesai
    Route::get('/selesai', [TokoController::class, 'selesai'])
        ->name('selesai');

});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
