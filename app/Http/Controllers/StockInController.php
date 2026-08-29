<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    /**
     * បង្ហាញទម្រង់បញ្ចូលទំនិញ (Form Stock In) និងបញ្ជីប្រវត្តិ Stock In កន្លងមក
     */
    public function index()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $stockIns = StockTransaction::with(['product', 'supplier', 'user'])
                    ->where('type', 'in')
                    ->latest()
                    ->paginate(5);

        return view('stock.in', compact('products', 'suppliers', 'stockIns'));
    }

    /**
     * រក្សាទុកទិន្នន័យ Stock In និងកើនឡើងចំនួនស្តុកស្វ័យប្រវត្ត
     */
    public function store(Request $request)
    {
        // ឆែកសិទ្ធិ Admin បន្ថែមក្នុង Function ផ្ទាល់ ឬតាមរយៈ Route
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.in')
                ->with('error', __('unauthorized'));
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'suppliers_id' => 'nullable|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            StockTransaction::create([
                'product_id' => $request->product_id,
                'suppliers_id' => $request->suppliers_id,
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $request->quantity,
                'note' => $request->note,
            ]);

            $product = Product::find($request->product_id);
            $product->increment('stock', $request->quantity);
        });

        return redirect()->route('stock.in')->with('success', __('success_message'));
    }
}