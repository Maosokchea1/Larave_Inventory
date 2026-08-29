<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'supplier'])
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->category_id, function ($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->when($request->supplier_id, function ($query, $supplierId) {
                return $query->where('supplier_id', $supplierId);
            })
            ->paginate(5);

        $categories = Category::all();
        $suppliers = Supplier::all();
        
        return view('products.index', compact('products', 'categories', 'suppliers'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('products.index')
                ->with('error', __('Sorry, you do not have permission to create this product.'));
        }

        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('products.index')
                ->with('error', __('Sorry, you do not have permission to create this product.'));
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'SKU' => 'nullable|string|max:255|unique:products,SKU',
            'Cost' => 'required|numeric|min:0',
            'Price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'Note' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', __('Product created successfully.'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('products.index')
                ->with('error', __('Sorry, you do not have permission to edit this product.'));
        }

        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('products.index')
                ->with('error', __('Sorry, you do not have permission to edit this product.'));
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'name' => 'required|string|max:255',
            'SKU' => 'nullable|string|max:255|unique:products,SKU,' . $product->id,
            'Cost' => 'required|numeric',
            'Price' => 'required|numeric',
            'description' => 'nullable|string',
            'Note' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', __('Product updated successfully.'));
    }

    public function destroy(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('products.index')
                ->with('error', __('Sorry, you do not have permission to delete this product.'));
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', __('Product deleted successfully.'));
    }
}