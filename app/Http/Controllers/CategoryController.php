<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->where('active', true)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(5);

        return view('category.index', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        // 0. ពិនិត្យសិទ្ធិ៖ ប្រសិនបើមិនមែន admin មិនអនុញ្ញាតឱ្យរក្សាទុកទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Sorry, you do not have permission to create this category.'));
        }

        // 1. ពិនិត្យទិន្នន័យ (Validation)
        $request->validate([
            'name' => 'required|string|max:255',
            'Note' => 'nullable|string',
        ]);

        // 2. រក្សាទុកចូល Database
        Category::create([
            'name' => $request->name,
            'Note' => $request->Note,
            'active' => true,
        ]);

        // 3. Redirect ជាមួយ Success Message
        return redirect()->route('categories.index')->with('success', __('Category created successfully.'));
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // 0. ពិនិត្យសិទ្ធិ៖ ប្រសិនបើមិនមែន admin មិនអនុញ្ញាតឱ្យកែប្រែទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Sorry, you do not have permission to edit this category.'));
        }

        // 1. ពិនិត្យទិន្នន័យពេល Update
        $request->validate([
            'name' => 'required|string|max:255',
            'Note' => 'nullable|string',
        ]);

        // 2. រកមើល Category និងធ្វើការ Update
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'Note' => $request->Note,
        ]);

        // 3. Redirect ជាមួយ Success Message
        return redirect()->route('categories.index')->with('success', __('Category updated successfully.'));
    }

    public function destroy($id)
    {
        // 0. ពិនិត្យសិទ្ធិ៖ ប្រសិនបើមិនមែន admin មិនអនុញ្ញាតឱ្យលុបទេ
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()
                ->with('error', __('Sorry, you do not have permission to delete this category.'));
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', __('Category deleted successfully.'));
    }
}