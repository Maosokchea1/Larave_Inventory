<div x-data="{ show: false, roleId: null, roleName: '' }" 
     x-show="show" 
     @open-modal.window="if ($event.detail.name === 'delete-role') { roleId = $event.detail.roleId; roleName = $event.detail.roleName; show = true; }"
     @close-modal.window="show = false"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
    <div @click.away="show = false" class="bg-neutral-primary-soft border border-default rounded-xl shadow-lg w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-heading">{{ __('Delete Role') }}</h3>
            <button @click="show = false" class="text-body hover:text-heading cursor-pointer text-xl font-bold">&times;</button>
        </div>
        <p class="text-sm text-body mb-6">
            {{ __('Are you sure you want to delete the role') }} <span class="font-semibold text-heading" x-text="roleName"></span>?
        </p>

        <!-- FIX: Use a placeholder for the route parameter and replace it dynamically via JS -->
        <form :action="'{{ route('admin.roles.destroy', ['role' => 'PLACEHOLDER']) }}'.replace('PLACEHOLDER', roleId)" method="POST" class="flex justify-end gap-2">
            @csrf
            @method('DELETE')
            <button type="button" @click="show = false" class="px-4 py-2 text-sm font-medium text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary rounded-lg cursor-pointer">
                {{ __('Cancel') }}
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg cursor-pointer">
                {{ __('Delete') }}
            </button>
        </form>
    </div>
</div>