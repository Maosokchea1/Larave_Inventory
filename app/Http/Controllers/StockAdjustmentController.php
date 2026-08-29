<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    // បង្ហាញទម្រង់កែសម្រួលស្តុក និងប្រវត្តិសកម្មភាពកន្លងមក
    public function index()
    {
        $products = Product::all();
        $adjustments = StockTransaction::with(['product', 'user'])
                    ->where('type', 'adjustment')
                    ->latest()
                    ->paginate(5);

        return view('stock.adjustments', compact('products', 'adjustments'));
    }

    // រក្សាទុកការកែសម្រួលស្តុក
    public function store(Request $request)
    {
        // ឆែកសិទ្ធិ Admin 
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('stock.adjustments')
                ->with('error', __('adj_unauthorized'));
        }

        // Validate Input (ដោះស្រាយករណី Input action ឬ adjustment_type)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:1',
            'note' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // ១. ទាញយក Product ស្រស់ៗចេញពី Database និង Lock Row ការពារ Concurrent updates
                $product = Product::where('id', $request->product_id)->lockForUpdate()->firstOrFail();
                
                $oldStock = (int)$product->stock;
                $qty = (int)$request->quantity;
                $newStock = $oldStock;

                // ២. គណនាចំនួនស្តុកថ្មី
                if ($request->adjustment_type === 'add') {
                    $newStock = $oldStock + $qty;
                    $qtyChange = $qty;
                } elseif ($request->adjustment_type === 'subtract') {
                    if ($qty > $oldStock) {
                        throw new \Exception(__('adj_exceed_stock'));
                    }
                    $newStock = $oldStock - $qty;
                    $qtyChange = $qty;
                } else {
                    // set (កំណត់ចំនួនស្តុកថ្មីផ្ទាល់)
                    $qtyChange = abs($qty - $oldStock);
                    $newStock = $qty;
                }

                // ៣. UPDATE ស្តុកផលិតផលផ្ទាល់ក្នុង DB
                $product->stock = $newStock;
                $product->save();

                // ៤. កត់ត្រាចូលតារាងប្រវត្តិ Stock Transaction
                StockTransaction::create([
                    'product_id'   => $product->id,
                    'suppliers_id' => null,
                    'user_id'      => Auth::id(),
                    'type'         => 'adjustment', 
                    'quantity'     => $qtyChange,
                    'note'         => "Adjustment ({$request->adjustment_type}): Old Stock ($oldStock) -> New Stock ($newStock). Reason: " . $request->note,
                ]);
            });

            return redirect()->route('stock.adjustments')->with('success', __('adj_success_message'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}