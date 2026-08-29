<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // សម្រាប់ការស្វែងរកតាមឈ្មោះ ឬអ៊ីម៉ែល
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // បង្ខំតម្រៀបតាម ID ពីតូចទៅធំ ឱ្យដាច់ខាត (ID 1 ឡើងលើគេ)
        $users = $query->reorder()->orderBy('id', 'asc')->paginate(5);

        // គណនាលេខស្ថិតិឱ្យត្រូវជាមួយទិន្នន័យក្នុង Database (ទាំងអក្សរតូច និងធំ)
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'Active')->orWhere('status', 'active')->count();
        $adminUsers = User::where('role', 'Admin')->orWhere('role', 'admin')->count();
        $inactiveUsers = User::where('status', 'Inactive')->orWhere('status', 'inactive')->count();

        return view('admin.users.index', compact(
            'users', 
            'totalUsers', 
            'activeUsers', 
            'adminUsers', 
            'inactiveUsers'
        ));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'string'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // អនុញ្ញាតទំហំរហូតដល់ 5MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'] ?? 'user',
            'mobile' => $validated['mobile'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'status' => $validated['status'] ?? 'Active',
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.users.index')->with('success', __('User created successfully.'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['nullable', 'string'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'], // អនុញ្ញាតទំហំរហូតដល់ 5MB
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $user->image = $imagePath;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $validated['role'] ?? $user->role;
        $user->mobile = $validated['mobile'] ?? $user->mobile;
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->address = $validated['address'] ?? $user->address;
        $user->status = $validated['status'] ?? $user->status;
        $user->save();

        return redirect()->back()->with('success', 'Successfully Updated');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', __('User deleted successfully.'));
    }
}