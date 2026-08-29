@php
    function formatNumber($number) {
        $isKhmer = in_array(app()->getLocale(), ['km', 'kh']);
        
        if (!$isKhmer) {
            return $number;
        }

        $arabic = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $khmer  = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
        return str_replace($arabic, $khmer, $number);
    }
@endphp

<x-app-layout>
    <!-- Header Section -->
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 font-sans">
        <div>
            <h1 class="text-2xl font-khmersmart text-colorblue-500 tracking-tight">{{ __('Dashboard') }}</h1>
            <p class="text-sm text-slate-500 mt-1 font-sans">{{ __("You're logged in successfully. Here is your inventory quick access overview.") }}</p>
        </div>
        <div class="flex items-center gap-3 font-sans">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-100 border border-slate-200 rounded-md text-xs font-sans text-slate-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="mb-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md p-6 flex items-center justify-between flex-wrap gap-4 text-white font-sans">
        <div class="flex items-center gap-4 font-sans">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/10 text-white font-sans text-lg backdrop-blur-sm border border-white/10">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="font-sans">
                <h3 class="text-xl font-semibold font-sans">{{ __('Welcome back, :name', ['name' => Auth::user()->name]) }}</h3>
                <p class="text-sm text-white/80 font-sans">{{ __('Here is a summary of your inventory activities and system performance.') }}</p>
            </div>
        </div>
        <div class="text-sm font-sans text-white/80">
            @php
                $currentDate = \Carbon\Carbon::now();
            @endphp
            {{ formatNumber($currentDate->format('j')) }} 
            {{ __($currentDate->format('F')) }}, 
            {{ formatNumber($currentDate->format('Y')) }}
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 font-sans">
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-xs font-sans text-slate-400 uppercase tracking-wider">{{ __('Total Products') }}</p>
                    <p class="text-3xl font-sans text-slate-800 mt-1">{{ formatNumber($totalProducts ?? 0) }}</p>
                </div>
                <div class="p-2 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 font-sans">
                <span class="text-xs text-slate-500 font-sans">{{ __('Active inventory') }}</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-xs font-sans text-slate-400 uppercase tracking-wider">{{ __('Low Stock') }}</p>
                    <p class="text-3xl font-sans text-slate-800 mt-1">{{ formatNumber($lowStockCount ?? 0) }}</p>
                </div>
                <div class="p-2 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.5A2.25 2.25 0 009.75 2.25h-1.5a2.25 2.25 0 00-2.25 2.25v10.5a2.25 2.25 0 002.25 2.25h1.5a2.25 2.25 0 002.25-2.25V12m0 0h3.75" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 font-sans">
                <span class="text-xs text-slate-500 font-sans">{{ __('Needs attention') }}</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-xs font-sans text-slate-400 uppercase tracking-wider">{{ __('Categories') }}</p>
                    <p class="text-3xl font-sans text-slate-800 mt-1">{{ formatNumber($totalCategories ?? 0) }}</p>
                </div>
                <div class="p-2 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 font-sans">
                <span class="text-xs text-slate-500 font-sans">{{ __('Product groups') }}</span>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-xs font-sans text-slate-400 uppercase tracking-wider">{{ __('Suppliers') }}</p>
                    <p class="text-3xl font-sans text-slate-800 mt-1">{{ formatNumber($totalSuppliers ?? 0) }}</p>
                </div>
                <div class="p-2 rounded-lg bg-slate-100 text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 font-sans">
                <span class="text-xs text-slate-500 font-sans">{{ __('Registered vendors') }}</span>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 font-sans">
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 lg:col-span-2 font-sans">
            <div class="flex items-center justify-between mb-4 font-sans">
                <h4 class="text-base font-sans font-semibold text-slate-700">{{ __('Stock In vs Stock Out (Weekly)') }}</h4>
                <span class="text-xs font-sans text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-200">{{ __('Bar Chart') }}</span>
            </div>
            <div class="relative h-72 w-full font-sans">
                <canvas id="stockMovementChart"></canvas>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 font-sans">
            <h4 class="text-base font-sans font-semibold text-slate-700 mb-4">{{ __('Category Ratio') }}</h4>
            <div class="relative h-64 w-full flex items-center justify-center font-sans">
                <canvas id="categoryRatioChart"></canvas>
            </div>
            <div class="mt-4 text-center font-sans">
                <p class="text-xs font-sans text-slate-400">{{ __('Distribution of items per category') }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Stock Activities (Standardized) -->
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 mt-2 font-sans">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4 font-sans">
            <div>
                <h4 class="text-base font-semibold text-slate-800">{{ __('Recent Stock Activities') }}</h4>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('Overview of recent stock movements and activity volume share') }}</p>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 text-xs font-sans text-slate-600 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200 font-medium">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    {{ __('Total Volume') }}: <strong class="text-slate-800 font-bold">{{ formatNumber(isset($recentMovements) ? $recentMovements->sum('quantity') : 0) }}</strong>
                </span>
            </div>
        </div>

        <div class="overflow-x-auto font-sans">
            <table class="min-w-full divide-y divide-slate-200 text-sm font-sans">
                <thead class="text-xs uppercase bg-primary text-slate-100 tracking-wider shadow-sm font-sans">
                    <tr>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('Product') }}</th>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('Type') }}</th>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('Quantity') }}</th>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('Activity Share (%)') }}</th>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('Date') }}</th>
                        <th scope="col" class="px-4 py-3.5 font-bold text-center">{{ __('User') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-sans bg-white">
                    @if(isset($recentMovements) && $recentMovements->count() > 0)
                        @php
                            $totalMovementQty = (float) $recentMovements->sum('quantity');
                        @endphp

                        @foreach($recentMovements as $movement)
                            @php
                                $createdAt = $movement->created_at instanceof \Carbon\Carbon 
                                    ? $movement->created_at 
                                    : \Carbon\Carbon::parse($movement->created_at);
                                
                                $currentQty = (float) ($movement->quantity ?? 0);
                                $pct = ($totalMovementQty > 0) ? min(100, round(($currentQty / $totalMovementQty) * 100, 1)) : 0;
                                
                                $type = strtolower($movement->type ?? '');
                                $isStockIn = $type === 'in';
                                $isStockOut = $type === 'out';
                                
                                $badgeClass = $isStockIn 
                                    ? 'bg-emerald-50 text-emerald-700 border-emerald-200' 
                                    : ($isStockOut ? 'bg-rose-50 text-rose-700 border-rose-200' : 'bg-amber-50 text-amber-700 border-amber-200');
                                    
                                $barClass = $isStockIn 
                                    ? 'bg-emerald-500' 
                                    : ($isStockOut ? 'bg-rose-500' : 'bg-amber-500');
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors font-sans">
                                <td class="px-4 py-3 font-medium text-slate-800 text-center font-sans">{{ $movement->product_name }}</td>
                                <td class="px-4 py-3 text-center font-sans">
                                    @if($isStockIn)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            {{ __('IN') }}
                                        </span>
                                    @elseif($isStockOut)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            {{ __('OUT') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            {{ __(ucfirst($movement->type)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center font-sans font-semibold text-slate-700">{{ formatNumber($movement->quantity) }}</td>
                                
                                <td class="px-4 py-3 text-center font-sans">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-16 sm:w-20 bg-slate-100 rounded-full h-2 overflow-hidden border border-slate-200 shrink-0">
                                            <div class="h-2 rounded-full transition-all duration-500 {{ $barClass }}" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="inline-flex items-center min-w-[50px] justify-center px-2 py-0.5 rounded-md text-xs font-semibold border {{ $badgeClass }}">
                                            {{ formatNumber(number_format($pct, 1)) }}%
                                        </span>
                                    </div>
                                </td>

                                <td class="px-4 py-3 font-sans text-slate-500 text-center text-xs">
                                    {{ formatNumber($createdAt->format('d')) }} 
                                    {{ __($createdAt->format('M')) }} 
                                    {{ formatNumber($createdAt->format('Y')) }}, 
                                    {{ formatNumber($createdAt->format('h:i')) }} 
                                    {{ __($createdAt->format('A')) }}
                                </td>
                                <td class="px-4 py-3 font-sans text-slate-600 text-center font-medium">{{ $movement->user_name ?? '—' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate-400 font-sans">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <span>{{ __('No recent movements recorded.') }}</span>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const appFont = window.getComputedStyle(document.body).fontFamily || 'sans-serif';

            // Stock Movement Bar Chart
            const ctxMovement = document.getElementById('stockMovementChart').getContext('2d');
            
            const rawLabels = @json($stockLabels ?? []);
            const translatedLabels = rawLabels.map(label => {
                const map = {
                    'Mon': "{{ __('Mon') }}",
                    'Tue': "{{ __('Tue') }}",
                    'Wed': "{{ __('Wed') }}",
                    'Thu': "{{ __('Thu') }}",
                    'Fri': "{{ __('Fri') }}",
                    'Sat': "{{ __('Sat') }}",
                    'Sun': "{{ __('Sun') }}"
                };
                return map[label] || label;
            });

            new Chart(ctxMovement, {
                type: 'bar',
                data: {
                    labels: translatedLabels,
                    datasets: [
                        {
                            label: "{{ __('Stock In') }}",
                            data: @json($stockInData ?? []),
                            backgroundColor: 'rgba(59, 130, 246, 0.7)',
                            borderColor: '#3b82f6',
                            borderWidth: 1,
                            borderRadius: 4,
                        },
                        {
                            label: "{{ __('Stock Out') }}",
                            data: @json($stockOutData ?? []),
                            backgroundColor: 'rgba(239, 68, 68, 0.7)',
                            borderColor: '#ef4444',
                            borderWidth: 1,
                            borderRadius: 4,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                usePointStyle: true,
                                pointStyle: 'rectRounded',
                                font: { family: appFont, weight: '500', size: 12 },
                                padding: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(226, 232, 240, 0.8)' },
                            ticks: { font: { family: appFont, weight: '500' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: appFont, weight: '500' } }
                        }
                    }
                }
            });

            // Category Doughnut Chart
            const ctxCategory = document.getElementById('categoryRatioChart').getContext('2d');
            const categoryLabels = @json($categoryLabels ?? []);
            const categoryData = @json($categoryData ?? []);
            const colors = ['#6366f1', '#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#06b6d4', '#f43f5e'];

            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels.length ? categoryLabels : ["{{ __('No categories') }}"],
                    datasets: [{
                        data: categoryData.length ? categoryData : [1],
                        backgroundColor: categoryLabels.length 
                            ? categoryLabels.map((_, i) => colors[i % colors.length]) 
                            : ['#e2e8f0'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: { family: appFont, weight: '500', size: 11 },
                                padding: 12
                            }
                        }
                    },
                    cutout: '72%'
                }
            });
        });
    </script>
</x-app-layout>