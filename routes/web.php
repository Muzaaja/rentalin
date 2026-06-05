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

/*
|--------------------------------------------------------------------------
| Redirect HTML Lama Riwayat Transaksi
|--------------------------------------------------------------------------
*/

Route::redirect('/riwayat_transaksi_pemilik.html', '/riwayatTransaksiPemilik');
Route::redirect('/riwayat_transaksi_pemilik2.html', '/riwayatTransaksiPemilik');

Route::redirect('/riwayat_transaksi_penyewa.html', '/riwayatTransaksiPenyewa');
Route::redirect('/riwayat_transaksi_penyewa2.html', '/riwayatTransaksiPenyewa');

Route::redirect('/page_detail_transaksiCOD.html', '/riwayatTransaksiPenyewa');
Route::redirect('/page_detail_transaksiDelivery.html', '/riwayatTransaksiPenyewa');

Route::redirect('/page_konfirmasi_pengiriman.html', '/riwayatTransaksiPemilik');
Route::redirect('/page_konfirmasi_penyerahan.html', '/riwayatTransaksiPemilik');
Route::redirect('/page_konfirmasi_penerimaan_penyewa.html', '/riwayatTransaksiPenyewa');
Route::redirect('/page_konfirmasi_pengembalian_pemilik.html', '/riwayatTransaksiPemilik');

Route::redirect('/pengajuan_kerusakan.html', '/riwayatTransaksiPemilik');

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

/*
|--------------------------------------------------------------------------
| Riwayat Transaksi Dinamis
|--------------------------------------------------------------------------
| Data riwayat transaksi diambil dari tabel rentals.
|--------------------------------------------------------------------------
*/

Route::get('/riwayatTransaksiPenyewa', [RiwayatTransaksiController::class, 'penyewa'])
    ->name('riwayat.transaksi.penyewa');

Route::get('/riwayatTransaksiPemilik', [RiwayatTransaksiController::class, 'pemilik'])
    ->name('riwayat.transaksi.pemilik');

/*
|--------------------------------------------------------------------------
| Alias Route Untuk Navbar / Link Lama
|--------------------------------------------------------------------------
| Ini dipakai supaya link navbar/footer tetap aman kalau ada yang memanggil
| route transactions.tenant atau transactions.owner.
|--------------------------------------------------------------------------
*/

Route::get('/transaksi/penyewa', [RiwayatTransaksiController::class, 'penyewa'])
    ->name('transactions.tenant');

Route::get('/transaksi/pemilik', [RiwayatTransaksiController::class, 'pemilik'])
    ->name('transactions.owner');

/*
|--------------------------------------------------------------------------
| Detail dan Aksi Transaksi / Rental
|--------------------------------------------------------------------------
| URL tetap pakai /transaksi/{id}, tetapi data di controller diambil dari
| tabel rentals.
|--------------------------------------------------------------------------
*/

Route::prefix('transaksi/{id}')->name('transaksi.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Detail Transaksi
    |--------------------------------------------------------------------------
    */

    Route::get('/detailTransaksi', [RiwayatTransaksiController::class, 'detail'])
        ->name('detail');

    /*
    |--------------------------------------------------------------------------
    | Penyewa - Konfirmasi Penerimaan
    |--------------------------------------------------------------------------
    */

    Route::get('/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'formKonfirmasiPenerimaan'])
        ->name('formKonfirmasiPenerimaan');

    Route::put('/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenerimaan'])
        ->name('simpanKonfirmasiPenerimaan');

    /*
    |--------------------------------------------------------------------------
    | Penyewa - Pesanan Dikembalikan
    |--------------------------------------------------------------------------
    */

    Route::get('/pesananDikembalikan', [RiwayatTransaksiController::class, 'formPesananDikembalikan'])
        ->name('formPesananDikembalikan');

    Route::put('/pesananDikembalikan', [RiwayatTransaksiController::class, 'simpanPesananDikembalikan'])
        ->name('simpanPesananDikembalikan');

    /*
    |--------------------------------------------------------------------------
    | Penyewa - Perpanjangan Sewa
    |--------------------------------------------------------------------------
    */

    Route::get('/perpanjanganSewa', [RiwayatTransaksiController::class, 'formPerpanjanganSewa'])
        ->name('formPerpanjanganSewa');

    Route::put('/perpanjanganSewa', [RiwayatTransaksiController::class, 'simpanPerpanjanganSewa'])
        ->name('simpanPerpanjanganSewa');

    /*
    |--------------------------------------------------------------------------
    | Pemilik - Konfirmasi Pengiriman
    |--------------------------------------------------------------------------
    */

    Route::get('/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'formKonfirmasiPengiriman'])
        ->name('formKonfirmasiPengiriman');

    Route::put('/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengiriman'])
        ->name('simpanKonfirmasiPengiriman');

    /*
    |--------------------------------------------------------------------------
    | Pemilik - Konfirmasi Penyerahan COD
    |--------------------------------------------------------------------------
    */

    Route::get('/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'formKonfirmasiPenyerahan'])
        ->name('formKonfirmasiPenyerahan');

    Route::put('/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenyerahan'])
        ->name('simpanKonfirmasiPenyerahan');

    /*
    |--------------------------------------------------------------------------
    | Pemilik - Konfirmasi Pengembalian
    |--------------------------------------------------------------------------
    */

    Route::get('/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'formKonfirmasiPengembalian'])
        ->name('formKonfirmasiPengembalian');

    Route::put('/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengembalian'])
        ->name('simpanKonfirmasiPengembalian');

    /*
    |--------------------------------------------------------------------------
    | Pemilik - Pengajuan Kerusakan
    |--------------------------------------------------------------------------
    */

    Route::get('/pengajuanKerusakan', [RiwayatTransaksiController::class, 'formPengajuanKerusakan'])
        ->name('formPengajuanKerusakan');

    Route::put('/pengajuanKerusakan', [RiwayatTransaksiController::class, 'simpanPengajuanKerusakan'])
        ->name('simpanPengajuanKerusakan');

    /*
    |--------------------------------------------------------------------------
    | Penyewa - Klaim Kerusakan
    |--------------------------------------------------------------------------
    */

    Route::get('/klaimKerusakan', [RiwayatTransaksiController::class, 'lihatKlaim'])
        ->name('lihatKlaim');

    Route::put('/klaimKerusakan/setujui', [RiwayatTransaksiController::class, 'setujuiKlaim'])
        ->name('setujuiKlaim');

});

/*
|--------------------------------------------------------------------------
| Buka Toko
|--------------------------------------------------------------------------
| Route store.bukaToko dibuat supaya navbar temanmu yang memakai
| route('store.bukaToko') tidak error.
|--------------------------------------------------------------------------
*/

Route::get('/toko/mulai', [TokoController::class, 'mulai'])
    ->name('store.bukaToko');

/*
|--------------------------------------------------------------------------
| Buka Toko Multi-step
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('toko/buat')->name('toko.')->group(function () {

    Route::get('/mulai', [TokoController::class, 'mulai'])
        ->name('mulai');

    Route::get('/step-1', [TokoController::class, 'step1'])
        ->name('step1');

    Route::post('/step-1', [TokoController::class, 'simpanStep1'])
        ->name('step1.simpan');

    Route::get('/step-2', [TokoController::class, 'step2'])
        ->name('step2');

    Route::post('/step-2', [TokoController::class, 'simpanStep2'])
        ->name('step2.simpan');

    Route::get('/selesai', [TokoController::class, 'selesai'])
        ->name('selesai');

});

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
| Auth Routes
|--------------------------------------------------------------------------
| Cukup dipanggil satu kali.
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';