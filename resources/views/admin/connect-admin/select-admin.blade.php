<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2.5 bg-primary/10 rounded-xl">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-heading font-khmersmart tracking-tight">
                        {{ __('Connect Admin & Permissions') }}
                    </h2>
                    <p class="text-sm text-body/70 font-sans">{{__('Manage admin accounts and their permissions')}}</p>
                </div>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl shadow-sm flex items-center justify-between animate-slide-down">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium font-english text-sm">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-emerald-600 hover:text-emerald-900 transition-colors p-1 rounded-lg hover:bg-emerald-100 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <div class="space-y-6 w-full px-4 sm:px-6 lg:px-8 mx-auto pb-12">
        
        <div class="bg-white rounded-2xl border border-default/60 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-default/40 flex items-center justify-between bg-neutral-secondary-medium/20">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-heading font-sans">{{__('Connect Admin')}}</h3>
                        <p class="text-xs text-body/70 font-sans">{{__('Select an admin account to manage permissions')}}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.connect-admin.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="admin_id" class="block text-xs font-semibold uppercase tracking-wider text-body/70 mb-2 font-sans">
                            {{__('Select Admin')}}
                        </label>
                        <div class="relative">
                            <select name="admin_id" id="admin_id" required class="w-full pl-4 pr-10 py-3 bg-neutral-secondary-medium/30 border border-default-medium rounded-xl text-heading text-sm font-sans focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all cursor-pointer">
                                <option value="" disabled {{ !session('current_admin_context') ? 'selected' : '' }}>-- {{__('Select Admin')}} --</option>
                                @foreach($admins as $admin)
                                    @php
                                        $adminId = is_object($admin) ? $admin->id : $admin['id'] ?? '';
                                        $adminName = is_object($admin) ? $admin->name : $admin['name'] ?? '';
                                        $adminEmail = is_object($admin) ? $admin->email : $admin['email'] ?? '';
                                    @endphp
                                    <option value="{{ $adminId }}" {{ (string) session('current_admin_context') === (string) $adminId ? 'selected' : '' }}>
                                        {{ $adminName }} ({{ $adminEmail }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('admin_id')
                            <span class="text-xs text-red-500 mt-1 block font-sans">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-semibold font-sans text-white bg-primary hover:bg-primary-600 focus:ring-4 focus:ring-primary/20 rounded-xl transition-all shadow-sm cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            {{ __('Connect Selected Admin') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(session()->has('current_admin_context') && session('current_admin_context') != null)
            <div class="bg-white rounded-2xl border border-default/60 shadow-sm overflow-hidden animate-fade-in-up">
                <div class="p-6 border-b border-default/40 flex items-center justify-between bg-neutral-secondary-medium/20">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-accent/10 rounded-lg text-accent">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-heading font-sans">{{ __('Role & Permissions Mapping') }}</h3>
                            <p class="text-xs text-body/70 font-sans">{{ __('Manage role-based access and permissions for administrators') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-semibold font-sans rounded-full border border-emerald-200">
                        សកម្ម (Active)
                    </span>
                </div>

                <div class="p-6">
                    @foreach($roles as $role)
                        @if(strtolower($role->name) === 'admin')
                            <form action="{{ route('admin.connect-admin.update', $role->id) }}" method="POST" class="space-y-6">
                                @csrf
                                @method('PUT')

                                <div class="flex items-center justify-between bg-neutral-secondary-medium/30 rounded-xl px-4 py-3 border border-default/40">
                                    <span class="text-sm font-semibold text-heading font-sans">{{ __('Role') }}: {{ $role->name }}</span>
                                    <span class="text-xs px-2.5 py-0.5 bg-white border border-default rounded-md text-body/60 font-sans">{{ __('ID') }}: {{ $role->id }}</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                    @foreach($permissions as $groupName => $groupPermissions)
                                        <div class="bg-neutral-secondary-medium/10 rounded-xl p-4 border border-default/30 flex flex-col justify-between">
                                            <div>
                                                <h4 class="text-xs font-bold uppercase tracking-wider text-heading/70 border-b border-default/30 pb-2 mb-3 font-sans">
                                                    {{ ucfirst($groupName) }}
                                                </h4>
                                                <div class="space-y-2">
                                                    @foreach($groupPermissions as $permission)
                                                        <label class="flex items-start gap-2.5 text-xs text-body/80 hover:text-heading transition cursor-pointer">
                                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" 
                                                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                                                class="mt-0.5 rounded border-default-medium text-primary focus:ring-primary/20 w-4 h-4 cursor-pointer">
                                                            <span class="font-sans select-none">{{ $permission->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="pt-4 border-t border-default/40 flex flex-col md:flex-row items-stretch md:items-center gap-4">
                                    <div class="flex-1">
                                        <input type="text" name="telegram_message" id="telegram_message_{{ $role->id }}" placeholder="{{ __('Enter a message for the Telegram notification...') }}" 
                                            class="w-full px-4 py-3 bg-neutral-secondary-medium/20 border border-default-medium rounded-xl text-heading text-xs font-sans focus:ring-2 focus:ring-primary/20 focus:border-primary placeholder:text-body/40">
                                    </div>
                                    
                                    <div class="shrink-0">
                                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-6 py-3 text-xs font-semibold font-sans text-white bg-primary hover:bg-primary-600 focus:ring-4 focus:ring-primary/20 rounded-xl transition-all shadow-sm cursor-pointer whitespace-nowrap">
                                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            <span>{{ __('Update & Notify Telegram') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes slide-down {
            0% { opacity: 0; transform: translateY(-10px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes fade-in-up {
            0% { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-down {
            animation: slide-down 0.3s ease-out forwards;
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.4s ease-out forwards;
        }
    </style>
</x-app-layout>