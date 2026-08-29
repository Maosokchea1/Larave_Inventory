<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $roles = Role::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $users = User::all();

        return view('admin.roles.index', compact('roles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $role = Role::create([
            'name'    => $request->name,
            'user_id' => $request->user_id,
        ]);

        // ធ្វើបច្ចុប្បន្នភាពសិទ្ធិក្នុងតារាង users ផ្ទាល់ ដើម្បីឱ្យ User ឡើងជា admin
        if ($request->filled('user_id')) {
            $user = User::find($request->user_id);
            if ($user) {
                $roleName = strtolower($request->name);
                $user->role = str_contains($roleName, 'admin') ? 'admin' : 'user';
                $user->save();
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // ប្រសិនបើដក User ចាស់ចេញពី Role នេះ ឱ្យប្តូរ User ចាស់នោះទៅជា user ធម្មតាវិញ
        if ($role->user_id && $role->user_id != $request->user_id) {
            $oldUser = User::find($role->user_id);
            if ($oldUser) {
                $oldUser->role = 'user';
                $oldUser->save();
            }
        }

        $role->update([
            'name'    => $request->name,
            'user_id' => $request->user_id,
        ]);

        // ធ្វើបច្ចុប្បន្នភាពសិទ្ធិរបស់ User ថ្មីក្នុងតារាង users
        if ($request->filled('user_id')) {
            $newUser = User::find($request->user_id);
            if ($newUser) {
                $roleName = strtolower($request->name);
                $newUser->role = str_contains($roleName, 'admin') ? 'admin' : 'user';
                $newUser->save();
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    public function destroy(Role $role)
    {
        // ប្រសិនបើលុប Role ដែលមាន User កាន់កាប់ អាចដូរ User នោះមកជា user ធម្មតាវិញ
        if ($role->user_id) {
            $user = User::find($role->user_id);
            if ($user) {
                $user->role = 'user';
                $user->save();
            }
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}