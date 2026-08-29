<x-app-layout>
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-semibold text-heading font-english">{{ __('Roles Management') }}</h1>
            <p class="text-sm text-body mt-0.5">{{ __('List of all roles in the system.') }}</p>
        </div>
        <button type="button" x-data="" @click="$dispatch('open-modal', 'add-role')" class="px-4 py-2.5 text-sm font-medium font-english text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer shadow-xs">
            {{ __('Add New Role') }}
        </button>
    </div>

    <!-- Search Toolbar Card -->
    <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs">
        <form action="{{ route('admin.roles.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
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
                    class="w-full pl-10 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-english focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all"
                    placeholder="{{ __('Search role or user...') }}" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none px-4 py-2.5 text-sm font-medium font-english text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                    {{ __('Search') }}
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.roles.index') }}" class="px-4 py-2.5 text-sm font-medium font-english text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center">
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Success Flash Message -->
    @if (session('success'))
        <div class="mb-6 p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between shadow-xs transition-all">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-green-600 hover:text-green-900 font-bold text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-neutral-primary-soft shadow-xs rounded-xl border border-default overflow-hidden font-khmer">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-body">
                <thead class="text-xs uppercase bg-primary text-white tracking-wider font-english shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('ID') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Role Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Assigned User') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Created Date') }}</th>
                        <th scope="col" class="px-6 py-3.5 text-right font-extrabold">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    @forelse($roles as $key => $role)
                    <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                        <td class="px-6 py-4 font-medium font-english text-heading whitespace-nowrap">
                            {{ method_exists($roles, 'firstItem') ? $roles->firstItem() + $key : $key + 1 }}
                        </td>
                        
                        <!-- Role Name Badge -->
                        <td class="px-6 py-4 font-medium text-heading">
                            @if(strtolower($role->name) === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold font-english text-purple-700 bg-purple-50 dark:bg-purple-950/55 dark:text-purple-300 border border-purple-200 dark:border-purple-800 rounded-full shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-600"></span>
                                    {{ $role->name }}
                                </span>
                            @elseif(strtolower($role->name) === 'user')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold font-english text-emerald-700 bg-emerald-50 dark:bg-emerald-950/55 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 rounded-full shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                                    {{ $role->name }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-semibold font-english text-gray-700 bg-gray-50 dark:bg-neutral-800 dark:text-gray-300 border border-gray-200 dark:border-neutral-700 rounded-full shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span>
                                    {{ $role->name }}
                                </span>
                            @endif
                        </td>

                        <!-- Assigned User Name & Email -->
                        <td class="px-6 py-4 font-medium text-heading font-english">
                            {{ $role->user->name ?? __('N/A') }} 
                            <span class="text-xs text-body block">({{ $role->user->email ?? '' }})</span>
                        </td>

                        <td class="px-6 py-4 text-body font-english whitespace-nowrap">
                            {{ $role->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                            <div class="inline-flex items-center justify-end gap-2">
                                <!-- Edit Button -->
                                <button type="button" 
                                        x-data="" 
                                        @click="$dispatch('open-modal', { name: 'edit-role', role: @js(['id' => $role->id, 'name' => $role->name, 'user_id' => $role->user_id]) })" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:text-blue-400 dark:hover:bg-blue-900/60 border border-blue-200/60 dark:border-blue-800/50 rounded-lg transition-all shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path>
                                    </svg>
                                    {{ __('Edit') }}
                                </button>

                                <!-- Delete Button -->
                                <button type="button" 
                                        x-data="" 
                                        @click="$dispatch('open-modal', { name: 'delete-role', roleId: {{ $role->id }}, roleName: @js($role->name) })" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:text-red-400 dark:hover:bg-red-900/60 border border-red-200/60 dark:border-red-800/50 rounded-lg transition-all shadow-2xs cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-10.151-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                    </svg>
                                    {{ __('Delete') }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 gap-2">
                                <svg class="w-10 h-10 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2,2 0 00-2-2H6a2,2 0 00-2 2v7m16 0v5a2,2 0 01-2 2H6a2,2 0 01-2-2v-5m16 0h-2.586a1,1 0 00-.707.293l-2.414 2.414a1,1 0 01-.707.293h-3.172a1,1 0 01-.707-.293l-2.414-2.414A1,1 0 006.586 13H4" />
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
        @if (method_exists($roles, 'hasPages') && $roles->hasPages())
            <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-english">
                {{ $roles->links() }}
            </div>
        @endif
    </div>

    <!-- Modals Include -->
    @include('admin.roles.add')
    @include('admin.roles.edit')
    @include('admin.roles.delete')
</x-app-layout>