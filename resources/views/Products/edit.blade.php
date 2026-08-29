<x-modal name="edit-product" :show="$errors->editProduct->any()" focusable>
    <form 
        x-data="{ 
            // 1. Check Laravel Locale (true for Khmer, false for English)
            isKhmer: {{ in_array(app()->getLocale(), ['km', 'kh']) ? 'true' : 'false' }},

            id: '', 
            name: '', 
            SKU: '',
            category_id: '', 
            supplier_id: '', 
            Cost: '', 
            Price: '', 
            description: '', 
            Note: '',
            status: 'active', 
            imageUrl: null, 
            isSubmitting: false,

            // 2. Convert Khmer digits to English digits
            toEngDigits(val) {
                if (val === null || val === undefined) return '';
                const khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                let str = val.toString();
                for (let i = 0; i < 10; i++) {
                    str = str.replace(new RegExp(khmerDigits[i], 'g'), i.toString());
                }
                return str;
            },

            // 3. Convert English digits to Khmer digits
            toKhmerDigits(val) {
                if (val === null || val === undefined) return '';
                const khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                return val.toString().replace(/[0-9]/g, d => khmerDigits[d]);
            },

            // 4. Format SKU according to locale
            formatSKU(val) {
                if (!val) return '';
                let engVal = this.toEngDigits(val);
                return this.isKhmer ? this.toKhmerDigits(engVal) : engVal;
            },

            // 5. Format money according to locale
            formatMoney(val, withSymbol = false) {
                if (val === '' || val === null || val === undefined) return '';
                let engVal = this.toEngDigits(val);
                let cleanVal = engVal.replace(/[^0-9.]/g, ''); 
                if (!cleanVal) return '';
                
                let num = parseFloat(cleanVal);
                if (isNaN(num)) return '';
                
                if (this.isKhmer) {
                    let khrNum = Math.round(num * 4035);
                    let formattedInt = khrNum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                    let khmerNum = this.toKhmerDigits(formattedInt);
                    return withSymbol ? `${khmerNum} ៛` : khmerNum;
                } 
                
                let formattedEng = num.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                return withSymbol ? `$${formattedEng}` : formattedEng;
            },

            // 6. Convert to raw USD number for submission
            toRawNumber(val) {
                if (val === '' || val === null || val === undefined) return '';
                let engVal = this.toEngDigits(val);
                let cleanVal = engVal.replace(/[^0-9.]/g, '');
                if (!cleanVal) return '';
                let num = parseFloat(cleanVal);
                return isNaN(num) ? '' : num.toFixed(2);
            },

            // 7. Handle number inputs dynamically
            handleInput(field, value) {
                let engVal = this.toEngDigits(value);
                let cleanVal = engVal.replace(/[^0-9.]/g, '');
                if (!cleanVal) {
                    this[field] = '';
                    return;
                }
                if (this.isKhmer) {
                    let rielVal = parseFloat(cleanVal);
                    this[field] = isNaN(rielVal) ? '' : (rielVal / 4035).toString();
                } else {
                    this[field] = cleanVal;
                }
            }
        }"
        @edit-product-data.window="
            id = $event.detail.id || '';
            name = $event.detail.name || '';
            SKU = ($event.detail.SKU !== 'null' && $event.detail.SKU) ? toEngDigits($event.detail.SKU) : '';
            category_id = $event.detail.category_id || '';
            supplier_id = $event.detail.supplier_id || '';
            
            Cost = ($event.detail.Cost !== 'null' && $event.detail.Cost) ? toEngDigits($event.detail.Cost) : '';
            Price = ($event.detail.Price !== 'null' && $event.detail.Price) ? toEngDigits($event.detail.Price) : '';

            description = ($event.detail.description && $event.detail.description !== 'null') ? $event.detail.description : '';
            Note = ($event.detail.Note && $event.detail.Note !== 'null') ? $event.detail.Note : '';
            status = $event.detail.status || 'active';
            
            let rawImg = $event.detail.image || $event.detail.imageUrl || $event.detail.image_url || $event.detail.photo;
            if (rawImg && rawImg !== 'null' && rawImg !== '' && rawImg !== 'undefined') {
                if (!rawImg.startsWith('http://') && !rawImg.startsWith('https://') && !rawImg.startsWith('blob:')) {
                    imageUrl = '{{ asset('storage') }}/' + rawImg;
                } else {
                    imageUrl = rawImg;
                }
            } else {
                imageUrl = null;
            }
        "
        :action="'{{ url('products') }}/' + id" 
        method="POST" 
        enctype="multipart/form-data" 
        class="relative p-6 md:p-8 font-sans bg-neutral-primary-soft rounded-2xl" 
        @submit="
            document.getElementById('edit_SKU').value = toEngDigits(SKU);
            document.getElementById('edit_Cost').value = toRawNumber(Cost);
            document.getElementById('edit_Price').value = toRawNumber(Price);
            isSubmitting = true;
        ">
        @csrf
        @method('PUT')

        <!-- Loading Overlay -->
        <div x-show="isSubmitting" x-cloak class="absolute inset-0 bg-neutral-primary-soft/90 backdrop-blur-xs z-50 flex flex-col items-center justify-center gap-3 rounded-2xl transition-all">
            <svg class="w-10 h-10 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-semibold text-heading">{{ __('Updating product, please wait...') }}</span>
        </div>

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-default">
            <div>
                <h2 class="text-xl font-bold text-heading tracking-tight">
                    {{ __('Edit Product') }}
                </h2>
                <p class="text-sm text-body mt-0.5">{{ __('Update the product information below.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close-modal', 'edit-product')" 
                class="w-8 h-8 rounded-full bg-neutral-secondary-medium hover:bg-neutral-tertiary flex items-center justify-center text-body hover:text-heading transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-5 max-h-[65vh] overflow-y-auto pr-1">
            <!-- Name -->
            <div>
                <label for="edit_name" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="edit_name" x-model="name" placeholder="{{ __('Enter product name') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
            </div>

            <!-- SKU -->
            <div>
                <label for="edit_SKU" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('SKU') }}</label>
                <input type="hidden" name="SKU" id="edit_SKU">
                <input type="text" :value="formatSKU(SKU)" @input="SKU = toEngDigits($event.target.value)" placeholder="{{ __('e.g. PRD-001') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs">
            </div>

            <!-- Category & Supplier Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label for="edit_category_id" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Category') }} <span class="text-red-500">*</span></label>
                    <select name="category_id" id="edit_category_id" x-model="category_id"
                        class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label for="edit_supplier_id" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Supplier') }} <span class="text-red-500">*</span></label>
                    <select name="supplier_id" id="edit_supplier_id" x-model="supplier_id"
                        class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer" required>
                        <option value="">{{ __('Select Supplier') }}</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id ?? $supplier->name }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Cost & Price Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Cost -->
                <div>
                    <label for="edit_Cost" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Cost Price') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span x-text="isKhmer ? '៛' : '$'" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-body font-medium text-sm"></span>
                        <input type="hidden" name="Cost" id="edit_Cost">
                        <input type="text" :value="formatMoney(Cost, false)" @input="handleInput('Cost', $event.target.value)" :placeholder="isKhmer ? '០' : '0'" 
                            class="w-full pl-4 pr-10 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label for="edit_Price" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Selling Price') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span x-text="isKhmer ? '៛' : '$'" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-body font-medium text-sm"></span>
                        <input type="hidden" name="Price" id="edit_Price">
                        <input type="text" :value="formatMoney(Price, false)" @input="handleInput('Price', $event.target.value)" :placeholder="isKhmer ? '០' : '0'" 
                            class="w-full pl-4 pr-10 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="edit_description" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Description') }}</label>
                <textarea name="description" id="edit_description" x-model="description" rows="2" placeholder="{{ __('Optional details about the product...') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs"></textarea>
            </div>

            <!-- Note -->
            <div>
                <label for="edit_Note" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Note') }}</label>
                <textarea name="Note" id="edit_Note" x-model="Note" rows="2" placeholder="{{ __('Internal notes...') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs"></textarea>
            </div>

            <!-- Status -->
            <div>
                <label for="edit_status" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Status') }}</label>
                <select name="status" id="edit_status" x-model="status"
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer">
                    <option value="active">{{ __('Active') }}</option>
                    <option value="inactive">{{ __('Inactive') }}</option>
                </select>
            </div>

            <!-- Image with Preview -->
            <div>
                <label for="edit_image" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Product Image') }}</label>
                <div class="flex items-center gap-4 p-3 bg-neutral-secondary-medium/50 border border-default rounded-lg shadow-xs">
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="w-14 h-14 object-cover rounded-lg border border-default shadow-xs" alt="Preview">
                    </template>
                    <template x-if="!imageUrl">
                        <div class="w-14 h-14 bg-neutral-secondary-medium rounded-lg flex items-center justify-center text-body text-[10px] font-bold uppercase tracking-wider border border-default">
                            {{ __('No Image') }}
                        </div>
                    </template>

                    <input type="file" name="image" id="edit_image" accept="image/jpeg,image/png,image/gif,image/webp"
                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file); }"
                        class="block w-full text-xs text-body file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-default">
            <button type="button" @click="$dispatch('close-modal', 'edit-product')" :disabled="isSubmitting"
                class="px-5 py-2.5 text-xs font-semibold text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors cursor-pointer shadow-xs disabled:opacity-50">
                <span>{{ __('Cancel') }}</span>
            </button>
            <button type="submit" :disabled="isSubmitting"
                class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer shadow-xs disabled:opacity-70 disabled:cursor-not-allowed">
                <span>{{ __('Update Product') }}</span>
            </button>
        </div>
    </form>
</x-modal>