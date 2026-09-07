<x-modal name="edit-supplier" max-width="lg" focusable>
    <div class="relative w-full max-w-2xl max-h-full p-6 md:p-8 font-khmer bg-white rounded-2xl" 
         x-data="{ 
            id: '', 
            name: '', 
            phone: '', 
            email: '', 
            date_time: '', 
            note: '',
            loading: false,
            fpInstance: null
         }" 
         x-init="
            const currentLocale = '{{ app()->getLocale() }}';
            const khmerLocale = {
                clear: 'លុបចោល',
                today: 'ថ្ងៃនេះ',
                amPM: ['ព្រឹក', 'ល្ងាច'],
                weekdays: {
                    shorthand: ['អាទិត្យ', 'ចន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហ', 'សុក្រ', 'សៅរ៍'],
                    longhand: ['អាទិត្យ', 'ច័ន្ទ', 'អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍']
                },
                months: {
                    shorthand: ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'],
                    longhand: ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ']
                }
            };

            let config = {
                enableTime: true,
                dateFormat: 'Y-m-d h:i K',
                time_24hr: false,
                onChange: (selectedDates, dateStr) => {
                    date_time = dateStr;
                }
            };

            if (currentLocale === 'km') {
                config.locale = khmerLocale;
            }

            fpInstance = flatpickr($refs.editDateTimeInput, config);
            
            // Watch for changes from event to update Flatpickr UI when editing
            $watch('date_time', value => {
                if (fpInstance && value) {
                    fpInstance.setDate(value, true);
                }
            });
         "
         x-on:edit-supplier-data.window="Object.assign($data, $event.detail); loading = false;">
        
        <!-- Full Modal Loading Overlay (ស្ទាយបង្វិលដូច Edit Product) -->
        <div x-show="loading" x-cloak class="absolute inset-0 bg-white/90 backdrop-blur-xs z-50 flex flex-col items-center justify-center gap-3 rounded-2xl transition-all">
            <svg class="w-10 h-10 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm font-semibold text-gray-800 font-sans">{{ __('Updating supplier, please wait...') }}</span>
        </div>

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200/60">
            <div>
                <h3 class="text-xl font-bold text-gray-800 tracking-tight font-sans">
                    {{ __('Edit Supplier') }}
                </h3>
                <p class="text-sm text-gray-500 mt-0.5 font-sans">{{ __('Update the supplier information.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" :disabled="loading"
                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors cursor-pointer disabled:opacity-50">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>

        <form method="POST" :action="`{{ url('suppliers') }}/${id}`" @submit="loading = true" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="edit_name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Name') }} <span class="text-red-500">*</span>
                </label>
                <input id="edit_name" x-model="name" name="name" type="text" placeholder="{{ __('Enter supplier name') }}" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" required />
            </div>

            <!-- Phone & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="edit_phone" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Phone') }}</label>
                    <input id="edit_phone" x-model="phone" name="phone" type="text" placeholder="{{ __('Enter phone number') }}" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
                </div>
                <div>
                    <label for="edit_email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Email') }}</label>
                    <input id="edit_email" x-model="email" name="email" type="email" placeholder="{{ __('Enter email address') }}" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
                </div>
            </div>

            <!-- Date Time (Flatpickr with Khmer AM/PM Translation) -->
            <div>
                <label for="edit_date_time" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Date Time') }}</label>
                <input id="edit_date_time" x-ref="editDateTimeInput" x-model="date_time" name="date_time" type="text" placeholder="{{ __('YYYY-MM-DD hh:mm AM/PM') }}" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
            </div>

            <!-- Note -->
            <div>
                <label for="edit_note" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Note') }}</label>
                <textarea id="edit_note" x-model="note" name="note" rows="2" placeholder="{{ __('Optional details or notes...') }}" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow"></textarea>
            </div>

            <!-- Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-200/60">
                <button type="button" @click="$dispatch('close')" :disabled="loading"
                    class="px-5 py-2.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" :disabled="loading"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans shadow-md hover:shadow-lg focus:ring-2 focus:ring-blue-500/30 disabled:opacity-75 disabled:cursor-not-allowed">
                    <span>{{ __('Update Supplier') }}</span>
                </button>
            </div>
        </form>
    </div>
</x-modal>