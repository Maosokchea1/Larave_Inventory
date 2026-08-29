<!-- Add Role Modal -->
<div x-data="{ open: {{ $errors->has('name') || $errors->has('user_id') ? 'true' : 'false' }} }" 
     @open-modal.window="if ($event.detail === 'add-role') open = true" 
     @close-modal.window="open = false"
     x-show="open" 
     style="display: none;"
     class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-xs flex items-center justify-center p-4">

    <div @click.outside="open = false" class="bg-white dark:bg-neutral-primary-soft rounded-2xl shadow-xl border border-default w-full max-w-md overflow-hidden p-6 font-khmer">
        <form method="post" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="flex justify-between items-center pb-4 mb-4 border-b border-default">
                <h2 class="text-lg font-semibold text-heading font-english">
                    {{ __('Add New Role') }}
                </h2>
                <button type="button" @click="open = false" class="text-body hover:text-heading text-xl font-bold cursor-pointer">&times;</button>
            </div>

            <!-- Role Name Select -->
            <div class="mb-4">
                <label for="name" class="block mb-2 text-xs font-extrabold uppercase text-body font-english">{{ __('ROLE NAME') }}</label>
                <select id="name" name="name" class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-english focus:ring-2 focus:ring-primary focus:border-primary" required>
                    <option value="">{{ __('Select Role') }}</option>
                    <option value="Admin" {{ old('name') === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="User" {{ old('name') === 'User' ? 'selected' : '' }}>User</option>
                </select>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Select User Select -->
            <div class="mb-6">
                <label for="user_id" class="block mb-2 text-xs font-extrabold uppercase text-body font-english">{{ __('SELECT USER') }}</label>
                <select id="user_id" name="user_id" class="w-full px-4 py-2.5 bg-neutral-secondary-medium border border-default-medium rounded-lg text-heading text-sm font-english focus:ring-2 focus:ring-primary focus:border-primary" required>
                    <option value="">{{ __('Select User') }}</option>
                    @foreach($users ?? [] as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                @error('user_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-default">
                <button type="button" @click="open = false" class="px-4 py-2.5 text-sm font-medium text-body bg-neutral-secondary-medium hover:bg-neutral-tertiary border border-default-medium rounded-lg transition-colors cursor-pointer">
                    {{ __('បោះបង់') }}
                </button>
                <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-primary hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 rounded-lg transition-colors cursor-pointer">
                    {{ __('Save Role') }}
                </button>
            </div>
        </form>
    </div>
</div>