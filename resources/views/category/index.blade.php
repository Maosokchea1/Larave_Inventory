<x-app-layout>
    @php
        // មុខងារបំប្លែងលេខអង់គ្លេសទៅជាលេខខ្មែរ ប្រសិនបើ Locale ជាភាសាខ្មែរ
        $toKhmerNum = function($num) {
            if (!in_array(app()->getLocale(), ['km', 'kh'])) {
                return $num;
            }
            $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
            return str_replace(range(0, 9), $khmerDigits, (string)$num);
        };
    @endphp

    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 font-sans">
        <div>
            <h1 class="text-xl font-semibold text-colorblue-500 font-khmersmart">{{ __('Categories Management') }}</h1>
            <p class="text-sm text-body mt-0.5">{{ __('Manage your product categories efficiently.') }}</p>
        </div>

        <!-- Action Button -->
        <div x-data="">
            <button 
                type="button" 
                @click="$dispatch('open-modal', 'add-category')"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-all shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                {{ __('Add Category') }}
            </button>
        </div>
    </div>

    <!-- Search Toolbar Card -->
    <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs font-sans">
        <form action="{{ route('categories.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
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
                    class="w-full pl-10 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all"
                    placeholder="{{ __('Search category name...') }}" />
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none px-4 py-2.5 text-sm font-medium text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                    {{ __('Search') }}
                </button>
                @if(request('search'))
                    <a href="{{ route('categories.index') }}" class="px-4 py-2.5 text-sm font-medium text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center">
                        {{ __('Reset') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Error Flash Message -->
    @if (session('error'))
        <div class="mb-6 p-4 text-sm text-rose-800 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-xs transition-all font-sans">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-rose-600 hover:text-rose-900 font-bold text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- Success Flash Message (កែសម្រួលប្រើ font-sans) -->
    @if (session('success'))
        <div class="mb-6 p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200 flex items-center justify-between shadow-xs transition-all font-sans">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium font-sans">{{ session('success') }}</span>
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
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Category Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Note') }}</th>
                        <th scope="col" class="px-6 py-3.5 text-right font-extrabold">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    @forelse ($categories as $category)
                    <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                        <!-- ID Display with Khmer Digits Support -->
                        <td class="px-6 py-4 font-medium {{ in_array(app()->getLocale(), ['km', 'kh']) ? 'font-khmer' : 'font-sans' }} text-heading whitespace-nowrap">
                            {{ $toKhmerNum($category->id) }}
                        </td>
                        <td class="px-6 py-4 font-medium font-sans text-heading">
                            {{ $category->name }}
                        </td>
                        <td class="px-6 py-4 text-body font-sans max-w-xs truncate">
                            {{ $category->Note ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap" x-data="">
                            <div class="inline-flex items-center gap-2 font-sans">
                                <!-- Edit Button (Trigger Modal) -->
                                <button 
                                    type="button" 
                                    @click="$dispatch('open-modal', 'edit-category'); $dispatch('edit-category-data', { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', note: '{{ addslashes($category->Note) }}' })"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Zm0 0L19.5 7.125"></path>
                                    </svg>
                                    {{ __('Edit') }}
                                </button>

                                <!-- Delete Form & Button -->
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                        </svg>
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center font-sans">
                            <div class="flex flex-col items-center justify-center text-gray-400 gap-2">
                                <svg class="w-10 h-10 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
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
        @if ($categories->hasPages())
            <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-sans">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Components -->
    @include('category.add')
    @include('category.edit')

</x-app-layout>