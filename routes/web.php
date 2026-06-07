<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\Admin\KycAdminController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home & Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::view('/chat', 'pages.chat.chat')
    ->name('chat');

Route::get('/checkout/{rental}', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::view('/cancel-refund', 'pages.cancel.cancel')
    ->name('cancel');

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
*/

Route::get('/riwayatTransaksiPenyewa', [RiwayatTransaksiController::class, 'penyewa'])
    ->name('riwayat.transaksi.penyewa');

Route::get('/riwayatTransaksiPemilik', [RiwayatTransaksiController::class, 'pemilik'])
    ->name('riwayat.transaksi.pemilik');

/*
|--------------------------------------------------------------------------
| Alias Route Untuk Navbar / Link Lama
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
*/

Route::prefix('transaksi/{id}')
    ->name('transaksi.')
    ->group(function () {

        Route::get('/detailTransaksi', [RiwayatTransaksiController::class, 'detail'])
            ->name('detail');

        Route::get('/konfirmasiPembayaran', [RiwayatTransaksiController::class, 'formKonfirmasiPembayaran'])
            ->name('formKonfirmasiPembayaran');

        Route::put('/konfirmasiPembayaran', [RiwayatTransaksiController::class, 'simpanKonfirmasiPembayaran'])
            ->name('simpanKonfirmasiPembayaran');

        Route::get('/batalkanPesanan', [RiwayatTransaksiController::class, 'formBatalkanPesanan'])
            ->name('formBatalkanPesanan');

        Route::put('/batalkanPesanan', [RiwayatTransaksiController::class, 'simpanBatalkanPesanan'])
            ->name('simpanBatalkanPesanan');

        Route::get('/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'formKonfirmasiPenerimaan'])
            ->name('formKonfirmasiPenerimaan');

        Route::put('/konfirmasiPenerimaan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenerimaan'])
            ->name('simpanKonfirmasiPenerimaan');

        Route::get('/pesananDikembalikan', [RiwayatTransaksiController::class, 'formPesananDikembalikan'])
            ->name('formPesananDikembalikan');

        Route::put('/pesananDikembalikan', [RiwayatTransaksiController::class, 'simpanPesananDikembalikan'])
            ->name('simpanPesananDikembalikan');

        Route::get('/perpanjanganSewa', [RiwayatTransaksiController::class, 'formPerpanjanganSewa'])
            ->name('formPerpanjanganSewa');

        Route::put('/perpanjanganSewa/lanjutPembayaran', [RiwayatTransaksiController::class, 'lanjutPembayaranPerpanjangan'])
            ->name('lanjutPembayaranPerpanjangan');

        Route::get('/perpanjanganSewa/pembayaran', [RiwayatTransaksiController::class, 'formPembayaranPerpanjangan'])
            ->name('formPembayaranPerpanjangan');

        Route::put('/perpanjanganSewa/pembayaran', [RiwayatTransaksiController::class, 'simpanPembayaranPerpanjangan'])
            ->name('simpanPembayaranPerpanjangan');

        Route::get('/perpanjanganSewa/berhasil', [RiwayatTransaksiController::class, 'perpanjanganBerhasil'])
            ->name('perpanjanganBerhasil');

        Route::get('/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'formKonfirmasiPengiriman'])
            ->name('formKonfirmasiPengiriman');

        Route::put('/konfirmasiPengiriman', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengiriman'])
            ->name('simpanKonfirmasiPengiriman');

        Route::get('/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'formKonfirmasiPenyerahan'])
            ->name('formKonfirmasiPenyerahan');

        Route::put('/konfirmasiPenyerahan', [RiwayatTransaksiController::class, 'simpanKonfirmasiPenyerahan'])
            ->name('simpanKonfirmasiPenyerahan');

        Route::get('/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'formKonfirmasiPengembalian'])
            ->name('formKonfirmasiPengembalian');

        Route::put('/konfirmasiPengembalian', [RiwayatTransaksiController::class, 'simpanKonfirmasiPengembalian'])
            ->name('simpanKonfirmasiPengembalian');

        Route::get('/pengajuanKerusakan', [RiwayatTransaksiController::class, 'formPengajuanKerusakan'])
            ->name('formPengajuanKerusakan');

        Route::post('/pengajuanKerusakan', [RiwayatTransaksiController::class, 'simpanPengajuanKerusakan'])
            ->name('simpanPengajuanKerusakan');

        Route::get('/klaimKerusakan', [RiwayatTransaksiController::class, 'lihatKlaim'])
            ->name('lihatKlaim');

        Route::put('/klaimKerusakan/setujui', [RiwayatTransaksiController::class, 'setujuiKlaim'])
            ->name('setujuiKlaim');

        Route::get('/pembayaranTagihanTambahan', [RiwayatTransaksiController::class, 'formPembayaranTagihanTambahan'])
            ->name('formPembayaranTagihanTambahan');

        Route::put('/pembayaranTagihanTambahan', [RiwayatTransaksiController::class, 'simpanPembayaranTagihanTambahan'])
            ->name('simpanPembayaranTagihanTambahan');

    });

/*
|--------------------------------------------------------------------------
| Toko
|--------------------------------------------------------------------------
*/

// Cek apakah user sudah punya toko
Route::middleware('auth')->get('/toko', [TokoController::class, 'cekToko'])
    ->name('store');

// Halaman promosi - tidak perlu login
Route::get('/toko/mulai', [TokoController::class, 'mulai'])
    ->name('store.bukaToko');

// Step-step berikutnya perlu login
Route::middleware('auth')
    ->prefix('toko/buat')
    ->name('store.')
    ->group(function () {

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

        // Arahkan ke controller agar logika pengecekan status tereksekusi
        Route::get('/dashboardToko', [TokoController::class, 'dashboardToko'])
            ->name('dashboardToko');

        Route::view('/keuangan', 'pages.store.dashboardStore.keuanganToko')
            ->name('keuangan');

        // Arahkan ke controller sesuai fungsi pengaturan di TokoController
        Route::get('/pengaturan', [TokoController::class, 'pengaturan'])
            ->name('pengaturan');

        Route::view('/pengaturan/ulasan', 'pages.store.dashboardStore.ulasanToko')
            ->name('pengaturan.ulasan');

        Route::view('/pengaturan/pembayaran', 'pages.store.dashboardStore.pembayaranToko')
            ->name('pengaturan.pembayaran');

        Route::view('/pengaturan/edukasi', 'pages.store.dashboardStore.pusatEdukasi')
            ->name('pengaturan.edukasi');

    });

/*
|--------------------------------------------------------------------------
| Ulasan Toko
|--------------------------------------------------------------------------
*/

Route::prefix('store/pengaturan')
    ->name('store.pengaturan.')
    ->group(function () {

        Route::get('/ulasan', [UlasanController::class, 'index'])
            ->name('ulasan');
    });

/*
|--------------------------------------------------------------------------
| Items CRUD
|--------------------------------------------------------------------------
*/

Route::resource('items', ItemController::class);

Route::patch('/items/{item}/toggle-status', [ItemController::class, 'toggleStatus'])
    ->middleware('auth')
    ->name('items.toggle-status');

Route::get('/items/{item}/reviews', [ItemController::class, 'reviews'])
    ->name('items.reviews');

/*
|--------------------------------------------------------------------------
| Rental / Checkout
|--------------------------------------------------------------------------
*/

// Proses dari tombol "Pesan Sekarang"
Route::post('/items/{item}/rent', [RentalController::class, 'store'])
    ->name('rentals.store');

// Halaman checkout dinamis dari rental
Route::get('/checkout/{rental}', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post(
    '/checkout/{rental}/retry',
    [CheckoutController::class, 'retry']
)->name('checkout.retry');  

/*
|--------------------------------------------------------------------------
| Dashboard & Profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard', 'dashboard')
        ->middleware('verified')
        ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| Payment Routes
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/callback', [PaymentController::class, 'callback'])
    ->name('midtrans.callback');

Route::post(
    '/payment/demo-success/{rental}',
    [PaymentController::class,'demoSuccess']
)->name('payment.demo.success');

/*
|------------------------------g--------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

//bagian admin
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Rute KYC User
    Route::get('/kyc-user', [KycAdminController::class, 'userIndex'])->name('admin.kyc_user.index');
    Route::patch('/kyc-user/{id}/approve', [KycAdminController::class, 'approveUser'])->name('admin.kyc_user.approve');
    Route::patch('/kyc-user/{id}/reject', [KycAdminController::class, 'rejectUser'])->name('admin.kyc_user.reject');

    // Rute KYC Toko
    Route::get('/kyc-toko', [KycAdminController::class, 'tokoIndex'])->name('admin.kyc_toko.index');
    Route::patch('/kyc-toko/{id}/approve', [KycAdminController::class, 'approveToko'])->name('admin.kyc_toko.approve');
    Route::patch('/kyc-toko/{id}/reject', [KycAdminController::class, 'rejectToko'])->name('admin.kyc_toko.reject');
});

/*
|--------------------------------------------------------------------------
| Penilaian / Ulasan Penyewa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi/{rental}/ulasan', [UlasanController::class, 'create'])->name('ulasan.create');
    Route::post('/transaksi/{rental}/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
});

require __DIR__ . '/auth.php';