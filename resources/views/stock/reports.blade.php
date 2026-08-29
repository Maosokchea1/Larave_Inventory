<x-app-layout>
    @php
    // Helper សម្រាប់បំប្លែងលេខទៅជាលេខខ្មែរពេល Locale = 'km'
    $formatNum = function ($number) {
    if ($number === null || $number === '') return '';
    if (app()->getLocale() !== 'km') {
    return $number;
    }
    $khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
    $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    return str_replace($englishDigits, $khmerDigits, (string) $number);
    };

    // Helper សម្រាប់បំប្លែង និងបង្ហាញរូបិយប័ណ្ណ (គុណ 4035 និងប្តូរ $ ទៅ ៛ ពេល Locale = 'km')
    $formatCurrency = function ($amount) use ($formatNum) {
    $amount = (float) ($amount ?? 0);
    if (app()->getLocale() === 'km') {
    $khr = $amount * 4035;
    return $formatNum(number_format($khr, 0)) . ' ៛';
    }
    return '$' . number_format($amount, 2);
    };

    // Helper សម្រាប់បំប្លែង កាលបរិច្ឆេទ និង ម៉ោង (ព្រឹក/ល្ងាច) ជាភាសាខ្មែរ
    $formatDate = function ($date) use ($formatNum) {
    if (!$date) return 'N/A';

    try {
    $carbonDate = $date instanceof \DateTimeInterface ? $date : \Carbon\Carbon::parse($date);
    $formatted = $carbonDate->format('Y-m-d h:i A');

    if (app()->getLocale() === 'km') {
    $formatted = str_replace(['AM', 'PM'], ['ព្រឹក', 'ល្ងាច'], $formatted);
    return $formatNum($formatted);
    }

    return $formatted;
    } catch (\Exception $e) {
    return 'N/A';
    }
    };

    // គណនា Total Valuation ស្វ័យប្រវត្តិ ប្រសិនបើ Controller មិនបានส่ง $totalValuation មក
    $productsCollection = $products ?? collect();
    $calculatedValuation = isset($totalValuation) && $totalValuation > 0
    ? $totalValuation
    : $productsCollection->sum(function($p) {
    $c = $p->cost ?? $p->cost_price ?? $p->unit_price ?? $p->purchase_price ?? $p->Cost ?? 0;
    $s = $p->stock ?? $p->quantity ?? $p->qty ?? $p->current_stock ?? $p->stock_quantity ?? 0;
    return (float)$c * (float)$s;
    });
    @endphp

    <!-- Header Section -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-colorblue-500 tracking-tight font-khmersmart">{{ __('Stock Reports & Analytics') }}</h1>
            <p class="text-sm text-slate-500 mt-1 font-sans">{{ __('Overview of warehouse valuation, current inventory levels, and movement logs.') }}</p>
        </div>

        <!-- Summary Card Box -->
        <div class="flex items-center gap-3 bg-white px-5 py-3 rounded-xl border border-slate-200 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div>
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider font-sans">{{ __('Total Inventory Value') }}</p>
                <h3 class="text-lg font-bold text-slate-800 font-sans">{{ $formatCurrency($calculatedValuation) }}</h3>
            </div>
        </div>
    </div>

    <!-- Inventory Stock Levels Table Card -->
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 font-sans">
                <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                {{ __('Current Inventory Status') }}
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-bold font-sans text-white uppercase bg-primary">
                        <th scope="col" class="py-3 px-4">{{ __('Product Name') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('SKU') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Cost Price') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Current Stock') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Total Value') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($products ?? [] as $product)
                    @php
                    $cost = $product->cost
                    ?? $product->cost_price
                    ?? $product->unit_price
                    ?? $product->purchase_price
                    ?? $product->Cost
                    ?? 0;

                    $sku = $product->sku
                    ?? $product->code
                    ?? $product->product_code
                    ?? $product->SKU
                    ?? 'N/A';

                    $stock = $product->stock
                    ?? $product->quantity
                    ?? $product->qty
                    ?? $product->current_stock
                    ?? $product->stock_quantity
                    ?? 0;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4 font-semibold text-slate-800 font-khmer">{{ $product->name }}</td>
                        <td class="py-3 px-4 text-xs text-slate-500 font-mono font-sans">{{ $formatNum($sku) }}</td>
                        <td class="py-3 px-4 text-slate-700 font-sans">{{ $formatCurrency($cost) }}</td>
                        <td class="py-3 px-4 font-bold {{ $stock <= 5 ? 'text-red-600' : 'text-slate-700' }} font-sans">
                            {{ $formatNum($stock) }}
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-700 font-sans">{{ $formatCurrency($stock * $cost) }}</td>
                        <td class="py-3 px-4 font-sans">
                            @if($stock <= 0)
                                <span class="px-2.5 py-1 text-[11px] font-medium bg-red-50 text-red-700 rounded border border-red-200">{{ __('Out of Stock') }}</span>
                            @elseif($stock <= 5)
                                <span class="px-2.5 py-1 text-[11px] font-medium bg-amber-50 text-amber-700 rounded border border-amber-200">{{ __('Low Stock') }}</span>
                            @else
                                <span class="px-2.5 py-1 text-[11px] font-medium bg-emerald-50 text-emerald-700 rounded border border-emerald-200">{{ __('In Stock') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-400 text-sm font-sans">{{ __('No products found.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Analytics Charts Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Bar Chart Section -->
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 font-sans">
                    <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                    {{ __('Stock Movements Volume') }}
                </h3>
            </div>
            <div class="relative h-64 w-full">
                <canvas id="stockMovementChart"></canvas>
            </div>
        </div>

        <!-- Doughnut Graph Section -->
        <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 font-sans">
                    <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                    {{ __('Movement Distribution Ratio') }}
                </h3>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-center">
                <div class="relative h-56 w-full sm:col-span-2">
                    <canvas id="stockDoughnutChart"></canvas>
                </div>
                <!-- Metric Legend -->
                <div class="flex flex-col gap-2 p-3 bg-slate-50 rounded-lg border border-slate-200">
                    <div class="flex items-center justify-between text-xs text-slate-600 font-sans">
                        <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>{{ __('Stock In') }}</span>
                        <span id="legend-in" class="font-sans text-slate-800">0</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-600 font-sans">
                        <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-rose-500"></span> {{ __('Stock Out') }}</span>
                        <span id="legend-out" class="font-sans text-slate-800">0</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-600 font-sans">
                        <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500"></span> {{ __('Adjustment') }}</span>
                        <span id="legend-adj" class="font-sans text-slate-800">0</span>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-600 font-sans">
                        <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-500"></span> {{ __('Transfer') }}</span>
                        <span id="legend-trans" class="font-sans text-slate-800">0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Movement History Log with Filters & Export Button -->
    <div class="bg-white shadow-sm rounded-xl border border-slate-200 p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2 font-sans">
                <span class="w-2 h-2 rounded-full bg-slate-800"></span>
                {{ __('Stock Movements Log') }}
            </h3>

            <!-- Filter Form & Options Group -->
            <div class="flex flex-wrap items-center gap-2">
                <form method="GET" action="{{ route('stock.reports') }}" class="flex flex-wrap items-center gap-2">
                    <!-- Date From -->
                    <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-2 py-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-sans">{{ __('From') }}:</span>
                        <input type="text" name="date_from" value="{{ request('date_from') }}" placeholder="YYYY-MM-DD" class="js-datepicker text-xs bg-transparent border-none focus:ring-0 text-slate-600 p-0.5 font-sans">
                    </div>

                    <!-- Date To -->
                    <div class="flex items-center gap-1 bg-white border border-slate-200 rounded-lg px-2 py-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase font-sans">{{ __('To') }}:</span>
                        <input type="text" name="date_to" value="{{ request('date_to') }}" placeholder="YYYY-MM-DD" class="js-datepicker text-xs bg-transparent border-none focus:ring-0 text-slate-600 p-0.5 font-sans">
                    </div>

                    <!-- Type Filter -->
                    <select name="type" class="rounded-lg border-slate-200 text-xs py-2 focus:ring-slate-800 focus:border-slate-800 text-slate-600 bg-white font-sans">
                        <option value="" class="font-sans">{{ __('All Types') }}</option>
                        <option value="in" class="font-sans" {{ request('type') == 'in' ? 'selected' : '' }}>{{ __('Stock In') }}</option>
                        <option value="out" class="font-sans" {{ request('type') == 'out' ? 'selected' : '' }}>{{ __('Stock Out') }}</option>
                        <option value="adjustment" class="font-sans" {{ request('type') == 'adjustment' ? 'selected' : '' }}>{{ __('Adjustment') }}</option>
                        <option value="transfer" class="font-sans" {{ request('type') == 'transfer' ? 'selected' : '' }}>{{ __('Transfer') }}</option>
                    </select>

                    <!-- Product Filter -->
                    <select name="product_id" class="rounded-lg border-slate-200 text-xs py-2 focus:ring-slate-800 focus:border-slate-800 text-slate-600 bg-white font-khmer">
                        <option value="" class="font-sans">{{ __('All Products') }}</option>
                        @foreach($allProducts ?? $products ?? [] as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }} class="font-khmer">{{ $p->name }}</option>
                        @endforeach
                    </select>

                    <!-- Filter Button -->
                    <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-semibold rounded-lg transition-colors cursor-pointer flex items-center gap-1.5 font-sans">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.172a1 1 0 01-1.447.894l-4-2A1 1 0 017 16.172v-4.172a1 1 0 00-.293-.707L.293 7.293A1 1 0 010 6.586V4z" />
                        </svg>
                        {{ __('Filter') }}
                    </button>
                </form>

                <!-- Reset Button -->
                <a href="{{ route('stock.reports') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5 font-sans">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    {{ __('Reset') }}
                </a>

                <!-- Export Excel Button -->
                <a href="{{ route('stock.reports.export', request()->all()) }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5 font-sans">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    {{ __('Excel') }}
                </a>

                <!-- Export PDF Button -->
                <a href="{{ route('stock.reports.pdf', request()->all()) }}" class="px-3 py-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 text-xs font-semibold rounded-lg transition-colors flex items-center gap-1.5 font-sans">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __('PDF') }}
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-semibold font-sans text-white uppercase bg-primary">
                        <th scope="col" class="py-3 px-4">{{ __('Date') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Type') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Product') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Quantity') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('Note / Details') }}</th>
                        <th scope="col" class="py-3 px-4">{{ __('User') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($transactions ?? [] as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-4 text-xs text-slate-400 font-mono font-sans">{{ $formatDate($trx->created_at) }}</td>
                        <td class="py-3 px-4 font-sans">
                            @if($trx->type == 'in')
                            <span class="px-2 py-0.5 text-[11px] font-sans bg-emerald-50 text-emerald-700 rounded border border-emerald-200">{{ __('Stock In') }}</span>
                            @elseif($trx->type == 'out')
                            <span class="px-2 py-0.5 text-[11px] font-sans bg-rose-50 text-rose-700 rounded border border-rose-200">{{ __('Stock Out') }}</span>
                            @elseif($trx->type == 'adjustment')
                            <span class="px-2 py-0.5 text-[11px] font-sans bg-amber-50 text-amber-700 rounded border border-amber-200">{{ __('Adjustment') }}</span>
                            @else
                            <span class="px-2 py-0.5 text-[11px] font-sans bg-blue-50 text-blue-700 rounded border border-blue-200">{{ __('Transfer') }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-800 font-khmer">{{ $trx->product?->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4 font-bold {{ $trx->type == 'in' ? 'text-emerald-600' : ($trx->type == 'out' ? 'text-rose-600' : ($trx->type == 'adjustment' ? 'text-amber-600' : 'text-blue-600')) }} font-sans">
                            {{ $trx->type == 'in' ? '+' : ($trx->type == 'out' ? '-' : '') }}{{ $formatNum($trx->quantity) }}
                        </td>
                        <td class="py-3 px-4 text-xs text-slate-500 font-sans">{{ $trx->note ?? '-' }}</td>
                        <td class="py-3 px-4 text-xs font-medium text-slate-600 font-sans">{{ $trx->user?->name ?? 'N/A' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-slate-400 text-sm font-sans">{{ __('No transaction records found.') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(isset($transactions) && method_exists($transactions, 'links'))
        <div class="mt-4 font-sans">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

    <!-- Chart.js & Flatpickr CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocale = "{{ app()->getLocale() }}";

            // Function សម្រាប់បំប្លែងលេខក្នុង JS Legend ទៅជាលេខខ្មែរ
            const formatKhmerNum = (num) => {
                if (currentLocale !== 'km') return num;
                const khmerDigits = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
                return String(num).replace(/[0-9]/g, w => khmerDigits[w]);
            };

            // Get Tailwind sans font family
            const dummyEl = document.createElement('span');
            dummyEl.className = 'font-sans';
            document.body.appendChild(dummyEl);
            const tailwindFontSans = window.getComputedStyle(dummyEl).fontFamily || 'ui-sans-serif, system-ui, sans-serif';
            document.body.removeChild(dummyEl);

            Chart.defaults.font.family = tailwindFontSans;
            Chart.defaults.font.size = 11;

            const transactionsData = @json(isset($chartTransactions) ? $chartTransactions : (isset($transactions) && method_exists($transactions, 'items') ? $transactions->items() : ($transactions ?? [])));

            const chartLabels = [
                "{{ __('Stock In') }}",
                "{{ __('Stock Out') }}",
                "{{ __('Adjustment') }}",
                "{{ __('Transfer') }}"
            ];
            const datasetLabelText = "{{ __('Total Quantity Moved') }}";

            let countIn = 0,
                countOut = 0,
                countAdj = 0,
                countTrans = 0;
            if (Array.isArray(transactionsData)) {
                transactionsData.forEach(item => {
                    const qty = Number(item.quantity) || 0;
                    if (item.type === 'in') countIn += qty;
                    if (item.type === 'out') countOut += qty;
                    if (item.type === 'adjustment') countAdj += qty;
                    if (item.type === 'transfer') countTrans += qty;
                });
            }

            const legendIds = ['legend-in', 'legend-out', 'legend-adj', 'legend-trans'];
            const counts = [countIn, countOut, countAdj, countTrans];
            legendIds.forEach((id, index) => {
                const el = document.getElementById(id);
                if (el) el.innerText = formatKhmerNum(counts[index]);
            });

            // Bar Chart
            const barEl = document.getElementById('stockMovementChart');
            if (barEl) {
                new Chart(barEl.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: datasetLabelText,
                            data: [countIn, countOut, countAdj, countTrans],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.15)',
                                'rgba(244, 63, 94, 0.15)',
                                'rgba(245, 158, 11, 0.15)',
                                'rgba(59, 130, 246, 0.15)'
                            ],
                            borderColor: [
                                'rgb(16, 185, 129)',
                                'rgb(244, 63, 94)',
                                'rgb(245, 158, 11)',
                                'rgb(59, 130, 246)'
                            ],
                            borderWidth: 1.5,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(241, 245, 249, 1)'
                                },
                                ticks: {
                                    font: {
                                        family: tailwindFontSans,
                                        size: 11
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        family: tailwindFontSans,
                                        size: 11
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            // Doughnut Chart
            const doughnutEl = document.getElementById('stockDoughnutChart');
            if (doughnutEl) {
                new Chart(doughnutEl.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            data: [countIn, countOut, countAdj, countTrans],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.85)',
                                'rgba(244, 63, 94, 0.85)',
                                'rgba(245, 158, 11, 0.85)',
                                'rgba(59, 130, 246, 0.85)'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleFont: {
                                    family: tailwindFontSans,
                                    size: 11,
                                    weight: 'bold'
                                },
                                bodyFont: {
                                    family: tailwindFontSans,
                                    size: 11
                                },
                                padding: 10,
                                cornerRadius: 6,
                                displayColors: true
                            }
                        }
                    }
                });
            }
        });
    </script>

    <!-- Flatpickr Custom Khmer Localization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocale = "{{ app()->getLocale() }}";

            const khmerLocale = {
                clear: "លុបចោល",
                today: "ថ្ងៃនេះ",
                amPM: ["ព្រឹក", "ល្ងាច"],
                weekdays: {
                    shorthand: ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"],
                    longhand: ["អាទិត្យ", "ចន្ទ", "អង្គារ", "ពុធ", "ព្រហស្បតិ៍", "សុក្រ", "សៅរ៍"]
                },
                months: {
                    shorthand: ["មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"],
                    longhand: ["មករា", "កុម្ភៈ", "មីនា", "មេសា", "ឧសភា", "មិថុនា", "កក្កដា", "សីហា", "កញ្ញា", "តុលា", "វិច្ឆិកា", "ធ្នូ"]
                }
            };

            const config = {
                dateFormat: "Y-m-d",
                locale: currentLocale === 'km' ? khmerLocale : 'default'
            };

            flatpickr(".js-datepicker", config);
        });
    </script>
</x-app-layout>