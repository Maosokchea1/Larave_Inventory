<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class StockTransferController extends Controller
{
    /**
     * Display a listing of the stock transfers.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transfers = StockTransaction::where('type', 'transfer')
            ->when($search, function ($query, $search) {
                // ស្វែងរកតែតាមរយៈឈ្មោះផលិតផល (Product Name) តាមរយៈ Relation
                $query->whereHas('product', function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%");
                });
            })
            ->with(['product', 'user'])
            ->latest()
            ->paginate(5)
            ->withQueryString(); // រក្សាតម្លៃ search ពេលចុចប្តូរ Page (Pagination)

        $products = Product::all(); // ទាញយកទិន្នន័យផលិតផលសម្រាប់ប្រើប្រាស់

        return view('stock.transfer', compact('transfers', 'products'));
    }

    /**
     * Show the form for creating a new stock transfer.
     */
    public function create()
    {
        $products = Product::all();
        return view('stock.transfer-create', compact('products'));
    }

    /**
     * Store a newly created stock transfer in storage.
     */
    public function store(Request $request)
    {
        // ឆែកសិទ្ធិ Admin 
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.transfer.index')
                ->with('error', __('transfer_unauthorized'));
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $product = Product::findOrFail($request->product_id);

            StockTransaction::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'type' => 'transfer',
                'quantity' => $request->quantity,
                'reference' => $request->reference,
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('stock.transfer.index')->with('success', __('transfer_success_message'));
    }

    /**
     * Show the form for editing the specified stock transfer.
     */
    public function edit($id)
    {
        $transfer = StockTransaction::where('type', 'transfer')->findOrFail($id);
        $products = Product::all();

        return view('stock.transfer-edit', compact('transfer', 'products'));
    }

    /**
     * Update the specified stock transfer in storage.
     */
    public function update(Request $request, $id)
    {
        // ឆែកសិទ្ធិ Admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.transfer.index')
                ->with('error', __('transfer_unauthorized'));
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $id) {
            $transfer = StockTransaction::where('type', 'transfer')->findOrFail($id);

            $transfer->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'reference' => $request->reference,
                'notes' => $request->notes,
            ]);
        });

        return redirect()->route('stock.transfer.index')->with('success', __('transfer_update_success_message'));
    }

    /**
     * Remove the specified stock transfer from storage.
     */
    public function destroy($id)
    {
        // ឆែកសិទ្ធិ Admin
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.transfer.index')
                ->with('error', __('transfer_unauthorized'));
        }

        $transfer = StockTransaction::where('type', 'transfer')->findOrFail($id);
        $transfer->delete();

        return redirect()->route('stock.transfer.index')->with('success', __('transfer_delete_success_message'));
    }
}