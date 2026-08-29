<!-- Header Section – Clean & Minimal -->
<div class="flex items-center justify-between pb-3 mb-5 border-b border-gray-200 max-w-xl mx-auto">
    <div>
        <h1 class="text-xl font-semibold text-gray-800 font-sans">
            {{ __('Create Stock Transfer') }}
        </h1>
        <p class="text-sm text-gray-500 mt-0.5 font-sans">
            {{ __('Transfer inventory items to another location or status.') }}
        </p>
    </div>
</div>

<!-- Form Card – Flat, Light Border, No Shadow, Narrower -->
<div class="bg-white border border-gray-200 rounded-lg p-6 md:p-8 max-w-xl mx-auto font-sans">
    <form action="{{ route('stock.transfer.store') }}" method="POST" class="space-y-5"
        x-data="{ loading: false }" @submit.prevent="loading = true; $el.submit()">
        @csrf

        <!-- Validation Errors – Clean & Subtle -->
        @if ($errors->any())
            <div class="p-4 bg-red-50/80 border border-red-200 rounded-lg text-sm text-red-700 font-sans">
                <div class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="list-disc list-inside space-y-0.5 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Product Selection -->
        <div>
            <label for="product_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Select Product') }} <span class="text-red-500">*</span>
            </label>
            <select name="product_id" id="product_id" required autofocus
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans">
                <option value="">-- {{ __('Choose Product') }} --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }} ({{ __('Stock') }}: {{ $product->stock ?? 0 }})
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <p class="text-xs text-red-600 mt-1 font-sans">{{ $message }}</p>
            @enderror
        </div>

        <!-- Quantity -->
        <div>
            <label for="quantity" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Quantity') }} <span class="text-red-500">*</span>
            </label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" required
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans"
                placeholder="0">
            @error('quantity')
                <p class="text-xs text-red-600 mt-1 font-sans">{{ $message }}</p>
            @enderror
        </div>

        <!-- Reference (Optional) -->
        <div>
            <label for="reference" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Reference / Note') }}
            </label>
            <input type="text" name="reference" id="reference" value="{{ old('reference') }}"
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans"
                placeholder="{{ __('Optional reference info') }}">
            @error('reference')
                <p class="text-xs text-red-600 mt-1 font-sans">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons Footer – Flat, Clean -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-200">
            <a href="{{ route('stock.transfer.index') }}"
                class="px-5 py-2.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-sans">
                {{ __('Cancel') }}
            </a>

            <button type="submit"
                class="px-6 py-2.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition focus:ring-2 focus:ring-blue-500/30 disabled:opacity-70 disabled:cursor-not-allowed inline-flex items-center justify-center min-w-[120px] font-sans"
                :disabled="loading">
                <span x-show="!loading">{{ __('Save Transfer') }}</span>
                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Saving...') }}
                </span>
            </button>
        </div>
    </form>
</div>