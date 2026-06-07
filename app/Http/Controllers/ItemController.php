<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::where('user_id', Auth::id())->with(['category', 'rentals']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $items = $query->latest()->paginate(12)->withQueryString();

        return view('pages.items.itemsList', compact('items'));
    }

    // Fungsi ini yang sebelumnya hilang dan menyebabkan error
    public function create()
    {
        $categories = Category::all();

        return view('pages.items.itemsEditCreate', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'description'           => 'required|string',
            'price_per_day'         => 'required|numeric|min:0',
            'late_fee_percentage'   => 'nullable|numeric|min:0|max:100',
            'deposit_amount'        => 'nullable|numeric|min:0',
            'images.*'              => 'nullable|image|max:10240', 
            'kelengkapan'           => 'nullable|array',
            'cancellation_policies' => 'nullable|array',
            'kecamatan'             => 'nullable|string|max:255',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imagePaths[] = $file->store('items', 'public');
            }
        }

        $kelengkapan = array_filter($request->kelengkapan ?? []);

        $policies = [];
        if ($request->has('cancellation_policies')) {
            foreach ($request->cancellation_policies as $policy) {
                if (!empty($policy['days_before']) && !empty($policy['refund_percentage'])) {
                    $policies[] = $policy;
                }
            }
        }

        Item::create([
            'user_id'               => Auth::id(),
            'category_id'           => $request->category_id,
            'name'                  => $request->name,
            'description'           => $request->description,
            'price_per_day'         => $request->price_per_day,
            'stock'                 => 1,
            'kelengkapan'           => $kelengkapan, 
            'image'                 => $imagePaths, 
            'status'                => 'available',
            'is_cod'                => $request->has('is_cod'),         
            'is_delivery'           => $request->has('is_delivery'),
            'late_fee_percentage'   => $request->late_fee_percentage,
            'has_deposit'           => $request->has('has_deposit'),
            'deposit_amount'        => $request->has('has_deposit') ? $request->deposit_amount : null,
            'cancellation_policies' => $policies,
            'kecamatan'             => $request->kecamatan,
        ]);

        return redirect()->route('items.index')->with('success', 'Barang berhasil disewakan.');
    }

    public function show(Item $item)
    {
        // Mengambil ulasan beserta data user pengulas (maksimal 2 ulasan terbaru)
        $reviews = $item->reviews()->with('user')->latest()->take(2)->get();
        
        // Kalkulasi total ulasan dan rata-rata rating
        $totalReviews = $item->reviews()->count();
        $averageRating = $totalReviews > 0 ? $item->reviews()->avg('rating') : 0;

        return view('pages.items.itemsDetail', compact('item', 'reviews', 'totalReviews', 'averageRating'));
    }

    public function edit(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke barang ini.');
        }

        $categories = Category::all();

        return view('pages.items.itemsEditCreate', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'name'                  => 'required|string|max:255',
            'category_id'           => 'required|exists:categories,id',
            'description'           => 'required|string',
            'price_per_day'         => 'required|numeric|min:0',
            'late_fee_percentage'   => 'nullable|numeric|min:0|max:100',
            'deposit_amount'        => 'nullable|numeric|min:0',
            'kelengkapan'           => 'nullable|array',
            'cancellation_policies' => 'nullable|array',
            'kecamatan'             => 'nullable|string|max:255',
        ]);

        $kelengkapan = array_filter($request->kelengkapan ?? []);

        $policies = [];
        if ($request->has('cancellation_policies')) {
            foreach ($request->cancellation_policies as $policy) {
                if (!empty($policy['days_before']) && !empty($policy['refund_percentage'])) {
                    $policies[] = $policy;
                }
            }
        }

        $item->update([
            'category_id'           => $request->category_id,
            'name'                  => $request->name,
            'description'           => $request->description,
            'price_per_day'         => $request->price_per_day,
            'kelengkapan'           => $kelengkapan,
            'is_cod'                => $request->has('is_cod'),
            'is_delivery'           => $request->has('is_delivery'),
            'late_fee_percentage'   => $request->late_fee_percentage,
            'has_deposit'           => $request->has('has_deposit'),
            'deposit_amount'        => $request->has('has_deposit') ? $request->deposit_amount : null,
            'cancellation_policies' => $policies,
            'kecamatan'             => $request->kecamatan,
        ]);

        return redirect()->route('items.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    // Mengubah status ketersediaan barang (Aktif/Tidak Aktif)
    // ─────────────────────────────────────────
    public function toggleStatus(Request $request, Item $item)
    {
        if ($item->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Balikkan status
        $item->status = $item->status === 'available' ? 'inactive' : 'available';
        $item->save();

        return response()->json([
            'success' => true, 
            'status' => $item->status
        ]);
    }
    // ─────────────────────────────────────────
    // Menampilkan semua ulasan untuk satu barang
    // ─────────────────────────────────────────
    public function reviews(Item $item)
    {
        // Mengambil ulasan beserta data user pengulas
        $reviews = $item->reviews()->with('user')->latest()->get();
        
        // Kalkulasi statistik
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
        
        // Distribusi bintang untuk progress bar
        $ratingCounts = [
            5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
            2 => $reviews->where('rating', 2)->count(),
            1 => $reviews->where('rating', 1)->count(),
        ];

        return view('pages.reviews.ReviewBarang', compact('item', 'reviews', 'totalReviews', 'averageRating', 'ratingCounts'));
    }

     public function katalog(Request $request)
    {
        $query = Item::where('status', 'available')
            ->with(['category', 'rentals'])
            ->withCount('rentals');
 
        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
 
        // Filter kategori via slug
        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->kategori);
            });
        }
 
        $items      = $query->orderByDesc('rentals_count')->paginate(20)->withQueryString();
        $categories = \App\Models\Category::all();
 
        // Nama kategori aktif untuk heading halaman
        $kategoriAktif = null;
        if ($request->filled('kategori')) {
            $kategoriAktif = $categories->firstWhere('slug', $request->kategori);
        }
 
        return view('pages.items.katalog', compact('items', 'categories', 'kategoriAktif'));
    }

    // ─────────────────────────────────────────────────────────────────────────
// BARU: Fungsi untuk Halaman Home Terbaru
// ─────────────────────────────────────────────────────────────────────────
public function home()
{
    $categories = Category::all();

    // Mengambil produk yang statusnya 'available' dan diurutkan berdasarkan jumlah transaksi terbanyak
    $produkTerpopuler = Item::where('status', 'available')
        ->with(['category'])
        ->withCount('rentals')
        ->orderByDesc('rentals_count')
        ->take(4) // Ambil 4 item teratas
        ->get();

    // Rekomendasi: Menampilkan produk acak atau produk terbaru
    $rekomendasi = Item::where('status', 'available')
        ->with(['category'])
        ->latest()
        ->take(4)
        ->get();

    return view('home', compact('categories', 'produkTerpopuler', 'rekomendasi'));
}

// ─────────────────────────────────────────────────────────────────────────
// BARU: Fungsi untuk Halaman Kategori Tunggal (Menangkap Parameter Slug)
// ─────────────────────────────────────────────────────────────────────────
public function filterKategori($slug)
{
    // Cari kategori berdasarkan slug URL, jika tidak ada langsung munculkan error 404
    $category = Category::where('slug', $slug)->firstOrFail();

    // Ambil item yang berada di dalam kategori tersebut
    $items = Item::where('category_id', $category->id)
        ->where('status', 'available')
        ->with(['category'])
        ->withCount('rentals')
        ->latest()
        ->paginate(12) // Menggunakan paginasi jika produk melimpah
        ->withQueryString();

    return view('kategori', compact('category', 'items'));
}
}