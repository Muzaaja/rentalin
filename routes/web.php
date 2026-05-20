<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
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

Route::redirect('/page_detail_barang.html', '/barang/detail');
Route::redirect('/page_create_edit_barang.html', '/barang/form');

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
| Public Preview Pages
|--------------------------------------------------------------------------
| Untuk sementara dibuat public agar semua halaman bisa dilihat tanpa login.
|--------------------------------------------------------------------------
*/

Route::view('/chat', 'pages.chat.chat')->name('chat.index');

Route::view('/toko', 'pages.store.store')->name('store.index');

Route::prefix('barang')->name('items.')->group(function () {
    Route::view('/detail', 'pages.items.itemsDetail')->name('show');
    Route::view('/form', 'pages.items.itemsEditCreate')->name('form');
    Route::view('/buat', 'pages.items.itemsEditCreate')->name('create');
    Route::view('/edit', 'pages.items.itemsEditCreate')->name('edit');
});

Route::view('/checkout', 'pages.checkout.checkout')->name('checkout.index');

Route::view('/cancel-refund', 'pages.cancel.cancel')->name('cancel.index');

Route::prefix('kyc')->name('kyc.')->group(function () {
    Route::view('/step-1', 'pages.kyc.step1')->name('step1');
    Route::view('/step-2', 'pages.kyc.step2')->name('step2');
});

Route::prefix('transaksi')->name('transactions.')->group(function () {
    Route::view('/pemilik', 'pages.transactions.transactions history.transactionHistoryOwner1')
        ->name('owner.index');

    Route::view('/pemilik/halaman-2', 'pages.transactions.transactions history.transactionHistoryOwner2')
        ->name('owner.page2');

    Route::view('/penyewa', 'pages.transactions.transactions history.transactionHistoryTenant2')
        ->name('tenant.index');

    Route::view('/penyewa/halaman-2', 'pages.transactions.transactions history.transactionHistoryTenant1')
        ->name('tenant.page2');

    Route::view('/detail/cod', 'pages.transactions.transactions detail.transactionsDetailCOD')
        ->name('detail.cod');

    Route::view('/detail/delivery', 'pages.transactions.transactions detail.transactionsDetailDelivery')
        ->name('detail.delivery');
});

Route::prefix('konfirmasi')->name('confirmations.')->group(function () {
    Route::view('/pengiriman', 'pages.confirmation.confirmationShipping')
        ->name('shipping');

    Route::view('/penyerahan', 'pages.confirmation.confirmationSubmission')
        ->name('submission');

    Route::view('/penerimaan', 'pages.confirmation.confirmationTenantAcceptance')
        ->name('tenant-acceptance');

    Route::view('/pengembalian', 'pages.confirmation.confirmationOwnerReturn')
        ->name('owner-return');
});

Route::view('/klaim-kerusakan', 'pages.damage submission.damageSubmission')
    ->name('claims.damage');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
| Bagian ini tetap butuh login.
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Breeze Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';