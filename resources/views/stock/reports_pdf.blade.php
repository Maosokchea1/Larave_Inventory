<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Stock Movement Report</title>
    <style>
        @page {
            margin: 12mm 10mm 12mm 10mm;
        }
        body { 
            font-family: sans-serif; 
            font-size: 9pt; 
            color: #1e293b; 
            margin: 0;
            padding: 0;
        }
        .header { 
            text-align: center; 
            margin-bottom: 12px; 
            border-bottom: 2px solid #1e293b;
            padding-bottom: 6px;
        }
        .header h2 {
            margin: 0 0 4px 0;
            font-size: 15pt;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header small {
            color: #64748b;
            font-size: 8pt;
        }
        
        /* Valuation Bar */
        .valuation-bar {
            margin-bottom: 10px;
            font-size: 9.5pt;
        }

        /* Summary Table Styling */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .summary-table th {
            background-color: #334155;
            color: #ffffff;
            font-size: 8.5pt;
            padding: 5px;
            border: 1px solid #cbd5e1;
            text-align: center;
            text-transform: uppercase;
        }
        .summary-table td {
            border: 1px solid #cbd5e1;
            padding: 6px;
            font-size: 9pt;
            font-weight: bold;
            text-align: center;
            background-color: #f8fafc;
        }

        /* Main Table Styling */
        .main-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px; 
        }
        .main-table th, .main-table td { 
            border: 1px solid #cbd5e1; 
            padding: 5px 7px; 
            font-size: 8.5pt; 
        }
        .main-table th { 
            background-color: #1e293b; 
            color: #ffffff; 
            text-align: center;
            text-transform: uppercase;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bg-total {
            background-color: #e2e8f0;
            font-weight: bold;
        }

        /* Text Color Styles for Types */
        .type-in { color: #16a34a; font-weight: bold; }
        .type-out { color: #dc2626; font-weight: bold; }
        .type-adj { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Stock Movement Report</h2>
        <small>Generated: {{ date('Y-m-d H:i') }}</small>
    </div>

    <div class="valuation-bar">
        <strong>Total Inventory Valuation:</strong> ${{ number_format($totalValuation, 2) }}
    </div>

    @php
        // គណនាផលបូកសរុបតាមប្រភេទនីមួយៗ (Case-insensitive)
        $sumIn = $transactions->filter(fn($t) => strtolower($t->type) === 'in')->sum('quantity');
        $sumOut = $transactions->filter(fn($t) => strtolower($t->type) === 'out')->sum('quantity');
        $sumAdj = $transactions->filter(fn($t) => strtolower($t->type) === 'adjustment')->sum('quantity');
        $totalQuantity = $transactions->sum('quantity');
    @endphp

    <!-- តារាងសង្ខេបបូកសរុបតាម Stock In, Stock Out, និង Adjustment -->
    <table class="summary-table">
        <thead>
            <tr>
                <th>Stock In ( Total )</th>
                <th>Stock Out ( Total )</th>
                <th>Adjustment ( Total )</th>
                <th>Grand Total Qty</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="type-in">+{{ number_format($sumIn) }}</td>
                <td class="type-out">-{{ number_format($sumOut) }}</td>
                <td class="type-adj">{{ number_format($sumAdj) }}</td>
                <td>{{ number_format($totalQuantity) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- តារាងលម្អិតប្រតិបត្តិការ -->
    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 15%;">Date</th>
                <th style="width: 12%;">Type</th>
                <th style="width: 33%;">Product Name</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 18%;">Note</th>
                <th style="width: 12%;">User</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                @php
                    $typeLower = strtolower($trx->type);
                    $typeClass = match($typeLower) {
                        'in' => 'type-in',
                        'out' => 'type-out',
                        'adjustment' => 'type-adj',
                        default => ''
                    };
                @endphp
                <tr>
                    <td class="text-center">{{ optional($trx->created_at)->format('Y-m-d H:i') ?? '-' }}</td>
                    <td class="text-center {{ $typeClass }}">{{ strtoupper($trx->type) }}</td>
                    <td>{{ optional($trx->product)->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ number_format($trx->quantity) }}</td>
                    <td>{{ $trx->note ?? '-' }}</td>
                    <td class="text-center">{{ optional($trx->user)->name ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #64748b;">
                        No data available.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if($transactions->count() > 0)
        <tfoot>
            <tr class="bg-total">
                <td colspan="3" class="text-right"><strong>TOTAL QUANTITY:</strong></td>
                <td class="text-right"><strong>{{ number_format($totalQuantity) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
        @endif
    </table>

</body>
</html>