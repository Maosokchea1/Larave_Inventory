<div x-data="{ show: false }"
     x-show="show"
     @open-modal.window="if ($event.detail === 'add-permission') show = true"
     @close-modal.window="show = false"
     @keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">
    
    <div @click.outside="show = false" class="bg-white dark:bg-neutral-primary-soft rounded-2xl shadow-xl border border-default w-full max-w-md overflow-hidden p-6 font-khmer">
        <div class="flex justify-between items-center pb-4 mb-4 border-b border-default">
            <h3 class="text-lg font-bold text-heading font-english">{{ __('Add New Permission') }}</h3>
            <button @click="show = false" class="text-body hover:text-heading cursor-pointer text-xl font-bold">&times;</button>
        </div>

        <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-body uppercase mb-1 font-english">{{ __('Permission Name (Slug)') }}</label>
                <input type="text" name="name" required 
                       class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-xl text-heading text-sm font-english focus:ring-2 focus:ring-primary focus:border-primary"
                       placeholder="{{ __('e.g., product.create') }}">
            </div>

            <div>
                <label class="block text-xs font-bold text-body uppercase mb-1 font-english">{{ __('Group Name') }}</label>
                <input type="text" name="group_name" 
                       class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-xl text-heading text-sm font-english focus:ring-2 focus:ring-primary focus:border-primary"
                       placeholder="{{ __('e.g., Product') }}">
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-default">
                <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary rounded-xl cursor-pointer">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-700 rounded-xl cursor-pointer shadow-xs">
                    {{ __('Save Permission') }}
                </button>
            </div>
        </form>
    </div>
</div>