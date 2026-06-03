<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(12);

        return view(
            'pages.items.itemsList',
            compact('items')
        );
    }

    public function create()
    {
        $categories = Category::all();

        return view(
            'pages.items.itemsEditCreate',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price_per_day' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request
                ->file('image')
                ->store('items', 'public');
        }

        Item::create([
            'user_id' => 1,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price_per_day' => $request->price_per_day,
            'stock' => $request->stock,
            'image' => $image,
            'status' => 'available'
        ]);

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Item $item)
    {
        return view(
            'pages.items.itemsDetail',
            compact('item')
        );
    }

    public function edit(Item $item)
    {
        $categories = Category::all();

        return view(
            'pages.items.itemsEditCreate',
            compact('item', 'categories')
        );
    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'price_per_day' => 'required|numeric',
            'stock' => 'required|numeric'
        ]);

        $item->update($data);

        return redirect()
            ->route('items.show', $item->id);
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()
            ->route('items.index');
    }
}