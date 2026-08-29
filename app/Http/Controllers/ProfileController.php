<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\UserActivityNotification; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile index page.
     */
    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $userNameBeforeUpdate = $user->name;
        $userRole = ucfirst(strtolower($user->role ?? 'user'));

        // Validate ទិន្នន័យរួមទាំងរូបភាព (កំរិតទំហំដល់ 5MB)
        // លុបបំបាត់ការជាន់គ្នាដោយបន្ថែម unique ignore id សម្រាប់ email
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'],
        ]);

        // កត់ត្រាទុកនូវការផ្លាស់ប្តូរ (Changes List) សម្រាប់ដាក់ចូល Notification
        $changes = [];
        $displayValue = fn ($value) => filled($value) ? (string) $value : 'Not set';

        if ($user->name !== $request->name) {
            $changes[] = "Name: {$displayValue($user->name)} → {$displayValue($request->name)}";
            $user->name = $request->name;
        }

        if ($user->email !== $request->email) {
            $changes[] = "Email: {$displayValue($user->email)} → {$displayValue($request->email)}";
            $user->email = $request->email;
            $user->email_verified_at = null;
        }

        if ($user->phone !== $request->phone) {
            $changes[] = "Phone: {$displayValue($user->phone)} → {$displayValue($request->phone)}";
            $user->phone = $request->phone;
        }

        if ($user->address !== $request->address) {
            $changes[] = "Address: {$displayValue($user->address)} → {$displayValue($request->address)}";
            $user->address = $request->address;
        }

        // គ្រប់គ្រងការ Upload រូបភាព Profile និងរក្សាទុកចូល Storage/Database
        if ($request->hasFile('image')) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $path = $request->file('image')->store('profile-images', 'public');
            $user->image = $path;
            $changes[] = 'Profile picture: changed to a new image';
        }

        // រក្សាទុកទិន្នន័យ
        $user->save();

        // ប្រសិនបើមានការកែប្រែទិន្នន័យណាមួយ ទើបបង្កើត Notification ចូល Database
        if (count($changes) > 0) {
            $changedFields = implode('; ', $changes);
            $message = "{$userRole} {$userNameBeforeUpdate} (ID: {$user->id}) updated profile — {$changedFields}.";

            $notification = new UserActivityNotification(
                "{$userRole} Profile Updated",
                $message,
                '#'
            );

            User::query()->each(function (User $recipient) use ($notification) {
                $recipient->notify($notification);
            });
        }

        return Redirect::back()
            ->with('success', 'Successfully Updated')
            ->with('profile_settings_open', true);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
       $request->validate([
            'name' => ['required', 'string', 'max:255'], // ត្រង់នេះត្រូវតែអត់មានពាក្យ unique ទេ
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'],
        ]);

        $user = $request->user();
        Auth::logout();
        
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}