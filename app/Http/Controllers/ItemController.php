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
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke barang ini.');
        }

        return view('pages.items.itemsDetail', compact('item'));
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
}