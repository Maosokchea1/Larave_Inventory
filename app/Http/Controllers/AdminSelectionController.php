<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ConnectAdminController extends Controller
{
    /**
     * បង្ហាញបញ្ជី Admin ទាំងអស់សម្រាប់ជ្រើសរើស
     */
    public function index()
    {
        // ទាញយក user ទាំងអស់មកបង្ហាញ (អាចកែសម្រួលបន្ថែម query តាមតម្រូវការ)
        $admins = User::all(); 

        return view('admin.connect-admin.index', compact('admins'));
    }

    /**
     * រក្សាទុក Admin ដែលបានជ្រើសរើសចូលក្នុង Session
     */
    public function store(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        // រក្សាទុក ID របស់ Admin ចូលក្នុង Session
        session(['current_admin_context' => $request->admin_id]);

        return redirect()->route('dashboard')->with('success', 'Admin connected successfully!');
    }
}