<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $filter = $request->input('filter', 'all');

        if (!in_array($filter, ['all', 'active', 'admin', 'inactive'], true)) {
            $filter = 'all';
        }

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                });
            })
            ->when($filter === 'active', fn ($query) => $query->whereRaw('LOWER(status) = ?', ['active']))
            ->when($filter === 'admin', fn ($query) => $query->whereRaw('LOWER(role) = ?', ['admin']))
            ->when($filter === 'inactive', fn ($query) => $query->whereRaw('LOWER(status) = ?', ['inactive']))
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalUsers = User::count();
        $activeUsers = User::whereRaw('LOWER(status) = ?', ['active'])->count();
        $adminUsers = User::whereRaw('LOWER(role) = ?', ['admin'])->count();
        $inactiveUsers = User::whereRaw('LOWER(status) = ?', ['inactive'])->count();

        return view('admin.users.index', compact(
            'users',
            'search',
            'filter',
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,user', // កំណត់ឱ្យច្បាស់លាស់ទទួលយកបានតែ admin ឬ user ប៉ុណ្ណោះ
            'address'  => 'nullable|string|max:500',
            'status'   => 'required|in:active,inactive',
        ]);

        // แปลง role ឱ្យទៅជាអក្សរតូចជានិច្ច មុននឹងរក្សាទុក
        $validated['role'] = strtolower($validated['role']);

        // Hash ពាក្យសម្ងាត់មុននឹងរក្សាទុក
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role'    => 'required|in:admin,user', // កំណត់ឱ្យច្បាស់លាស់ទទួលយកបានតែ admin ឬ user ប៉ុណ្ណោះ
            'address' => 'nullable|string|max:500',
            'status'  => 'required|in:active,inactive',
        ]);

        // แปลง role ឱ្យទៅជាអក្សរតូចជានិច្ច ពេល Update
        $validated['role'] = strtolower($validated['role']);

        // ប្រសិនបើមានបញ្ចូល Password ថ្មី ទើបធ្វើការ Update Password
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}