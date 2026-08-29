<x-app-layout>
    @php
        // Helper សម្រាប់បំប្លែងលេខទៅជាលេខខ្មែរពេល Locale = 'km'
        $formatNum = function ($number) {
            if (app()->getLocale() !== 'km') {
                return $number;
            }
            $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
            return str_replace($englishDigits, $khmerDigits, (string) $number);
        };

        // Helper សម្រាប់បំប្លែង កាលបរិច្ឆេទ និង ម៉ោង (ព្រឹក/ល្ងាច) ជាភាសាខ្មែរ
        $formatDate = function ($date) use ($formatNum) {
            if (!$date) return 'N/A';
            
            // Format 12 ម៉ោង (h:i A -> 12-hour with AM/PM)
            $formatted = $date->format('Y-m-d h:i A');

            if (app()->getLocale() === 'km') {
                $formatted = str_replace(['AM', 'PM'], ['ព្រឹក', 'ល្ងាច'], $formatted);
                return $formatNum($formatted);
            }

            return $formatted;
        };
    @endphp

    <div class="mb-8 font-khmer">
        <h1 class="text-3xl font-black text-colorblue-500 tracking-tight font-khmersmart">{{ __('Stock Adjustments') }}</h1>
        <p class="text-sm font-medium text-slate-500 mt-1 font-sans">{{ __('Correct warehouse stock discrepancies due to damage, loss, or auditing.') }}</p>
    </div>

    <!-- បង្ហាញសារជោគជ័យ (Success) -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-semibold text-sm font-sans flex items-center justify-between shadow-xs">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove();" class="text-emerald-700 hover:text-emerald-900 font-sans text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- បង្ហាញសាររំលឹកកំហុស/គ្មានសិទ្ធិ ឬស្តុកមិនគ្រប់ (Session Error) -->
    @if(session('error'))
        <div class="mb-6 p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-between shadow-xs transition-all">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <span class="font-medium font-sans">{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove();" class="text-rose-600 hover:text-rose-900 font-sans text-lg cursor-pointer px-2">&times;</button>
        </div>
    @endif

    <!-- បង្ហាញ Validation Errors ប្រសិនបើបំពេញ Form ខុស -->
    @if($errors->any())
        <div class="mb-6 p-4 text-sm text-rose-800 rounded-2xl bg-rose-50 border border-rose-200 shadow-xs">
            <div class="font-bold mb-1 font-sans">{{ __('Please fix the following errors:') }}</div>
            <ul class="list-disc list-inside text-xs space-y-1 font-sans">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Adjustment -->
        <div class="bg-white shadow-xl shadow-slate-100 rounded-3xl border border-slate-100 p-6 h-fit font-sans">
            <h3 class="text-base font-extrabold text-slate-800 uppercase tracking-wider mb-5 font-sans">{{ __('New Adjustment Entry') }}</h3>
            
            <form action="{{ route('stock.adjustments.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Select Product -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1 font-sans">{{ __('Select Product') }}</label>
                    <select name="product_id" required class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm font-medium font-sans">
                        <option value="">{{ __('-- Choose Product --') }}</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} ({{ __('Current') }}: {{ $formatNum($product->stock) }})
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Adjustment Action -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1 font-sans">{{ __('Adjustment Action') }}</label>
                    <select name="adjustment_type" required class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm font-medium font-sans">
                        <option value="add" {{ old('adjustment_type') == 'add' ? 'selected' : '' }}>{{ __('Add Stock (+)') }}</option>
                        <option value="subtract" {{ old('adjustment_type') == 'subtract' ? 'selected' : '' }}>{{ __('Subtract Stock (-)') }}</option>
                        <option value="set" {{ old('adjustment_type') == 'set' ? 'selected' : '' }}>{{ __('Set Exact Stock (=)') }}</option>
                    </select>
                    @error('adjustment_type')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1 font-sans">{{ __('Quantity') }}</label>
                    <input type="number" name="quantity" min="1" value="{{ old('quantity') }}" required class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm font-medium font-sans" placeholder="{{ __('e.g. 10') }}">
                    @error('quantity')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reason / Note -->
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1 font-sans">{{ __('Reason / Note') }} ({{ __('Required') }})</label>
                    <textarea name="note" rows="2" required class="w-full rounded-xl border-slate-200 focus:border-amber-500 focus:ring-amber-500 text-sm font-medium font-sans" placeholder="{{ __('e.g. Damaged items, physical audit count...') }}">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full py-3 bg-amber-600 hover:bg-amber-700 text-white font-extrabold rounded-xl shadow-lg shadow-amber-500/20 transition-all text-sm font-khmer">
                    {{ __('Save Adjustment') }}
                </button>
            </form>
        </div>

        <!-- History Table -->
        <div class="bg-white shadow-xl shadow-slate-100 rounded-3xl border border-slate-100 p-6 lg:col-span-2 overflow-hidden font-khmer">
            <h3 class="text-base font-extrabold text-slate-800 uppercase tracking-wider mb-5 font-sans">{{ __('Adjustment History Log') }}</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="text-xs uppercase bg-primary text-white tracking-wider font-sans shadow-sm">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 font-extrabold">{{ __('Date') }}</th>
                            <th scope="col" class="py-3.5 px-4 font-extrabold">{{ __('Product') }}</th>
                            <th scope="col" class="py-3.5 px-4 font-extrabold">{{ __('Details & Reason') }}</th>
                            <th scope="col" class="py-3.5 px-4 font-extrabold">{{ __('By User') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm font-medium text-slate-600 font-sans">
                        @forelse($adjustments as $item)
                            <tr>
                                <td class="py-3 px-4 text-xs text-slate-400 font-sans">{{ $formatDate($item->created_at) }}</td>
                                <td class="py-3 px-4 font-bold text-slate-800 font-sans">{{ $item->product->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4 text-xs text-slate-600 font-medium font-sans">{{ $item->note }}</td>
                                <td class="py-3 px-4 text-xs text-slate-500 font-sans">{{ $item->user->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-6 text-center text-slate-400 text-sm font-sans">{{ __('No adjustment records found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 font-sans">
                {{ $adjustments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>