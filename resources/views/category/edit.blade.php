<x-modal name="edit-category" max-width="md" focusable>
    <form action="" method="POST" class="relative p-6 md:p-8 font-khmer bg-neutral-primary-soft rounded-2xl" 
        x-data="{ 
            id: '', 
            name: '', 
            note: '',
            isSubmitting: false 
        }" 
        @edit-category-data.window="
            id = $event.detail.id || ''; 
            name = $event.detail.name || ''; 
            note = $event.detail.note || $event.detail.Note || ''; 
            $el.action = '/categories/' + id;
            isSubmitting = false;
        "
        @submit="if ($el.checkValidity()) isSubmitting = true">
        @csrf
        @method('PUT')

        <!-- Loading Overlay (ស្ទាយដូច Edit Product) -->
        <div x-show="isSubmitting" x-cloak class="absolute inset-0 bg-neutral-primary-soft/90 backdrop-blur-xs z-50 flex flex-col items-center justify-center gap-3 rounded-2xl transition-all">
            <svg class="w-10 h-10 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-semibold text-heading">{{ __('Updating category, please wait...') }}</span>
        </div>

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-default">
            <div>
                <h3 class="text-xl font-bold text-heading tracking-tight font-sans">
                    {{ __('Edit Category') }}
                </h3>
                <p class="text-sm text-body mt-0.5 font-sans">{{ __('Update category details.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" 
                class="w-8 h-8 rounded-full bg-neutral-secondary-medium hover:bg-neutral-tertiary flex items-center justify-center text-body hover:text-heading transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-5 max-h-[65vh] overflow-y-auto pr-1">
            <!-- Name Field -->
            <div>
                <label for="edit-name" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    id="edit-name"
                    name="name"
                    type="text"
                    x-model="name"
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs font-english"
                    required
                />
            </div>

            <!-- Note Field -->
            <div>
                <label for="edit-note" class="block text-xs font-semibold text-heading uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Note') }}
                </label>
                <textarea 
                    id="edit-note" 
                    name="Note" 
                    rows="3" 
                    x-model="note"
                    class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm focus:ring-2 focus:ring-primary focus:border-primary placeholder:text-body transition-all shadow-xs font-english"
                ></textarea>    
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-default">
            <button type="button" @click="$dispatch('close')" :disabled="isSubmitting"
                class="px-5 py-2.5 text-xs font-semibold text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors cursor-pointer font-sans shadow-xs disabled:opacity-50">
                {{ __('Cancel') }}
            </button>

            <button type="submit" :disabled="isSubmitting"
                class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer font-sans shadow-xs disabled:opacity-70 disabled:cursor-not-allowed">
                <span>{{ __('Update Category') }}</span>
            </button>
        </div>
    </form>
</x-modal>