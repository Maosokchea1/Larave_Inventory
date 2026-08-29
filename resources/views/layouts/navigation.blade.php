<!-- Navbar ជាមួយ Dark Mode និង Font Sans-serif -->
<nav class="fixed top-0 z-50 w-full border-b border-slate-200 bg-white/95 backdrop-blur dark:border-slate-800 dark:bg-slate-900/95" style="font-family: 'Khmer OS Battambang', system-ui, -apple-system, sans-serif;">
    <div class="flex items-center justify-between px-4 py-2.5 lg:px-6">

        <!-- Brand -->
        <div class="flex items-center gap-3">
            <button
                type="button"
                onclick="document.getElementById('top-bar-sidebar')?.classList.toggle('-translate-x-full')"
                class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-primary/20 dark:text-slate-300 dark:hover:bg-slate-800 sm:hidden"
                aria-controls="top-bar-sidebar">
                <span class="sr-only">{{ __('Open sidebar') }}</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-primary text-white shadow-sm">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m3 7 9-5 9 5-9 5-9-5Zm0 0v10l9 5 9-5V7M12 12v10" />
                    </svg>
                </span>
                <span class="hidden text-lg font-sans text-slate-800 dark:text-white sm:block">
                    {{ __('Inventory') }}
                </span>
            </a>
        </div>

        <div class="flex items-center gap-2">

            <!-- Language -->
            <div class="relative" x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    @keydown.escape.window="open = false"
                    :aria-expanded="open"
                    class="inline-flex h-10 items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                    <img src="https://flagcdn.com/w20/{{ app()->getLocale() === 'km' ? 'kh' : 'us' }}.png"
                         class="h-4 w-5 rounded-sm object-cover shadow-sm"
                         alt="{{ app()->getLocale() === 'km' ? 'Cambodia' : 'United States' }} flag">
                    <span class="hidden sm:inline">
                        {{ app()->getLocale() === 'km' ? 'ខ្មែរ' : 'English' }}
                    </span>
                    <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-40 rounded-xl border border-slate-200 bg-white p-1.5 shadow-lg dark:border-slate-700 dark:bg-slate-800">

                    <a href="{{ route('language.switch', 'en') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition
                        {{ app()->getLocale() === 'en'
                            ? 'bg-primary/10 font-semibold text-primary dark:bg-primary/20'
                            : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700' }}">
                        <img src="https://flagcdn.com/w20/us.png" class="h-4 w-5 rounded-sm object-cover shadow-sm" alt="United States flag">
                        <span>English</span>
                        @if (app()->getLocale() === 'en')
                            <svg class="ml-auto h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        @endif
                    </a>

                    <a href="{{ route('language.switch', 'km') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition
                        {{ app()->getLocale() === 'km'
                            ? 'bg-primary/10 font-semibold text-primary dark:bg-primary/20'
                            : 'text-slate-700 hover:bg-slate-100 dark:text-slate-200 dark:hover:bg-slate-700' }}">
                        <img src="https://flagcdn.com/w20/kh.png" class="h-4 w-5 rounded-sm object-cover shadow-sm" alt="Cambodia flag">
                        <span>ខ្មែរ</span>
                        @if (app()->getLocale() === 'km')
                            <svg class="ml-auto h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Notifications Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    class="relative flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
                    @endif
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    style="display: none;" 
                    class="absolute right-0 z-50 mt-2 w-80 rounded-xl border border-slate-200 bg-white shadow-xl py-2 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                    <div class="px-4 py-2 border-b border-slate-100 flex justify-between items-center dark:border-slate-700">
                        <span class="text-xs font-sans uppercase tracking-wider text-slate-700 dark:text-slate-300">{{ __('Notifications') }}</span>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                          <form action="{{ route('notifications.read-all') }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <button type="submit" font-sans class="text-xs text-primary hover:underline cursor-pointer">{{ __('Mark all as read') }}</button>
                          </form>
                        @endif
                    </div>

                    <div class="max-h-64 overflow-y-auto divide-y divide-slate-100 text-left dark:divide-slate-700">
                        @forelse(auth()->user()->notifications()->take(5)->get() as $notification)
                            <div class="px-4 py-3 hover:bg-slate-50 transition-colors dark:hover:bg-slate-700/50 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <p class="text-xs font-sans text-slate-800 dark:text-slate-100">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                <p class="text-xs text-slate-600 mt-0.5 dark:text-slate-400">{{ $notification->data['message'] ?? '' }}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block dark:text-slate-500">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                        @empty
                            <div class="px-4 py-6 text-center text-xs text-slate-500 dark:text-slate-400">
                              {{ __('No notifications found') }}
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Light / dark mode -->
            <button
                type="button"
                x-data="{ dark: document.documentElement.classList.contains('dark') }"
                @click="toggleTheme(); dark = !dark"
                @theme-changed.window="dark = $event.detail"
                class="flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                :title="dark ? @js(__('Light mode')) : @js(__('Dark mode'))"
                aria-label="{{ __('Toggle light and dark mode') }}">
                <svg x-show="!dark" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z" />
                </svg>
                <svg x-cloak x-show="dark" class="h-5 w-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="4" />
                    <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4" />
                </svg>
            </button>

            <!-- Primary color -->
            <label
                class="relative flex h-10 w-10 cursor-pointer items-center justify-center overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                title="{{ __('Choose primary color') }}">
                <svg class="pointer-events-none h-5 w-5 text-slate-600 dark:text-slate-300" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor" />
                    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor" />
                    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor" />
                    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor" />
                    <path d="M12 2a10 10 0 1 0 0 20c1 0 1.7-.8 1.7-1.7 0-.5-.2-.9-.5-1.2-.2-.2-.3-.4-.3-.7 0-.5.4-.9.9-.9h1.8A6.4 6.4 0 0 0 22 11.1C22 6.1 17.5 2 12 2Z" />
                </svg>
                <input
                    type="color"
                    value="#0e7ea3"
                    oninput="setPrimaryColor(this.value)"
                    x-init="$el.value = localStorage.getItem('primaryColor') || '#0e7ea3'"
                    class="absolute inset-0 h-full w-full cursor-pointer opacity-0"
                    aria-label="{{ __('Choose primary color') }}">
            </label>

            <!-- User menu -->
            <div class="relative" x-data="{ open: false }">
                <button
                    type="button"
                    @click="open = !open"
                    @keydown.escape.window="open = false"
                    :aria-expanded="open"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-sm font-sans text-white shadow-sm transition hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-primary/20">
                    <span class="sr-only">{{ __('Open user menu') }}</span>
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </button>

                <div
                    x-cloak
                    x-show="open"
                    x-transition
                    @click.outside="open = false"
                    class="absolute right-0 z-50 mt-2 w-64 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-xl dark:border-slate-700 dark:bg-slate-800">

                    <!-- Account Header -->
                    <div class="flex items-center gap-3 border-b border-slate-200 px-4 py-3 dark:border-slate-700">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-primary/10 font-sans text-primary dark:bg-primary/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-sans text-slate-800 dark:text-slate-100">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <button
                            type="button"
                            @click="open = false"
                            class="flex h-7 w-7 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-700 dark:hover:text-slate-200"
                            aria-label="{{ __('Close') }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-2 text-sm">

                        <!-- Profile Modal Trigger -->
                        <button
                            type="button"
                            @click="open = false; $dispatch('open-modal', 'navigation-profile')"
                            class="flex w-full items-center font-sans gap-3 rounded-lg px-3 py-2.5 text-left text-slate-700 transition hover:bg-primary/10 hover:text-primary dark:text-slate-200 dark:hover:bg-slate-700/50">
                            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span>{{ __('Profile') }}</span>
                        </button>

                        <!-- Settings Modal Trigger -->
                        <button
                            type="button"
                            @click="open = false; $dispatch('open-modal', 'navigation-settings')"
                            class="flex w-full items-center font-sans gap-3 rounded-lg px-3 py-2.5 text-left text-slate-700 transition hover:bg-primary/10 hover:text-primary dark:text-slate-200 dark:hover:bg-slate-700/50">
                            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <circle cx="19" cy="11" r="2"/>
                                <path d="M19 8.5v-1m0 8v-1m-2.5-3.5h-1m6 0h-1"/>
                            </svg>
                            <span>{{ __('Settings') }}</span>
                        </button>

                        <!-- Password Modal Trigger -->
                        <button
                            type="button"
                            @click="open = false; $dispatch('open-modal', 'navigation-password')"
                            class="flex w-full items-center font-sans gap-3 rounded-lg px-3 py-2.5 text-left text-slate-700 transition hover:bg-primary/10 hover:text-primary dark:text-slate-200 dark:hover:bg-slate-700/50">
                            <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>{{ __('Change Password') }}</span>
                        </button>

                        <div class="my-2 border-t border-slate-200 dark:border-slate-700"></div>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left font-sans text-red-600 transition hover:bg-red-50 dark:hover:bg-red-950/30">
                                <svg class="h-[18px] w-[18px] shrink-0" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                <span>{{ __('Sign out') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Profile modal -->
<x-modal name="navigation-profile" maxWidth="2xl" focusable>
    <div class="relative max-h-[90vh] overflow-y-auto p-1 dark:bg-slate-900 dark:text-slate-100">
        <button
            type="button"
            @click="$dispatch('close-modal', 'navigation-profile')"
            class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition hover:bg-red-50 hover:text-red-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-red-950 dark:hover:text-red-400"
            aria-label="{{ __('Close') }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
            </svg>
        </button>
        @include('profile.partials.show')
    </div>
</x-modal>

<!-- Settings modal -->
<x-modal name="navigation-settings" maxWidth="2xl" :show="session('profile_settings_open', false) || $errors->hasAny(['name', 'email', 'phone', 'address', 'image'])" focusable>
    <div class="relative max-h-[90vh] overflow-y-auto p-1 dark:bg-slate-900 dark:text-slate-100">
        <button
            type="button"
            @click="$dispatch('close-modal', 'navigation-settings')"
            class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition hover:bg-red-50 hover:text-red-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-red-950 dark:hover:text-red-400"
            aria-label="{{ __('Close') }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
            </svg>
        </button>
        @include('profile.partials.update-profile-information-form')
    </div>
</x-modal>

<!-- Password modal -->
<x-modal name="navigation-password" maxWidth="xl" focusable>
    <div class="relative max-h-[90vh] overflow-y-auto p-1 dark:bg-slate-900 dark:text-slate-100">
        <button
            type="button"
            @click="$dispatch('close-modal', 'navigation-password')"
            class="absolute right-4 top-4 z-10 flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition hover:bg-red-50 hover:text-red-600 dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-red-950 dark:hover:text-red-400"
            aria-label="{{ __('Close') }}">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" d="M6 6l12 12M18 6 6 18" />
            </svg>
        </button>
        @include('profile.partials.update-password-form')
    </div>
</x-modal>