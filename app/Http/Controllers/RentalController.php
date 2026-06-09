<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Models\Item;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RentalController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // 1. Validasi input dari form
        $request->validate([
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'delivery_method' => 'required|in:cod,delivery'
        ]);

        // 2. Kalkulasi durasi dan total harga di sisi server
        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        
        $diffDays = $start->diffInDays($end);
        if ($diffDays === 0) {
            $diffDays = 1; // Sewa di hari yang sama dihitung 1 hari
        }
        
        $totalPrice = $diffDays * $item->price_per_day;

        // 3. Logika pembuatan rental_code (Format: TRX-YYYYMMDD-XXXX)
        $datePrefix = now()->format('Ymd');
        $rentalsToday = Rental::whereDate('created_at', today())->count();
        $sequence = str_pad($rentalsToday + 1, 4, '0', STR_PAD_LEFT);
        $rentalCode = 'TRX-' . $datePrefix . '-' . $sequence;

        // 4. Simpan ke database
        $rental = Rental::create([
            'rental_code'     => $rentalCode,
            'item_id'         => $item->id,
            'owner_id'        => $item->user_id,
            'tenant_id'       => Auth::id(),
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'delivery_method' => $request->delivery_method, 
            'total_price'     => $totalPrice,
            'status'          => 'menunggu_pembayaran', 
        ]);

        // 5. Eksekusi Notifikasi dengan Try-Catch agar tidak menghentikan proses Checkout
        try {
            if (class_exists(NotificationService::class)) {
                NotificationService::send(
                    $item->user_id,
                    "Permintaan Sewa Baru",
                    Auth::user()->name." mengajukan penyewaan ".$item->name,
                    "request",
                    "baru",
                    "/riwayat-transaksi/pemilik",
                    $rental->id
                );
            }
        } catch (\Exception $e) {
            // Mencatat error ke dalam file log tanpa mengganggu user
            Log::error('Gagal mengirim notifikasi: ' . $e->getMessage());
        }

        // 6. Penanganan Redirect (Mendukung permintaan JavaScript/AJAX dan HTML Form Biasa)
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.index', $rental->id)
            ]);
        }

        // Arahkan pengguna ke halaman checkout dengan membawa ID rental (Untuk form standar HTML)
        return redirect()->route('checkout.index', $rental->id);
    }
}