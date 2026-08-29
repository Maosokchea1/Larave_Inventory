<aside id="top-bar-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="relative h-full px-4 py-6 overflow-y-auto bg-white border-r border-gray-200 shadow-lg dark:bg-slate-900 dark:border-slate-700/60 dark:shadow-slate-800/20">
        
        <!-- Logo / Brand -->
        <a href="/" class="flex items-center justify-center gap-2 mb-8 ps-2">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-800 dark:text-white font-sans">Inventory</span>
        </a>

        <!-- Main Menu -->
        <ul class="space-y-1 font-medium">
            <!-- Section Title: Overview -->
            <li class="px-3 pt-2 pb-1 text-xs font-semibold tracking-wider uppercase text-gray-400 dark:text-slate-500 font-sans">
                {{ __('Overview') }}
            </li>

            <!-- Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg class="w-5 h-5 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z" />
                    </svg>
                    <span class="ms-3 text-sm font-sans">{{ __('Dashboard') }}</span>
                </a>
            </li>
        </ul>

        <!-- Inventory Section -->
        <ul class="pt-4 mt-4 space-y-1 border-t border-gray-100 dark:border-slate-700/40">
            <li class="px-3 pb-1 text-xs font-semibold tracking-wider uppercase text-gray-400 dark:text-slate-500 font-sans">
                {{ __('Inventory') }}
            </li>

            <!-- Products -->
            <li>
                <a href="{{ route('products.index') }}"
                    class="{{ request()->routeIs('products.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('products.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path>
                        <path d="M12 22V12"></path>
                        <polyline points="3.29 7 12 12 20.71 7"></polyline>
                        <path d="m7.5 4.27 9 5.15"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Products') }}</span>
                </a>
            </li>

            <!-- Categories -->
            <li>
                <a href="{{ route('categories.index') }}"
                    class="{{ request()->routeIs('categories.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('categories.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M20 10a1 1 0 0 0 1-1V6a1 1 0 0 0-1-1h-2.5a1 1 0 0 1-.8-.4l-.9-1.2A1 1 0 0 0 15 3h-2a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"></path>
                        <path d="M20 21a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-2.9a1 1 0 0 1-.88-.55l-.42-.85a1 1 0 0 0-.92-.6H13a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1Z"></path>
                        <path d="M3 5a2 2 0 0 0 2 2h3"></path>
                        <path d="M3 3v13a2 2 0 0 0 2 2h3"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Categories') }}</span>
                </a>
            </li>

            <!-- Suppliers -->
            <li>
                <a href="{{ route('suppliers.index') }}"
                    class="{{ request()->routeIs('suppliers.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('suppliers.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path>
                        <path d="M15 18H9"></path>
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path>
                        <circle cx="17" cy="18" r="2"></circle>
                        <circle cx="7" cy="18" r="2"></circle>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Suppliers') }}</span>
                </a>
            </li>

            <!-- Divider for Stock actions -->
            <li class="pt-3 mt-2 border-t border-gray-100 dark:border-slate-700/40"></li>

            <!-- Stock In -->
            <li>
                <a href="{{ route('stock.in') }}"
                    class="{{ request()->routeIs('stock.in*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('stock.in*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M12 17V3"></path>
                        <path d="m6 11 6 6 6-6"></path>
                        <path d="M19 21H5"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Stock In') }}</span>
                    <span class="px-2 py-0.5 text-xs font-medium text-green-600 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-400 font-sans">New</span>
                </a>
            </li>

            <!-- Stock Out -->
            <li>
                <a href="{{ route('stock.out') }}"
                    class="{{ request()->routeIs('stock.out*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('stock.out*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="m18 9-6-6-6 6"></path>
                        <path d="M12 3v14"></path>
                        <path d="M5 21h14"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Stock Out') }}</span>
                </a>
            </li>

            <!-- Stock Adjustments -->
            <li>
                <a href="{{ route('stock.adjustments') }}"
                    class="{{ request()->routeIs('stock.adjustments*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('stock.adjustments*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                        <path d="M21 3v5h-5"></path>
                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                        <path d="M8 16H3v5"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Stock Adjustments') }}</span>
                </a>
            </li>

            <!-- Transfer -->
  

            <!-- Stock Reports -->
            <li>
                <a href="{{ route('stock.reports') }}"
                    class="{{ request()->routeIs('stock.reports*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('stock.reports*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
                        <path d="M18 17V9"></path>
                        <path d="M13 17V5"></path>
                        <path d="M8 17v-3"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Stock Reports') }}</span>
                </a>
            </li>
        </ul>

        <!-- Administration Section -->
        <ul class="pt-4 mt-4 space-y-1 border-t border-gray-100 dark:border-slate-700/40">
            <li class="px-3 pb-1 text-xs font-semibold tracking-wider uppercase text-gray-400 dark:text-slate-500 font-sans">
                {{ __('Administration') }}
            </li>

            <!-- Users -->
          

            <!-- Connect Admin -->
            <li>
                <a href="{{ route('admin.connect-admin.index') }}"
                    class="{{ request()->routeIs('admin.connect-admin.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="w-5 h-5 transition-colors {{ request()->routeIs('admin.connect-admin.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                        <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Connect Admin') }}</span>
                </a>
            </li>

            <!-- Admin-only section -->
            @if(auth()->user() && auth()->user()->role === 'admin')



              <li>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                    <svg class="w-5 h-5 transition-colors {{ request()->routeIs('admin.users.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Users') }}</span>
                </a>
            </li>

                <!-- Roles -->
                <li>
                    <a href="{{ route('admin.roles.index') }}"
                        class="{{ request()->routeIs('admin.roles.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('admin.roles.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                            <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>
                        </svg>
                        <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Roles') }}</span>
                    </a>
                </li>

                <!-- Permissions -->
                <!-- <li>
                    <a href="{{ route('admin.permissions.index') }}"
                        class="{{ request()->routeIs('admin.permissions.*') || request()->routeIs('permissions.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('admin.permissions.*') || request()->routeIs('permissions.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Permissions') }}</span>
                    </a>
                </li> -->

                <!-- Products Settings -->
                <!-- <li>
                    <a href="{{ route('products-settings.index') }}"
                        class="{{ request()->routeIs('products-settings.*') ? 'text-primary bg-primary/5 border-l-4 border-primary dark:bg-primary/10 dark:border-primary' : 'text-gray-600 border-l-4 border-transparent hover:border-gray-300 dark:text-gray-300 dark:hover:border-slate-600 dark:hover:bg-slate-800/30' }} flex items-center p-2.5 pl-4 rounded-r-lg transition-all duration-200 group hover:translate-x-0.5 font-sans">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="w-5 h-5 transition-colors {{ request()->routeIs('products-settings.*') ? 'text-primary' : 'text-gray-400 group-hover:text-primary dark:text-gray-500 dark:group-hover:text-white' }}">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <span class="flex-1 ms-3 text-sm whitespace-nowrap font-sans">{{ __('Products Settings') }}</span>
                    </a>
                </li> -->

            @endif
        </ul>
    </div>
</aside>