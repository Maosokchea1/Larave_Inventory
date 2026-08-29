<!-- Edit Stock Transfer Modal – Professional Simple, Narrower -->
<form :action="editFormUrl" method="POST" class="font-khmer flex flex-col max-h-[85vh] max-w-xl mx-auto" x-data="{ loading: false }" @submit="loading = true">
    @csrf
    @method('PUT')

    <!-- Sticky Header – Clean & Minimal -->
    <div class="pb-3 mb-4 border-b border-gray-200 sticky top-0 bg-white z-10 px-1 pt-1">
        <h2 class="text-xl font-semibold text-gray-800 font-sans">
            {{ __('Edit Stock Transfer') }}
        </h2>
        <p class="text-sm text-gray-500 mt-0.5 font-sans">{{ __('Update the stock transfer information.') }}</p>
    </div>

    <!-- Scrollable Body – Flat Inputs, No Shadows -->
    <div class="space-y-5 overflow-y-auto px-1 flex-1">

        <!-- Product Selection -->
        <div>
            <label for="edit_product_id" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Select Product') }} <span class="text-red-500">*</span>
            </label>
            <select name="product_id" id="edit_product_id" x-model="editProduct" required
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans">
                <option value="">-- {{ __('Choose Product') }} --</option>
                @foreach($products ?? [] as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} ({{ __('Stock') }}: {{ $product->stock ?? 0 }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Quantity -->
        <div>
            <label for="edit_quantity" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Quantity') }} <span class="text-red-500">*</span>
            </label>
            <input type="number" name="quantity" id="edit_quantity" x-model="editQuantity" min="1" required
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans"
                placeholder="0">
        </div>

        <!-- Reference / Note -->
        <div>
            <label for="edit_reference" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5 font-sans">
                {{ __('Reference / Note') }}
            </label>
            <input type="text" name="reference" id="edit_reference" x-model="editReference"
                class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/40 focus:border-blue-400 transition font-sans"
                placeholder="{{ __('Optional reference info') }}">
        </div>

    </div>

    <!-- Sticky Footer – Flat Buttons, No Shadows -->
    <div class="flex items-center justify-end gap-3 pt-4 mt-5 border-t border-gray-200 sticky bottom-0 bg-white px-1 pb-1">
        <button type="button" @click="showModal = false"
            class="px-5 py-2.5 text-xs font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition font-sans">
            {{ __('Cancel') }}
        </button>
        <button type="submit" 
            class="px-6 py-2.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition focus:ring-2 focus:ring-blue-500/30 inline-flex items-center justify-center min-w-[120px] font-sans" 
            :disabled="loading">
            <span x-show="!loading">{{ __('Update Transfer') }}</span>
            <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                {{ __('Updating...') }}
            </span>
        </button>
    </div>
</form>