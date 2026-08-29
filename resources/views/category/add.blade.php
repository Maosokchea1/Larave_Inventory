<x-modal name="add-category" max-width="sm" focusable>
    <form action="{{ route('categories.store') }}" method="POST" class="p-6 md:p-8 font-khmer" 
        x-data="{ loading: false }" @submit="loading = true">
        @csrf

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-gray-200/60">
            <div>
                <h3 class="text-xl font-bold text-gray-800 tracking-tight font-sans">
                    {{ __('Create Category') }}
                </h3>
                <p class="text-sm text-gray-500 mt-0.5 font-sans">{{ __('Add a new category to your system.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" 
                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-5 max-h-[65vh] overflow-y-auto pr-1">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="p-4 bg-red-50/80 border border-red-200 rounded-lg text-sm text-red-700 shadow-sm font-english">
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

            <!-- Name Field -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Name') }} <span class="text-red-500">*</span>
                </label>
                <input 
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow"
                    required
                    autofocus
                    placeholder="{{ __('Enter category name...') }}"
                />
            </div>

            <!-- Note Field -->
            <div>
                <label for="Note" class="block text-xs font-semibold text-gray-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Note') }}
                </label>
                <textarea 
                    id="Note" 
                    name="Note" 
                    rows="3" 
                    class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-gray-700 text-sm focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition duration-150 ease-in-out font-sans shadow-sm hover:shadow"
                    placeholder="{{ __('Optional notes...') }}"
                >{{ old('Note') }}</textarea>    
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-gray-200/60">
            <button type="button" @click="$dispatch('close')" 
                class="px-5 py-2.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans">
                {{ __('Cancel') }}
            </button>

            <button type="submit" 
                class="px-6 py-2.5 text-xs font-semibold text-white bg-primary hover:bg-blue-700 rounded-lg transition duration-150 ease-in-out cursor-pointer font-sans inline-flex items-center justify-center min-w-[100px] shadow-md hover:shadow-lg focus:ring-2 focus:ring-blue-500/30" 
                :disabled="loading">
                <span x-show="!loading">{{ __('Save') }}</span>
                <span x-show="loading" class="flex items-center gap-1.5" style="display: none;">
                    <svg class="animate-spin h-3.5 w-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    {{ __('Saving...') }}
                </span>
            </button>
        </div>
    </form>
</x-modal>