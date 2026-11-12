<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard', [
            'productCount' => Product::count(),
            'inventoryValue' => Product::query()->selectRaw('COALESCE(SUM(unit_price * quantity), 0) AS total')->value('total'),
            'lowStockCount' => Product::query()->whereColumn('quantity', '<=', 'reorder_level')->count(),
            'lowStockProducts' => Product::query()->whereColumn('quantity', '<=', 'reorder_level')->latest()->take(5)->get(),
        ]);
    }

    public function index(Request $request): View
    {
        $products = Product::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%' . $request->string('search') . '%';
                $query->where(fn ($q) => $q->where('name', 'like', $term)->orWhere('sku', 'like', $term)->orWhere('category', 'like', $term));
            })
            ->latest()->paginate(10)->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create(): View { return view('products.create'); }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:150'], 'category' => ['required', 'string', 'max:100'],
            'supplier' => ['nullable', 'string', 'max:150'], 'unit_price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'], 'reorder_level' => ['required', 'integer', 'min:0'],
        ]);

        Product::create($data);
        return to_route('products.index')->with('success', 'Product added successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return to_route('products.index')->with('success', 'Product deleted successfully.');
    }
}
