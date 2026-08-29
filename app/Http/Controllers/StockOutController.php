<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    // បង្ហាញទម្រង់ចេញទំនិញ (Form Stock Out) និងបញ្ជីប្រវត្តិ Stock Out កន្លងមក
    public function index()
    {
        $products = Product::all();
        $stockOuts = StockTransaction::with(['product', 'user'])
                    ->where('type', 'out')
                    ->latest()
                    ->paginate(5);

        return view('stock.out', compact('products', 'stockOuts'));
    }

    // រក្សាទុកទិន្នន័យ Stock Out និងកាត់បន្ថយចំនួនស្តុកស្វ័យប្រវត្ត
    public function store(Request $request)
    {
        // ឆែកសិទ្ធិ Admin ឬសិទ្ធិអនុញ្ញាត
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.out')
                ->with('error', __('out_unauthorized'));
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $product = Product::find($request->product_id);

        // ពិនិត្យមើលថាតើស្តុកក្នុងឃ្លាំងគ្រប់គ្រាន់ឬអត់
        if ($product->stock < $request->quantity) {
            return back()->with('error', __('stock_not_enough', ['stock' => $product->stock]));
        }

        DB::transaction(function () use ($request, $product) {
            // ១. កត់ត្រាចូលតារាងប្រវត្តិ Stock Transaction (type = out)
            StockTransaction::create([
                'product_id' => $request->product_id,
                'suppliers_id' => null, // Stock Out មិនបាច់មាន Supplier ទេ
                'user_id' => Auth::id(),
                'type' => 'out',
                'quantity' => $request->quantity,
                'note' => $request->note,
            ]);

            // ២. កាត់បន្ថយចំនួនស្តុក (Decrement) របស់ផលិតផល
            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('stock.out')->with('success', __('out_success_message'));
    }
}