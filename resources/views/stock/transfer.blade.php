<x-app-layout>
    @php
        // Helper សម្រាប់បំប្លែងលេខទៅជាលេខខ្មែរពេល Locale = 'km'
        $formatNum = function ($number) {
            if (app()->getLocale() !== 'km') {
                return $number;
            }
            $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            return str_replace($englishDigits, $khmerDigits, (string) $number);
        };

        // Helper សម្រាប់បំប្លែង កាលបរិច្ឆេទ និង ម៉ោង (ព្រឹក/ល្ងាច) ជាភាសាខ្មែរ
        $formatDate = function ($date) use ($formatNum) {
            if (!$date) return 'N/A';
            
            // Format 12 ម៉ោង (h:i A -> 12-hour with AM/PM)
            $formatted = $date->format('Y-m-d h:i A');

            if (app()->getLocale() === 'km') {
                $formatted = str_replace(['AM', 'PM'], ['ព្រឹក', 'ល្ងាច'], $formatted);
                return $formatNum($formatted);
            }

            return $formatted;
        };
    @endphp

    <!-- Alpine.js data for Modal management and Edit data binding -->
    <div x-data="{ showModal: false, modalMode: 'create', editFormUrl: '', editProduct: '', editQuantity: '', editReference: '' }">

        <!-- Header Section -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-xl font-semibold text-colorblue-500 font-khmersmart">{{ __('Stock Transfers Management') }}</h1>
                <p class="text-sm font-sans text-body mt-0.5">{{ __('Manage and track your inventory stock transfers efficiently.') }}</p>
            </div>

            <!-- Action Button -->
            <div>
                <button @click="showModal = true; modalMode = 'create'" 
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium font-sans text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-all shadow-xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                    </svg>
                    {{ __('New Transfer') }}
                </button>
            </div>
        </div>

        <!-- Search Toolbar Card -->
        <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs">
            <form action="{{ route('stock.transfer.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
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
                        placeholder="{{ __('Search reference or product...') }}" />
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button
                        type="submit"
                        class="flex-1 sm:flex-none px-4 py-2.5 text-sm font-medium font-sans text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                        {{ __('Search') }}
                    </button>
                    @if(request('search'))
                        <a href="{{ route('stock.transfer.index') }}" class="px-4 py-2.5 text-sm font-medium font-sans text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center">
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
                            <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Date') }}</th>
                            <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Product') }}</th>
                            <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Quantity') }}</th>
                            <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('User') }}</th>
                            <th scope="col" class="px-6 py-3.5 font-extrabold">{{ __('Reference') }}</th>
                            <th scope="col" class="px-6 py-3.5 text-right font-extrabold">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-default">
                        @forelse($transfers as $transfer)
                        <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                            <td class="px-6 py-4 font-medium font-sans text-heading whitespace-nowrap">{{ $formatDate($transfer->created_at) }}</td>
                            <td class="px-6 py-4 font-medium font-sans text-heading">{{ $transfer->product->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 font-medium font-sans text-heading">{{ $formatNum($transfer->quantity) }}</td>
                            <td class="px-6 py-4 text-body font-sans">{{ $transfer->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-body font-sans">{{ $transfer->reference ?: '-' }}</td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <!-- Edit Button with Icon -->
                                    <button @click="
                                            modalMode = 'edit';
                                            editFormUrl = '{{ route('stock.transfer.update', $transfer->id) }}';
                                            editProduct = {{ Js::from($transfer->product_id) }};
                                            editQuantity = {{ Js::from($transfer->quantity) }};
                                            editReference = {{ Js::from($transfer->reference) }};
                                            showModal = true;
                                        " 
                                        type="button"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-sans text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                        </svg>
                                        {{ __('Edit') }}
                                    </button>

                                    <!-- Delete Button with Icon -->
                                    <form action="{{ route('stock.transfer.destroy', $transfer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock transfer?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-sans text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors cursor-pointer">
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
                            <td colspan="6" class="py-12 text-center">
                                <p class="text-sm font-medium text-body">{{ __('No stock transfers found.') }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transfers->hasPages())
                <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-sans">
                    {{ $transfers->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Overlay -->
        <div x-show="showModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
             style="display: none;"
             x-transition>
            
            <div @click.away="showModal = false" 
                 class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
                
                <button @click="showModal = false" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl font-bold cursor-pointer">
                    &times;
                </button>

                <!-- Conditional Rendering based on Mode -->
                <div x-show="modalMode === 'create'">
                    @include('stock.create')
                </div>

                <div x-show="modalMode === 'edit'" style="display: none;">
                    @include('stock.edit')
                </div>
                
            </div>
        </div>

    </div>
</x-app-layout>