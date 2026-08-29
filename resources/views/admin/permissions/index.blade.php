<x-app-layout>
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-semibold text-heading font-english">{{ __('Permissions Management') }}</h1>
            <p class="text-sm text-body mt-0.5">{{ __('List of all permissions in the system.') }}</p>
        </div>
        <button type="button" x-data="" @click="$dispatch('open-modal', 'add-permission')" class="px-4 py-2.5 text-sm font-medium font-english text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer shadow-xs">
            {{ __('Add New Permission') }}
        </button>
    </div>

    <!-- Search Toolbar Card -->
    <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs">
        <form action="{{ route('admin.permissions.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
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
                    placeholder="{{ __('Search permission name or group...') }}" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none px-4 py-2.5 text-sm font-medium font-english text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                    {{ __('Search') }}
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2.5 text-sm font-medium font-english text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center">
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
                <span class="font-medium font-english">{{ session('success') }}</span>
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
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Permission Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Group Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Created Date') }}</th>
                        <th scope="col" class="px-6 py-3.5 text-right font-extrabold">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    @forelse($permissions as $key => $permission)
                    <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                        <td class="px-6 py-4 font-medium font-english text-heading whitespace-nowrap">
                            {{ method_exists($permissions, 'firstItem') ? $permissions->firstItem() + $key : $key + 1 }}
                        </td>
                        <td class="px-6 py-4 font-medium text-heading font-english">
                            {{ $permission->name }}
                        </td>
                        <td class="px-6 py-4 text-body font-english">
                            <span class="px-2.5 py-1 text-xs font-semibold bg-neutral-secondary-medium rounded-full text-heading border border-default-medium">
                                {{ $permission->group_name ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-body font-english whitespace-nowrap">
                            {{ $permission->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button type="button" 
                                    x-data="" 
                                    @click="$dispatch('open-modal', { name: 'edit-permission', permission: { id: {{ $permission->id }}, name: '{{ addslashes($permission->name) }}', group_name: '{{ addslashes($permission->group_name ?? '') }}' } })" 
                                    class="font-medium font-english text-blue-600 dark:text-blue-500 hover:underline cursor-pointer">
                                {{ __('Edit') }}
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 gap-2">
                                <svg class="w-10 h-10 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
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
        @if (method_exists($permissions, 'hasPages') && $permissions->hasPages())
            <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-english">
                {{ $permissions->links() }}
            </div>
        @endif
    </div>

    @include('admin.permissions.add')
    @include('admin.permissions.edit')
</x-app-layout>