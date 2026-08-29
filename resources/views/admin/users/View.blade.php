<x-modal name="view-user" max-width="md" focusable>
    <div class="p-6 md:p-8 font-khmer" 
        x-data="{ 
            id: '',
            image: '',
            name: '', 
            email: '', 
            mobile: '', 
            role: '', 
            address: '',
            status: '',
            created_at: ''
        }" 
        @view-user-data.window="
            id = $event.detail.id;
            image = $event.detail.image;
            name = $event.detail.name; 
            email = $event.detail.email; 
            mobile = $event.detail.mobile; 
            role = $event.detail.role; 
            address = $event.detail.address;
            status = $event.detail.status;
            created_at = $event.detail.created_at;
        ">

        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight font-sans">
                    {{ __('View Customer and Role') }}
                </h3>
                <p class="text-xs text-slate-400 mt-0.5 font-sans">{{ __('View account credentials and status.') }}</p>
            </div>
            <button type="button" @click="$dispatch('close')" class="w-8 h-8 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="space-y-4 max-h-[65vh] overflow-y-auto pr-1">
            <!-- User Profile Image & ID Header Preview -->
            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200/60">
                <div class="w-14 h-14 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold text-base overflow-hidden shrink-0 border border-slate-200">
                    <template x-if="image">
                        <img :src="image" alt="" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!image">
                        <span x-text="name ? name.substring(0, 2).toUpperCase() : 'US'"></span>
                    </template>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 font-sans">{{ __('ID:') }}</span>
                        <span class="text-xs font-bold text-slate-700 font-sans" x-text="id"></span>
                    </div>
                    <div class="text-sm font-bold text-slate-800 font-sans mt-0.5" x-text="name"></div>
                    <div class="text-xs text-slate-400 font-sans" x-text="created_at"></div>
                </div>
            </div>

            <!-- Name Field -->
            <div>
                <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Name') }}
                </label>
                <input 
                    type="text"
                    x-model="name"
                    disabled
                    class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-sans cursor-not-allowed"
                />
            </div>

            <!-- Email Field -->
            <div>
                <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Email') }}
                </label>
                <input 
                    type="email"
                    x-model="email"
                    disabled
                    class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-sans cursor-not-allowed"
                />
            </div>

            <!-- Mobile Field -->
            <div>
                <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Mobile') }}
                </label>
                <input 
                    type="text"
                    x-model="mobile"
                    disabled
                    class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-sans cursor-not-allowed"
                />
            </div>

            <!-- Address Field -->
            <div>
                <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                    {{ __('Address') }}
                </label>
                <input 
                    type="text"
                    x-model="address"
                    disabled
                    class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-sans cursor-not-allowed"
                />
            </div>

            <!-- Role & Status Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                        {{ __('Role') }}
                    </label>
                    <input 
                        type="text"
                        x-model="role"
                        disabled
                        class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-sans capitalize cursor-not-allowed"
                    />
                </div>

                <div>
                    <label class="block text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-1.5 font-sans">
                        {{ __('Status') }}
                    </label>
                    <input 
                        type="text"
                        x-model="status"
                        disabled
                        class="w-full px-4 py-2.5 bg-slate-100/70 border border-slate-200 rounded-xl text-slate-800 text-sm font-medium font-english cursor-not-allowed"
                    />
                </div>
            </div>
        </div>

        <!-- Buttons Footer -->
        <div class="flex items-center justify-end gap-3 pt-5 mt-6 border-t border-slate-100">
            <button type="button" @click="$dispatch('close')" class="px-5 py-2.5 text-xs font-extrabold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all cursor-pointer font-sans">
                {{ __('Close') }}
            </button>
        </div>
    </div>
</x-modal>