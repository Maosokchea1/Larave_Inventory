<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Carbon\Carbon;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('suppliers.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function store(Request $request)
    {
        // ឆែកសិទ្ធិ៖ ប្រសិនបើមិនមែនជា Admin ទេ មិនអាចរក្សាទុកបានទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('suppliers.index')
                ->with('error', __('សូមអភ័យទោស អ្នកគ្មានសិទ្ធិបង្កើត Supplier នេះទេ!'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'date_time' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        // បម្លែង Date Time មុនរក្សាទុកចូល Database
        if (!empty($validated['date_time'])) {
            $dateTimeStr = str_replace(['ព្រឹក', 'ល្ងាច'], ['AM', 'PM'], $validated['date_time']);
            try {
                $validated['date_time'] = Carbon::parse($dateTimeStr)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $validated['date_time'] = null;
            }
        }

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', __('Supplier created successfully.'));
    }

    public function update(Request $request, $id)
    {
        // ឆែកសិទ្ធិ៖ ប្រសិនបើមិនមែនជា Admin ទេ មិនអាចកែប្រែបានទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('suppliers.index')
                ->with('error', __('Not authorized to update supplier.'));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'date_time' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->name = $validated['name'];
        $supplier->phone = $validated['phone'];
        $supplier->email = $validated['email'];

        // បម្លែង Date Time មុនពេល update
        if (!empty($validated['date_time'])) {
            $dateTimeStr = str_replace(['ព្រឹក', 'ល្ងាច'], ['AM', 'PM'], $validated['date_time']);
            try {
                $supplier->date_time = Carbon::parse($dateTimeStr)->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $supplier->date_time = null;
            }
        } else {
            $supplier->date_time = null;
        }

        $supplier->note = $validated['note'];
        $supplier->save();

        return redirect()->route('suppliers.index')->with('success', __('Supplier updated successfully.'));
    }

    public function destroy($id)
    {
        // ឆែកសិទ្ធិ៖ ប្រសិនបើមិនមែនជា Admin ទេ មិនអាចលុបបានទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('suppliers.index')
                ->with('error', __('សូមអភ័យទោស អ្នកគ្មានសិទ្ធិលុប Supplier នេះទេ!'));
        }

        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', __('Supplier deleted successfully.'));
    }
}
