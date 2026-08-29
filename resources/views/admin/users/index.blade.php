<x-app-layout>
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-semibold text-colorblue-500 font-khmersmart">{{ __('User Management') }}</h1>
            <p class="text-sm text-body mt-0.5">{{ __('Manage all registered users efficiently.') }}</p>
        </div>

        <!-- Action Button -->
        <div x-data="">
       
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('admin.users.index', ['filter' => 'all']) }}" class="bg-neutral-primary-soft p-5 rounded-xl border {{ ($filter ?? 'all') === 'all' ? 'border-primary ring-2 ring-primary/20' : 'border-default' }} shadow-xs flex items-center justify-between transition hover:border-primary">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-body">{{ __('Total Users') }}</p>
                <h3 class="text-2xl font-bold text-heading mt-1">{{ $totalUsers ?? 0 }}</h3>
            </div>
            <div class="p-3 bg-primary/10 text-primary rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.users.index', ['filter' => 'active']) }}" class="bg-neutral-primary-soft p-5 rounded-xl border {{ ($filter ?? 'all') === 'active' ? 'border-primary ring-2 ring-primary/20' : 'border-default' }} shadow-xs flex items-center justify-between transition hover:border-primary">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-body">{{ __('Active Users') }}</p>
                <h3 class="text-2xl font-bold text-heading mt-1">{{ $activeUsers ?? 0 }}</h3>
            </div>
            <div class="p-3 bg-green-50 text-green-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.users.index', ['filter' => 'admin']) }}" class="bg-neutral-primary-soft p-5 rounded-xl border {{ ($filter ?? 'all') === 'admin' ? 'border-primary ring-2 ring-primary/20' : 'border-default' }} shadow-xs flex items-center justify-between transition hover:border-primary">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-body">{{ __('Admins') }}</p>
                <h3 class="text-2xl font-bold text-heading mt-1">{{ $adminUsers ?? 0 }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>

        <a href="{{ route('admin.users.index', ['filter' => 'inactive']) }}" class="bg-neutral-primary-soft p-5 rounded-xl border {{ ($filter ?? 'all') === 'inactive' ? 'border-primary ring-2 ring-primary/20' : 'border-default' }} shadow-xs flex items-center justify-between transition hover:border-primary">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-body">{{ __('Inactive Users') }}</p>
                <h3 class="text-2xl font-bold text-heading mt-1">{{ $inactiveUsers ?? 0 }}</h3>
            </div>
            <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </a>
    </div>

    <!-- Search Toolbar Card -->
    <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}">
            <div class="relative w-full sm:max-w-md flex-1">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input
                    value="{{ request('search') }}"
                    type="search"
                    name="search"
                    id="simple-search"
                    onsearch="if(this.value==''){ this.form.submit(); }"
                    class="w-full pl-10 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-sans focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all"
                    placeholder="{{ __('Search user name or email...') }}" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none px-4 py-2.5 text-sm font-medium font-sans text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                    {{ __('Search') }}
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index', ['filter' => $filter ?? 'all']) }}" class="px-4 py-2.5 text-sm font-medium font-sans text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center">
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Error Flash Message -->
    @if (session('error'))
        <div class="mb-6 p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-xs transition-all font-khmer">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-rose-600 hover:text-rose-900 font-bold text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="mb-6 p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between shadow-xs transition-all">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium font-english">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-green-600 hover:text-green-900 font-bold text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-neutral-primary-soft shadow-xs rounded-xl border border-default overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-body">
                <thead class="text-xs uppercase bg-primary text-white tracking-wider font-sans shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('ID') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Photo') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Email / Mobile') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Role') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Address') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Status') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Created') }}</th>
                        <th scope="col" class="px-6 py-3.5 text-right font-extrabold">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    @forelse ($users as $user)
                    <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                        <td class="px-6 py-4 font-medium font-english text-heading whitespace-nowrap">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-xs overflow-hidden">
                                @if(isset($user->image) && $user->image)
                                    <img src="{{ Str::startsWith($user->image, ['http://', 'https://']) ? $user->image : asset('storage/' . $user->image) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium font-english text-heading">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-xs font-english">
                            <div class="text-heading font-medium">{{ $user->email }}</div>
                            <div class="text-body mt-0.5">{{ $user->mobile ?? $user->phone ?? 'No mobile' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-primary text-white rounded-full text-xs font-medium capitalize font-english">
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-english text-heading max-w-xs truncate" title="{{ $user->address }}">
                            {{ $user->address ?? 'No address' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 {{ ($user->status ?? 'Active') === 'Active' ? 'bg-emerald-500' : 'bg-rose-500' }} text-white rounded-full text-xs font-medium font-english">
                                {{ $user->status ?? 'Active' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-body font-english whitespace-nowrap">
                            {{ $user->created_at->format('n/j/Y, g:i:s A') }}
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap" x-data="">
                            <div class="inline-flex items-center gap-2">
                                <!-- View Button -->
                                <button 
                                    type="button" 
                                    @click="$dispatch('open-modal', 'view-user'); $dispatch('view-user-data', @js([
                                        'id' => $user->id,
                                        'image' => $user->image ? (Str::startsWith($user->image, ['http://', 'https://']) ? $user->image : asset('storage/' . $user->image)) : '',
                                        'name' => $user->name,
                                        'email' => $user->email,
                                        'mobile' => $user->mobile ?? $user->phone ?? 'No mobile',
                                        'role' => $user->role ?? 'user',
                                        'address' => $user->address ?? 'No address',
                                        'status' => $user->status ?? 'Active',
                                        'created_at' => optional($user->created_at)->format('n/j/Y, g:i:s A')
                                    ]))"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-english text-sky-600 bg-sky-50 hover:bg-sky-100 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    {{ __('View') }}
                                </button>

                                <!-- Edit Button -->

                                <!-- Delete Form & Button -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-english text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75M18 21v-2a4 4 0 0 0-3-3.87m-9-3.87a4 4 0 1 0 0-7.75M2 21v-2a4 4 0 0 1 3-3.87" />
                                        </svg>
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 gap-2">
                                <svg class="w-10 h-10 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="text-sm font-medium text-body">{{ __('No record found') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if ($users->hasPages())
            <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-english">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Components -->
  


   
    @include('admin.users.View')
</x-app-layout>