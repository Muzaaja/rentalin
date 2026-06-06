<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KycController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\CheckoutController;


/*
|--------------------------------------------------------------------------
| Home & Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/chat', 'pages.chat.chat')->name('chat');
Route::view('/toko', 'pages.store.store')->name('store');
Route::view('/checkout', 'pages.checkout.checkout')->name('checkout');
Route::view('/cancel-refund', 'pages.cancel.cancel')->name('cancel');

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
| KYC
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('kyc')
    ->name('kyc.')
    ->group(function () {

        Route::get('/step-1', [KycController::class, 'step1'])
            ->name('step1');

        Route::post('/step-1', [KycController::class, 'simpanStep1'])
            ->name('step1.store');

        Route::get('/step-2', [KycController::class, 'step2'])
            ->name('step2');

        Route::post('/step-2', [KycController::class, 'simpanStep2'])
            ->name('step2.store');

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

// Cek apakah user sudah punya toko
Route::middleware('auth')->get('/toko', [TokoController::class, 'cekToko'])
    ->name('store');

// Halaman promosi - tidak perlu login
Route::get('/toko/mulai', [TokoController::class, 'mulai'])
    ->name('store.bukaToko');

// Step-step berikutnya perlu login
Route::middleware('auth')->prefix('toko/buat')->name('store.')->group(function () {
    // ... isi route yang sudah ada tetap sama
});

/*
|--------------------------------------------------------------------------
| Buka Toko Multi-step
|--------------------------------------------------------------------------
*/

// Halaman promosi - tidak perlu login
Route::get('/toko/mulai', [TokoController::class, 'mulai'])
    ->name('store.bukaToko');

// Step-step berikutnya perlu login
Route::middleware('auth')->prefix('toko/buat')->name('store.')->group(function () {

    Route::get('/step-1', [TokoController::class, 'step1'])
        ->name('step1Toko');

    Route::post('/step-1', [TokoController::class, 'simpanStep1'])
        ->name('step1Toko.simpan');

    Route::get('/step-2', [TokoController::class, 'step2'])
        ->name('step2Toko');

    Route::post('/step-2', [TokoController::class, 'simpanStep2'])
        ->name('step2Toko.simpan');

    Route::get('/selesai', [TokoController::class, 'selesai'])
        ->name('selesaiToko');

    // Dashboard Toko
    Route::view('/dashboardToko', 'pages.store.dashboardStore.dashboardToko')
        ->name('dashboardToko');
 
    // Keuangan
    Route::view('/keuangan', 'pages.store.dashboardStore.keuanganToko')
        ->name('keuangan');
 
    // Pengaturan - Informasi Toko
    Route::view('/pengaturan', 'pages.store.dashboardStore.informasiToko')
        ->name('pengaturan');
 
    // Pengaturan - Ulasan & Rating
    Route::view('/pengaturan/ulasan', 'pages.store.dashboardStore.ulasanToko')
        ->name('pengaturan.ulasan');
 
    // Pengaturan - Metode Pembayaran
    Route::view('/pengaturan/pembayaran', 'pages.store.dashboardStore.pembayaranToko')
        ->name('pengaturan.pembayaran');
 
    // Pengaturan - Pusat Edukasi
    Route::view('/pengaturan/edukasi', 'pages.store.dashboardStore.pusatEdukasi')
        ->name('pengaturan.edukasi');

    
});

/*
|--------------------------------------------------------------------------
| Items CRUD
|--------------------------------------------------------------------------
*/
// Ini sudah otomatis membuat rute items.index, items.show (untuk detail), items.create, dll.
Route::resource('items', ItemController::class);

/*
|--------------------------------------------------------------------------
| Fitur Terautentikasi (Membutuhkan Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // Dashboard & Profile
    Route::view('/dashboard', 'dashboard')->middleware('verified')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//route toggle aktif, nonaktif barang
Route::patch('/items/{item}/toggle-status', [App\Http\Controllers\ItemController::class, 'toggleStatus'])->name('items.toggle-status');
});

// Rute untuk memproses data dari tombol "Pesan Sekarang"
Route::post('/items/{item}/rent', [RentalController::class, 'store'])->name('rentals.store');

// Rute untuk halaman checkout
Route::get('/checkout/{rental}', [CheckoutController::class, 'index'])->name('checkout.index');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
| Cukup dipanggil satu kali.
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';