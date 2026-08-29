<?php

namespace App\Http\Controllers;

use App\Models\ProductSetting;
use Illuminate\Http\Request;

class ProductSettingController extends Controller
{
    public function index()
    {
        $settings = ProductSetting::latest()->paginate(10);
        return view('admin.products-settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
        ]);

        // កែពី $request->all() មកជា $request->only(['type', 'name'])
        ProductSetting::create($request->only(['type', 'name']));

        return redirect()->back()->with('success', 'Product Setting created successfully.');
    }

    public function update(Request $request, ProductSetting $productSetting)
    {
        $request->validate([
            'type' => 'required|string',
            'name' => 'required|string|max:255',
        ]);

        // កែពី $request->all() មកជា $request->only(['type', 'name'])
        $productSetting->update($request->only(['type', 'name']));

        return redirect()->back()->with('success', 'Product Setting updated successfully.');
    }

    public function destroy(ProductSetting $productSetting)
    {
        $productSetting->delete();
        return redirect()->back()->with('success', 'Product Setting deleted successfully.');
    }
}