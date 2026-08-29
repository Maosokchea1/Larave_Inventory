<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB; // ប្រើប្រសិនបើត្រូវការ (ស្រេចចិត្ត)

class DashboardController extends Controller
{
    public function index()
    {
        // ============ 1. STATISTICS ============
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        // ============ 2. CATEGORY RATIO CHART ============
        $categories = Category::withCount('products')->get();
        $categoryLabels = $categories->pluck('name');
        $categoryData = $categories->pluck('products_count');

        // ============ 3. STOCK MOVEMENT CHART (WEEKLY) ============
        $days = collect(range(6, 0))->map(fn ($daysAgo) => now()->subDays($daysAgo));
        $transactions = StockTransaction::where('created_at', '>=', $days->first()->copy()->startOfDay())
            ->get()
            ->groupBy(fn ($transaction) => $transaction->created_at->toDateString());

        $stockLabels = $days->map(fn ($day) => $day->format('D'));
        $stockInData = $days->map(fn ($day) => $transactions
            ->get($day->toDateString(), collect())
            ->where('type', 'in')
            ->sum('quantity'));
        $stockOutData = $days->map(fn ($day) => $transactions
            ->get($day->toDateString(), collect())
            ->where('type', 'out')
            ->sum('quantity'));

        // ============ 4. RECENT STOCK ACTIVITIES (10 ចុងក្រោយ) ============
        $recentMovements = StockTransaction::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($transaction) {
                return (object) [
                    'product_name' => $transaction->product->name ?? 'N/A',
                    'type'         => $transaction->type, // 'in' or 'out' (ឬ 'adjustment', 'transfer')
                    'quantity'     => $transaction->quantity,
                    'created_at'   => $transaction->created_at,
                    'user_name'    => $transaction->user->name ?? '—',
                ];
            });

        // ============ 5. ផ្ញើទិន្នន័យទាំងអស់ទៅ VIEW ============
        return view('dashboard', compact(
            'totalProducts',
            'lowStockCount',
            'totalCategories',
            'totalSuppliers',
            'categoryLabels',
            'categoryData',
            'stockLabels',
            'stockInData',
            'stockOutData',
            'recentMovements' // <--- បន្ថែមអថេរនេះ
        ));
    }
}