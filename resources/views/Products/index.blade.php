@php
    function formatNumber($number) {
        $isKhmer = in_array(app()->getLocale(), ['km', 'kh']);
        
        if (!$isKhmer) {
            return $number;
        }

        $arabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $khmer  = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        return str_replace($arabic, $khmer, $number);
    }

    function formatPrice($amount) {
        $isKhmer = in_array(app()->getLocale(), ['km', 'kh']);
        
        if ($isKhmer) {
            $khrAmount = $amount * 4035;
            return formatNumber(number_format($khrAmount, 0)) . ' ៛';
        }

        return '$' . number_format($amount, 2);
    }
@endphp

<x-app-layout>
    <!-- Header Section -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-xl font-semibold text-colorblue-500 font-khmersmart">{{ __('Products Management') }}</h1>
            <p class="text-sm text-body mt-0.5 font-sans">{{ __('Manage your product inventory efficiently.') }}</p>
        </div>

        <!-- Action Button (Trigger Add Modal) -->
        <div x-data="">
            <button 
                type="button" 
                @click="$dispatch('open-modal', 'add-product')"
                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium font-khmerssans text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-all shadow-xs cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"></path>
                </svg>
                <span class="font-sans">{{ __('Add Product') }}</span>
            </button>
        </div>
    </div>

    <!-- Search & Filter Toolbar Card -->
    <div class="mb-6 p-4 bg-neutral-primary-soft border border-default rounded-xl shadow-xs">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <!-- Search Input -->
            <div class="relative w-full sm:max-w-xs flex-1">
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
                    class="w-full pl-10 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-sans focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all"
                    placeholder="{{ __('Search product name...') }}" />
            </div>

            <!-- Select Category Dropdown -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-body" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                    </svg>
                </div>
                <select 
                    name="category_id" 
                    onchange="this.form.submit()" 
                    class="w-full sm:w-auto appearance-none pl-10 pr-9 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-sans focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer hover:bg-neutral-tertiary transition-colors">
                    <option value="" class="font-sans">{{ __('All Categories') }}</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }} class="font-sans">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                    <svg class="w-4 h-4 text-body" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>

            <!-- Select Supplier Dropdown -->
            <div class="relative w-full sm:w-auto">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                    <svg class="w-4 h-4 text-body" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72L4.318 3.44A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72" />
                    </svg>
                </div>
                <select 
                    name="supplier_id" 
                    onchange="this.form.submit()" 
                    class="w-full sm:w-auto appearance-none pl-10 pr-9 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-sans focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer hover:bg-neutral-tertiary transition-colors">
                    <option value="" class="font-sans">{{ __('All Suppliers') }}</option>
                    @foreach($suppliers ?? [] as $supplier)
                        <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }} class="font-sans">
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                    <svg class="w-4 h-4 text-body" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </div>
            </div>

            <!-- Search & Reset Buttons -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button
                    type="submit"
                    class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium font-sans text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="font-sans">{{ __('Search') }}</span>
                </button>
                @if(request('search') || request('category_id') || request('supplier_id'))
                    <a href="{{ route('products.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium font-sans text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors text-center shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span class="font-sans">{{ __('Reset') }}</span>
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

    <!-- Error Flash Message -->
    @if (session('error'))
        <div class="mb-6 p-4 text-sm text-red-800 rounded-xl bg-red-50 border border-red-200 flex items-center justify-between shadow-xs transition-all">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-medium font-sans">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-red-600 hover:text-red-900 font-bold text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- Data Table Card -->
    <div class="bg-neutral-primary-soft shadow-xs rounded-xl border border-default overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-body">
                <thead class="text-xs uppercase bg-primary text-white tracking-wider font-sans shadow-sm">
                    <tr>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('ID') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Image') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Product Name') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('SKU') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Category') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Supplier') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Cost') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Price') }}</th>
                        <th scope="col" class="px-6 py-3.5 font-extrabold font-sans">{{ __('Stock Status') }}</th>
                        <th scope="col" class="px-6 py-3.5 text-right font-extrabold font-sans">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-default">
                    @forelse ($products as $product)
                    <tr class="hover:bg-neutral-secondary-medium/50 transition-colors">
                        <!-- ID -->
                        <td class="px-6 py-4 font-medium font-sans text-heading">
                            {{ formatNumber($product->id) }}
                        </td>

                        <!-- Image -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-10 h-10 object-cover rounded-lg border border-default shadow-xs">
                            @else
                                <div class="w-10 h-10 bg-neutral-secondary-medium rounded-lg flex items-center justify-center text-body text-xs border border-default font-sans">
                                    N/A
                                </div>
                            @endif
                        </td>

                        <!-- Product Name -->
                        <td class="px-6 py-4 font-medium font-sans text-heading">
                            {{ $product->name }}
                        </td>

                        <!-- SKU -->
                        <td class="px-6 py-4 font-sans text-body">
                            {{ $product->SKU ? formatNumber($product->SKU) : 'N/A' }}
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4 font-sans text-body">
                            <span class="px-2.5 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full font-sans">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                        </td>

                        <!-- Supplier -->
                        <td class="px-6 py-4 font-sans text-body">
                            <span class="px-2.5 py-1 text-xs font-medium bg-purple-50 text-purple-700 rounded-full font-sans">
                                {{ $product->supplier->name ?? 'N/A' }}
                            </span>
                        </td>

                        <!-- Cost -->
                        <td class="px-6 py-4 font-sans text-body whitespace-nowrap">
                            {{ formatPrice($product->Cost) }}
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4 font-medium font-sans text-heading whitespace-nowrap">
                            {{ formatPrice($product->Price) }}
                        </td>

                        <!-- Stock Status (ភាគរយសល់ស្តុក) -->
                        <td class="px-6 py-4 whitespace-nowrap font-sans">
                            @php
                                // ទាញយកចំនួនស្តុក (គាំទ្រទាំងអក្សរធំ និងតូច តាម Database Schema)
                                $currentQty = $product->qty 
                                    ?? $product->Qty 
                                    ?? $product->quantity 
                                    ?? $product->Quantity 
                                    ?? $product->stock 
                                    ?? $product->Stock 
                                    ?? 0;

                                // ទាញយកចំនួនស្តុកអតិបរមា (Max Stock)
                                $maxQty = $product->max_qty 
                                    ?? $product->MaxQty 
                                    ?? $product->max_stock 
                                    ?? $product->MaxStock 
                                    ?? 100;
                                
                                // គណនាភាគរយស្តុក
                                $percent = (!is_null($product->stock_percentage) && $product->stock_percentage !== '') 
                                    ? (float) $product->stock_percentage 
                                    : ($maxQty > 0 ? min(100, max(0, round(($currentQty / $maxQty) * 100))) : 0);
                            @endphp

                            <div class="flex items-center gap-3">
                                <!-- Minimal Progress Bar -->
                                <div class="w-16 bg-neutral-secondary-medium rounded-full h-2 overflow-hidden border border-default-medium">
                                    <div class="h-2 rounded-full transition-all duration-300 {{ $percent > 50 ? 'bg-emerald-500' : ($percent > 20 ? 'bg-amber-500' : 'bg-rose-500') }}" 
                                         style="width: {{ $percent }}%"></div>
                                </div>
                                
                                <!-- Percentage Badge -->
                                @if($percent > 50)
                                    <span class="px-2.5 py-0.5 text-xs font-semibold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">
                                        {{ formatNumber($percent) }}%
                                    </span>
                                @elseif($percent > 20)
                                    <span class="px-2.5 py-0.5 text-xs font-semibold bg-amber-50 text-amber-700 rounded-full border border-amber-200">
                                        {{ formatNumber($percent) }}%
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-semibold bg-rose-50 text-rose-700 rounded-full border border-rose-200">
                                        {{ formatNumber($percent) }}%
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right whitespace-nowrap" x-data="">
                            <div class="inline-flex items-center gap-2">
                                <!-- Edit Button -->
                                <button 
                                    type="button" 
                                    @click="$dispatch('open-modal', 'edit-product'); $dispatch('edit-product-data', @js([
                                        'id' => $product->id,
                                        'name' => $product->name,
                                        'SKU' => $product->SKU,
                                        'category_id' => $product->category_id,
                                        'supplier_id' => $product->supplier_id,
                                        'Cost' => $product->Cost,
                                        'Price' => $product->Price,
                                        'description' => $product->description,
                                        'Note' => $product->Note,
                                        'status' => $product->status,
                                        'image' => $product->image
                                    ]))"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-sans text-primary bg-primary/10 hover:bg-primary/20 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Zm0 0L19.5 7.125"></path>
                                    </svg>
                                    <span class="font-sans">{{ __('Edit') }}</span>
                                </button>

                                <!-- Delete Form & Button -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this product?') }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium font-sans text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"></path>
                                        </svg>
                                        <span class="font-sans">{{ __('Delete') }}</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400 gap-2 font-sans">
                                <svg class="w-10 h-10 text-body/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <p class="text-sm font-medium text-body font-sans">{{ __('No record found') }}</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if (isset($products) && method_exists($products, 'hasPages') && $products->hasPages())
            <div class="px-6 py-3.5 border-t border-default bg-neutral-primary-soft font-sans">
                @php
                    $isKhmer = in_array(app()->getLocale(), ['km', 'kh']);
                @endphp
                @if($isKhmer)
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-body">
                        <div>
                            {!! __('Showing') !!} 
                            <span class="font-medium">{{ formatNumber($products->firstItem()) }}</span> 
                            {!! __('to') !!} 
                            <span class="font-medium">{{ formatNumber($products->lastItem()) }}</span> 
                            {!! __('of') !!} 
                            <span class="font-medium">{{ formatNumber($products->total()) }}</span> 
                            {!! __('results') !!}
                        </div>
                        <div class="inline-flex items-center gap-1">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <span class="px-3 py-1.5 bg-neutral-secondary-medium text-body/40 rounded-lg cursor-not-allowed">&lsaquo;</span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="px-3 py-1.5 bg-neutral-secondary-medium hover:bg-neutral-tertiary text-heading rounded-lg">&lsaquo;</a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span class="px-3 py-1.5 bg-primary text-white rounded-lg font-medium">{{ formatNumber($page) }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1.5 bg-neutral-secondary-medium hover:bg-neutral-tertiary text-heading rounded-lg">{{ formatNumber($page) }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="px-3 py-1.5 bg-neutral-secondary-medium hover:bg-neutral-tertiary text-heading rounded-lg">&rsaquo;</a>
                            @else
                                <span class="px-3 py-1.5 bg-neutral-secondary-medium text-body/40 rounded-lg cursor-not-allowed">&rsaquo;</span>
                            @endif
                        </div>
                    </div>
                @else
                    {{ $products->links() }}
                @endif
            </div>
        @endif
    </div>

    <!-- Modal Components -->
    @include('products.add')
    @include('products.edit')
</x-app-layout>