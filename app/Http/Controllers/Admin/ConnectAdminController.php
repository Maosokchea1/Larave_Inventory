<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Http;

class ConnectAdminController extends Controller
{
    /**
     * បង្ហាញទំព័រជ្រើសរើស Admin និង ផែនទីសិទ្ធិ (Role & Permissions)
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();

        $roles = Role::with('permissions')->get();
        
        $permissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0] ?? 'General';
        });

        return view('admin.connect-admin.select-admin', compact('admins', 'roles', 'permissions'));
    }

    /**
     * រក្សាទុក Admin ដែលបានជ្រើសរើសចូលក្នុង Session (Connect Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // Save session និង បង្ខំឱ្យប្រព័ន្ធ save ភ្លាមៗ (ដោះស្រាយបញ្ហា Select មិនដើរ)
        session(['current_admin_context' => $request->admin_id]);
        $request->session()->save();

        return redirect()->back()->with('success', __('Admin connected successfully!'));
    }

    /**
     * អាប់ដេតសិទ្ធិ Role & Permissions និង ផ្ញើសារចូល Telegram Bot
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->permissions()->sync($request->input('permissions', []));

        $customMessage = $request->input('telegram_message');

        // ចាប់យកព័ត៌មានរបស់ User ដែលកំពុង Login ផ្ទាល់
        $admin = auth()->user();

        // ដកស្រង់ Token/Chat ID ពី .env បើគ្មានទើបប្រើ Default Value (ដើម្បើសុវត្ថិភាព)
        $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN', '8895189912:AAH21OnDZYMUQIWZ1MlC6cxYJJ-N-V04h24'));
        $chatId = config('services.telegram.chat_id', env('TELEGRAM_CHAT_ID', '1302983925'));

        // ទាញយក Role Name របស់ User ដែលកំពុង Login (ទប់ទល់គ្រប់លក្ខណៈ Relationship ក្នុង Database)
        $userRoleName = 'N/A';
        if ($admin) {
            if (isset($admin->roles) && method_exists($admin->roles(), 'get') && $admin->roles->isNotEmpty()) {
                $userRoleName = $admin->roles->pluck('name')->implode(', ');
            } elseif (isset($admin->role_name)) {
                $userRoleName = $admin->role_name;
            } elseif (isset($admin->role)) {
                $userRoleName = is_object($admin->role) ? ($admin->role->name ?? 'N/A') : $admin->role;
            }
        }

        // ទាញយកលេខទូរស័ព្ទ
        $phone = $admin->phone 
            ?? $admin->phone_number 
            ?? $admin->tel 
            ?? $admin->telephone 
            ?? $admin->mobile 
            ?? $admin->contact 
            ?? 'N/A';

        // ទាញយកអាសយដ្ឋាន
        $address = $admin->address 
            ?? $admin->location 
            ?? $admin->city 
            ?? $admin->province 
            ?? $admin->street 
            ?? 'N/A';

        // រៀបចំសារ Telegram ឱ្យបង្ហាញ Role Name របស់ User ដែលកំពុង Login
        $message = "🔔 *Role Permissions Updated!*\n\n" .
                   "• *Role Name:* {$userRoleName}\n" .
                   "• *Name:* " . ($admin->name ?? 'N/A') . "\n" .
                   "• *Phone:* {$phone}\n" .
                   "• *Address:* {$address}\n";

        if (!empty(trim($customMessage))) {
            $message .= "• *Message:* _{$customMessage}_\n";
        } else {
            $message .= "• *Message:* _N/A_\n";
        }

        $message .= "\n• *Status:* Success ✅";

        $response = Http::withoutVerifying()->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'Markdown',
        ]);

        if ($response->failed()) {
            dd([
                'status' => 'Failed to send Telegram message',
                'telegram_error' => $response->json(),
                'checked_chat_id' => $chatId
            ]);
        }

        return redirect()->back()->with('success', __('Permissions updated and notification sent to Telegram successfully!'));
    }
}