<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usersetting;

class SettingsController extends Controller
{
    public function edit(Request $request)
    {
        // ទាញយក ឬបង្កើត Settings ស្វ័យប្រវត្តិក៏បាន បើអ្នកប្រើ firstOrCreate
        $settings = Usersetting::firstOrCreate(
            ['user_id' => $request->user()->id],
            [
                'theme' => 'light',
                'locale' => 'en',
                'email_notifications' => true,
                'push_notifications' => false,
            ]
        );

        // ត្រឹមត្រូវតាមទីតាំង Folder: resources/views/settings/index.blade.php
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:light,dark,system'],
            'locale' => ['required', 'in:en,km'],
            'email_notifications' => ['sometimes', 'boolean'],
            'push_notifications' => ['sometimes', 'boolean'],
        ]);

        $settings = Usersetting::firstOrCreate(['user_id' => $request->user()->id]);

        $settings->update([
            'theme' => $validated['theme'],
            'locale' => $validated['locale'],
            'email_notifications' => $request->has('email_notifications'),
            'push_notifications' => $request->has('push_notifications'),
        ]);

        $request->session()->put('locale', $validated['locale']);

        return redirect()
            ->route('settings')
            ->with('status', 'settings-updated')
            ->withCookie(cookie()->forever('locale', $validated['locale']));
    }
}
