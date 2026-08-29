<x-modal name="add-product" :show="$errors->any()" focusable>
    @php
        $isKhmerModal = in_array(app()->getLocale(), ['km', 'kh']);
    @endphp

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" 
        class="relative p-6 md:p-8 font-sans bg-neutral-primary-soft rounded-2xl" 
        x-data="{ 
            SKU: '{{ old('SKU', '') }}',
            Cost: '{{ old('Cost', '0.00') }}', 
            Price: '{{ old('Price', '0.00') }}', 
            imageUrl: null, 
            isSubmitting: false,
            isKhmer: {{ $isKhmerModal ? 'true' : 'false' }},

            toKhmer(val) {
                if (!val) return '';
                return val.toString().replace(/[0-9.]/g, d => {
                    if (d === '.') return '.';
                    return '០១ដូ២៣៤៥៦៧៨៩'[d] ? '០១២៣៤៥៦៧៨៩'[d] : d;
                });
            },

            toEnglish(val) {
                if (!val) return '';
                const khmer = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                const arabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                let str = val.toString();
                khmer.forEach((char, index) => {
                    str = str.replace(new RegExp(char, 'g'), arabic[index]);
                });
                return str;
            },

            handleInput(field, value) {
                let cleanVal = this.toEnglish(value);
                cleanVal = cleanVal.replace(/[^0-9.]/g, '');
                const parts = cleanVal.split('.');
                if (parts.length > 2) {
                    cleanVal = parts[0] + '.' + parts.slice(1).join('');
                }
                this[field] = cleanVal;
            }
        }" 
        x-init="
            Cost = toEnglish(Cost);
            Price = toEnglish(Price);
        "
        @submit="
            Cost = toEnglish(Cost);
            Price = toEnglish(Price);
            isSubmitting = true;
        ">
        @csrf

        <!-- Loading Overlay -->
        <div x-show="isSubmitting" class="absolute inset-0 bg-neutral-primary-soft/90 backdrop-blur-xs z-50 flex flex-col items-center justify-center gap-3 rounded-2xl transition-all">
            <svg class="w-10 h-10 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-semibold text-heading">{{ __('Saving product, please wait...') }}</span>
        </div>

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-default">
            <div>
                <h2 class="text-xl font-bold text-heading tracking-tight">
                    {{ __('Add New Product') }}
                </h2>
                <p class="text-sm text-body mt-0.5">{{ __('Fill in the information below to add a new product to inventory.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close-modal', 'add-product')" 
                class="w-8 h-8 rounded-full bg-neutral-secondary-medium hover:bg-neutral-tertiary flex items-center justify-center text-body hover:text-heading transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Error Alert -->
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800 shadow-xs">
                <div class="flex items-center gap-2 font-semibold mb-1 uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ __('Please fix the following errors:') }}
                </div>
                <ul class="list-disc space-y-0.5 ps-5 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="space-y-5 max-h-[65vh] overflow-y-auto pr-1">
            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Name') }} <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('Enter product name') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
            </div>

            <!-- SKU -->
            <div>
                <label for="SKU" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('SKU') }}</label>
                <input type="text" name="SKU" id="SKU" x-model="SKU" placeholder="{{ __('e.g. PRD-001') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs">
            </div>

            <!-- Category & Supplier Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Category') }} <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" 
                        class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer" required>
                        <option value="">{{ __('Select Category') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier_id" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Supplier') }} <span class="text-red-500">*</span></label>
                    <select name="supplier_id" id="supplier_id" 
                        class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer" required>
                        <option value="">{{ __('Select Supplier') }}</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}" @selected(old('supplier_id') == $supplier->id)>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Cost & Price Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Cost -->
                <div>
                    <label for="Cost" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Cost Price') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <!-- Dynamic Currency Symbol ($ for English, ៛ for Khmer) -->
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-body font-medium text-sm" x-text="isKhmer ? '៛' : '$'"></span>
                        
                        <input type="hidden" name="Cost" :value="toEnglish(Cost)">
                        <input type="text" id="Cost" 
                            :value="isKhmer ? toKhmer(Cost) : Cost" 
                            @input="handleInput('Cost', $event.target.value)" 
                            placeholder="0.00" 
                            class="w-full pl-8 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
                    </div>
                </div>

                <!-- Price -->
                <div>
                    <label for="Price" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Selling Price') }} <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <!-- Dynamic Currency Symbol ($ for English, ៛ for Khmer) -->
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-body font-medium text-sm" x-text="isKhmer ? '៛' : '$'"></span>
                        
                        <input type="hidden" name="Price" :value="toEnglish(Price)">
                        <input type="text" id="Price" 
                            :value="isKhmer ? toKhmer(Price) : Price" 
                            @input="handleInput('Price', $event.target.value)" 
                            placeholder="0.00" 
                            class="w-full pl-8 pr-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs" required>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Description') }}</label>
                <textarea name="description" id="description" rows="2" placeholder="{{ __('Optional details about the product...') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs">{{ old('description') }}</textarea>
            </div>

            <!-- Note -->
            <div>
                <label for="Note" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Note') }}</label>
                <textarea name="Note" id="Note" rows="2" placeholder="{{ __('Internal notes...') }}" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs">{{ old('Note') }}</textarea>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Status') }}</label>
                <select name="status" id="status" 
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all shadow-xs cursor-pointer">
                    <option value="active" @selected(old('status', 'active') === 'active')>{{ __('Active') }}</option>
                    <option value="inactive" @selected(old('status') === 'inactive')>{{ __('Inactive') }}</option>
                </select>
            </div>

            <!-- Image with Preview -->
            <div>
                <label for="image" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5">{{ __('Product Image') }}</label>
                <div class="flex items-center gap-4 p-3 bg-neutral-secondary-medium/50 border border-default rounded-lg shadow-xs">
                    <template x-if="imageUrl">
                        <img :src="imageUrl" class="w-14 h-14 object-cover rounded-lg border border-default shadow-xs" alt="Preview">
                    </template>
                    <template x-if="!imageUrl">
                        <div class="w-14 h-14 bg-neutral-secondary-medium rounded-lg flex items-center justify-center text-body text-[10px] font-bold uppercase tracking-wider border border-default">
                            {{ __('No Image') }}
                        </div>
                    </template>

                    <input type="file" name="image" id="image" accept="image/jpeg,image/png,image/gif,image/webp"
                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file); }"
                        class="block w-full text-xs text-body file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-default">
            <button type="button" @click="$dispatch('close-modal', 'add-product')" :disabled="isSubmitting"
                class="px-5 py-2.5 text-xs font-semibold text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors cursor-pointer shadow-xs disabled:opacity-50">
                {{ __('Cancel') }}
            </button>
            <button type="submit" :disabled="isSubmitting"
                class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer shadow-xs disabled:opacity-70 disabled:cursor-not-allowed">
                {{ __('Save Product') }}
            </button>
        </div>
    </form>
</x-modal>