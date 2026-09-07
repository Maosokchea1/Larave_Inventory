<x-modal name="add-supplier" max-width="lg" focusable>
    <div class="relative w-full max-w-2xl max-h-full p-6 md:p-8 font-khmer bg-white rounded-2xl"
         x-data="{ loading: false }">
        
        <!-- Loading Overlay ស្ទាយបង្វិល (Spinning Style ដូច Edit Product) -->
        <div x-show="loading" x-cloak class="absolute inset-0 bg-white/90 backdrop-blur-xs z-50 flex flex-col items-center justify-center gap-3 rounded-2xl transition-all">
            <svg class="w-10 h-10 animate-spin text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-colorblue-500 font-semibold font-sans">{{ __('Creating supplier, please wait...') }}</span>
        </div>

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200/60">
            <div>
                <h3 class="text-xl font-bold text-gray-800 tracking-tight font-sans">
                    {{ __('Create Supplier') }}
                </h3>
                <p class="text-sm text-gray-500 mt-0.5 font-sans">{{ __('Add a new supplier to your list.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" :disabled="loading"
                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors cursor-pointer disabled:opacity-50">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('suppliers.store') }}" @submit="loading = true" class="space-y-5">
            @csrf

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-4 bg-red-50/80 border border-red-200 rounded-lg text-sm text-red-700 shadow-sm font-sans">
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

            <!-- Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Name') }} <span class="text-red-500">*</span>
                </label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="{{ __('Enter supplier name') }}" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" required />
            </div>

            <!-- Phone & Email -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="phone" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Phone') }}</label>
                    <input id="phone" name="phone" type="text" value="{{ old('phone') }}" placeholder="{{ __('Enter phone number') }}" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ __('Enter email address') }}" 
                        class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
                </div>
            </div>

            <!-- Date Time with Alpine.js & Flatpickr Khmer Locale -->
            <div>
                <label for="date_time" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Date Time') }}</label>
                <input id="date_time" name="date_time" type="text" value="{{ old('date_time') }}" placeholder="{{ __('YYYY-MM-DD hh:mm AM/PM') }}" 
                    x-data="{
                        initFlatpickr() {
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
                            };

                            if (currentLocale === 'km') {
                                config.locale = khmerLocale;
                            }

                            flatpickr(this.$el, config);
                        }
                    }"
                    x-init="initFlatpickr()"
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow" />
            </div>

            <!-- Note -->
            <div>
                <label for="note" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">{{ __('Note') }}</label>
                <textarea id="note" name="note" rows="2" placeholder="{{ __('Optional details or notes...') }}" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow">{{ old('note') }}</textarea>    
            </div>

            <!-- Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-200/60">
                <button type="button" @click="$dispatch('close')" :disabled="loading"
                    class="px-5 py-2.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" :disabled="loading"
                    class="inline-flex items-center justify-center px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans shadow-md hover:shadow-lg focus:ring-2 focus:ring-blue-500/30 disabled:opacity-75 disabled:cursor-not-allowed">
                    <span>{{ __('Save Supplier') }}</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Flatpickr CSS & JS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-modal>