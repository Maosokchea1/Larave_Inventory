<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\StockTransaction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use Barryvdh\DomPDF\Facade\Pdf;

class StockReportController extends Controller
{
    // ១. បង្ហាញទំព័ររបាយការណ៍ស្តុកសរុប និងប្រវត្តិប្រតិបត្តិការ
    public function index(Request $request)
    {
        $allProductsList = Product::all();

        $totalValuation = $allProductsList->sum(function ($p) {
            $cost = $p->cost ?? $p->cost_price ?? $p->unit_price ?? $p->purchase_price ?? $p->Cost ?? 0;
            $stock = $p->stock ?? $p->quantity ?? $p->qty ?? $p->current_stock ?? $p->stock_quantity ?? 0;
            return $cost * $stock;
        });

        $query = StockTransaction::with(['product', 'supplier', 'user'])->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $metricsQuery = clone $query;
        $chartTransactions = $metricsQuery->get();

        $transactions = $query->paginate(15)->withQueryString();

        $products = $allProductsList;
        $allProducts = $allProductsList;

        $counts = (clone $query)->reorder()->selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN LOWER(type) = 'in' THEN 1 ELSE 0 END) as in_count,
            SUM(CASE WHEN LOWER(type) = 'out' THEN 1 ELSE 0 END) as out_count,
            SUM(CASE WHEN LOWER(type) = 'adjustment' THEN 1 ELSE 0 END) as adjustment_count,
            SUM(CASE WHEN LOWER(type) = 'transfer' THEN 1 ELSE 0 END) as transfer_count
        ")->first();

        $totalTransactions = $counts->total ?? 0;

        $stockInPercent    = $totalTransactions > 0 ? round(($counts->in_count / $totalTransactions) * 100) : 0;
        $stockOutPercent   = $totalTransactions > 0 ? round(($counts->out_count / $totalTransactions) * 100) : 0;
        $adjustmentPercent = $totalTransactions > 0 ? round(($counts->adjustment_count / $totalTransactions) * 100) : 0;
        $transferPercent   = $totalTransactions > 0 ? round(($counts->transfer_count / $totalTransactions) * 100) : 0;

        return view('stock.reports', compact(
            'totalValuation', 
            'transactions', 
            'chartTransactions',
            'products',
            'allProducts',
            'stockInPercent',
            'stockOutPercent',
            'adjustmentPercent',
            'transferPercent'
        ));
    }

    // ៤. មុខងារសម្រាប់ Export ទិន្នន័យចេញជា Excel
    public function exportExcel(Request $request)
    {
        $query = StockTransaction::with(['product', 'user']);
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->get();

        $summaryData = [
            'in'         => ['qty' => 0, 'logs' => 0],
            'out'        => ['qty' => 0, 'logs' => 0],
            'adjustment' => ['qty' => 0, 'logs' => 0],
            'transfer'   => ['qty' => 0, 'logs' => 0],
        ];

        foreach ($transactions as $trx) {
            $type = strtolower($trx->type);
            if (isset($summaryData[$type])) {
                $summaryData[$type]['qty'] += $trx->quantity;
                $summaryData[$type]['logs'] += 1;
            }
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Stock Reports');
        $sheet->setShowGridLines(true);

        $mainHeaders = ['Date', 'Type', 'Product Name', 'Quantity', 'Note / Details', 'User'];
        $sheet->fromArray($mainHeaders, NULL, 'A1');

        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1E293B']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allborders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]
            ]
        ]);
        $sheet->getRowDimension(1)->setRowHeight(25);

        $rowNum = 2;
        foreach ($transactions as $trx) {
            if (!is_object($trx)) continue;

            $sheet->setCellValue('A' . $rowNum, optional($trx->created_at)->format('Y-m-d H:i') ?? '-');
            $sheet->setCellValue('B' . $rowNum, strtoupper($trx->type));
            $sheet->setCellValue('C' . $rowNum, optional($trx->product)->name ?? 'N/A');
            $sheet->setCellValue('D' . $rowNum, $trx->quantity);
            $sheet->setCellValue('E' . $rowNum, $trx->note ?? '-');
            $sheet->setCellValue('F' . $rowNum, optional($trx->user)->name ?? 'N/A');
            
            $sheet->getRowDimension($rowNum)->setRowHeight(20);
            $rowNum++;
        }

        $lastMainRow = max(2, $rowNum - 1);

        $sheet->getStyle("A2:A{$lastMainRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B2:B{$lastMainRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("D2:D{$lastMainRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $sheet->getStyle("A1:F{$lastMainRow}")->applyFromArray([
            'borders' => [
                'allborders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]
            ]
        ]);

        $summaryStartRow = $lastMainRow + 3;

        $sheet->setCellValue("A{$summaryStartRow}", 'Movement Type');
        $sheet->setCellValue("B{$summaryStartRow}", 'Total Quantity');
        $sheet->setCellValue("C{$summaryStartRow}", 'TOTAL LOGS');

        $sheet->getStyle("A{$summaryStartRow}:C{$summaryStartRow}")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '334155'], 'size' => 10],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E2E8F0']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allborders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '94A3B8']]
            ]
        ]);

        $summaryRows = [
            ['label' => 'IN', 'key' => 'in'],
            ['label' => 'OUT', 'key' => 'out'],
            ['label' => 'ADJUSTMENT', 'key' => 'adjustment'],
            ['label' => 'TRANSFER', 'key' => 'transfer'],
        ];

        $sRow = $summaryStartRow + 1;
        foreach ($summaryRows as $s) {
            $sheet->setCellValue("A{$sRow}", $s['label']);
            $sheet->setCellValue("B{$sRow}", $summaryData[$s['key']]['qty']);
            $sheet->setCellValue("C{$sRow}", $summaryData[$s['key']]['logs']);
            $sRow++;
        }

        $lastSummaryRow = $sRow - 1;

        $sheet->getStyle("A" . ($summaryStartRow + 1) . ":A{$lastSummaryRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("B" . ($summaryStartRow + 1) . ":C{$lastSummaryRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet->getStyle("A{$summaryStartRow}:C{$lastSummaryRow}")->applyFromArray([
            'borders' => [
                'allborders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]
            ],
            'font' => ['size' => 10, 'bold' => true]
        ]);

        // CHARTS SETUP
        $barStartRow = $lastSummaryRow + 3;
        $barDataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Stock Reports'!\$B\${$summaryStartRow}", null, 1),
        ];
        $barXAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Stock Reports'!\$A\$" . ($summaryStartRow + 1) . ":\$A\$" . ($summaryStartRow + 4), null, 4),
        ];
        $barDataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'Stock Reports'!\$B\$" . ($summaryStartRow + 1) . ":\$B\$" . ($summaryStartRow + 4), null, 4),
        ];

        $barSeries = new DataSeries(
            DataSeries::TYPE_BARCHART,
            DataSeries::GROUPING_STANDARD,
            range(0, count($barDataSeriesValues) - 1),
            $barDataSeriesLabels,
            $barXAxisTickValues,
            $barDataSeriesValues
        );
        $barSeries->setPlotDirection(DataSeries::DIRECTION_COL);

        $barPlotArea = new PlotArea(null, [$barSeries]);
        $barLegend = new Legend(Legend::POSITION_RIGHT, null, false);
        $barTitle = new Title('Stock Movement Quantities');

        $barChart = new Chart(
            'stock_bar_chart',
            $barTitle,
            $barLegend,
            $barPlotArea,
            true,
            DataSeries::EMPTY_AS_GAP,
            null,
            null
        );
        $barChart->setTopLeftCell("A{$barStartRow}");
        $barChart->setBottomRightCell("F" . ($barStartRow + 14));
        $sheet->addChart($barChart);

        $pieStartRow = $barStartRow + 16;
        $pieDataSeriesLabels = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Stock Reports'!\$B\${$summaryStartRow}", null, 1),
        ];
        $pieXAxisTickValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'Stock Reports'!\$A\$" . ($summaryStartRow + 1) . ":\$A\$" . ($summaryStartRow + 4), null, 4),
        ];
        $pieDataSeriesValues = [
            new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'Stock Reports'!\$B\$" . ($summaryStartRow + 1) . ":\$B\$" . ($summaryStartRow + 4), null, 4),
        ];

        $pieSeries = new DataSeries(
            DataSeries::TYPE_PIECHART,
            null,
            range(0, count($pieDataSeriesValues) - 1),
            $pieDataSeriesLabels,
            $pieXAxisTickValues,
            $pieDataSeriesValues
        );

        $piePlotArea = new PlotArea(null, [$pieSeries]);
        $pieLegend = new Legend(Legend::POSITION_RIGHT, null, false);
        $pieTitle = new Title('Stock Movement Proportion');

        $pieChart = new Chart(
            'stock_pie_chart',
            $pieTitle,
            $pieLegend,
            $piePlotArea,
            true,
            DataSeries::EMPTY_AS_GAP,
            null,
            null
        );
        $pieChart->setTopLeftCell("A{$pieStartRow}");
        $pieChart->setBottomRightCell("F" . ($pieStartRow + 14));
        $sheet->addChart($pieChart);

        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $pageSetup = $sheet->getPageSetup();
        $pageSetup->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
        $pageSetup->setPaperSize(PageSetup::PAPERSIZE_A4);
        $pageSetup->setFitToPage(true);
        $pageSetup->setFitToWidth(1);
        $pageSetup->setFitToHeight(0);
        
        $maxPrintRow = $pieStartRow + 14;
        $pageSetup->setPrintArea("A1:F{$maxPrintRow}");

        $pageMargins = $sheet->getPageMargins();
        $pageMargins->setTop(0.2);
        $pageMargins->setBottom(0.2);
        $pageMargins->setLeft(0.2);
        $pageMargins->setRight(0.2);

        $filename = 'stock-movement-reports-' . date('Y-m-d') . '.xlsx';
        
        return response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->setIncludeCharts(true);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    // ៥. មុខងារសម្រាប់ Export ទិន្នន័យចេញជា PDF
    public function pdf(Request $request)
    {
        $query = StockTransaction::with(['product', 'supplier', 'user']);
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->latest()->get();
        
        $totalValuation = Product::all()->sum(function ($p) {
            $cost = $p->cost ?? $p->cost_price ?? $p->unit_price ?? $p->purchase_price ?? $p->Cost ?? 0;
            $stock = $p->stock ?? $p->quantity ?? $p->qty ?? $p->current_stock ?? $p->stock_quantity ?? 0;
            return $cost * $stock;
        });

        // Search for existing view files dynamically
        $possibleViews = ['stock.reports-pdf', 'stock.report-pdf', 'stock.pdf', 'reports-pdf'];
        $selectedView = null;

        foreach ($possibleViews as $v) {
            if (view()->exists($v)) {
                $selectedView = $v;
                break;
            }
        }

        if ($selectedView) {
            $pdf = Pdf::loadView($selectedView, compact('transactions', 'totalValuation'));
        } else {
            // គណនាផលបូកសរុបតាមប្រភេទនីមួយៗសម្រាប់ Fallback HTML
            $sumIn = $transactions->filter(fn($t) => strtolower($t->type) === 'in')->sum('quantity');
            $sumOut = $transactions->filter(fn($t) => strtolower($t->type) === 'out')->sum('quantity');
            $sumAdj = $transactions->filter(fn($t) => strtolower($t->type) === 'adjustment')->sum('quantity');
            $totalQuantity = $transactions->sum('quantity');

            // Construct table rows
            $rows = '';
            foreach ($transactions as $trx) {
                $date = optional($trx->created_at)->format('Y-m-d H:i') ?? '-';
                $type = strtoupper($trx->type);
                $typeLower = strtolower($trx->type);
                $productName = htmlspecialchars(optional($trx->product)->name ?? 'N/A');
                $qty = number_format($trx->quantity);
                $note = htmlspecialchars($trx->note ?? '-');
                $userName = htmlspecialchars(optional($trx->user)->name ?? 'N/A');

                $color = match($typeLower) {
                    'in' => '#16a34a',
                    'out' => '#dc2626',
                    'adjustment' => '#d97706',
                    default => '#1e293b'
                };

                $rows .= "<tr>
                    <td style='border: 1px solid #cbd5e1; padding: 5px; text-align: center;'>{$date}</td>
                    <td style='border: 1px solid #cbd5e1; padding: 5px; text-align: center; color: {$color}; font-weight: bold;'>{$type}</td>
                    <td style='border: 1px solid #cbd5e1; padding: 5px;'>{$productName}</td>
                    <td style='border: 1px solid #cbd5e1; padding: 5px; text-align: right;'>{$qty}</td>
                    <td style='border: 1px solid #cbd5e1; padding: 5px;'>{$note}</td>
                    <td style='border: 1px solid #cbd5e1; padding: 5px; text-align: center;'>{$userName}</td>
                </tr>";
            }

            if ($transactions->isEmpty()) {
                $rows = "<tr><td colspan='6' style='text-align: center; padding: 12px; color: #64748b;'>No data available.</td></tr>";
            }

            $formattedValuation = number_format($totalValuation, 2);
            $formattedIn = number_format($sumIn);
            $formattedOut = number_format($sumOut);
            $formattedAdj = number_format($sumAdj);
            $formattedTotalQty = number_format($totalQuantity);
            $now = date('Y-m-d H:i');

            $html = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
                <title>Stock Movement Report</title>
                <style>
                    @page { margin: 12mm 10mm; }
                    body { font-family: sans-serif; font-size: 9pt; color: #1e293b; margin: 0; padding: 0; }
                    .header { text-align: center; margin-bottom: 12px; border-bottom: 2px solid #1e293b; padding-bottom: 6px; }
                    .header h2 { margin: 0 0 4px 0; font-size: 15pt; text-transform: uppercase; }
                    .summary-table, .main-table { width: 100%; border-collapse: collapse; }
                    .summary-table th { background-color: #334155; color: #fff; font-size: 8.5pt; padding: 5px; border: 1px solid #cbd5e1; text-align: center; }
                    .summary-table td { border: 1px solid #cbd5e1; padding: 6px; font-size: 9pt; font-weight: bold; text-align: center; background-color: #f8fafc; }
                    .main-table th { background-color: #1e293b; color: #ffffff; padding: 6px; border: 1px solid #cbd5e1; font-size: 8.5pt; text-transform: uppercase; }
                    .bg-total { background-color: #e2e8f0; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='header'>
                    <h2>Stock Movement Report</h2>
                    <small style='color:#64748b;'>Generated: {$now}</small>
                </div>
                <div style='margin-bottom: 10px;'>
                    <strong>Total Inventory Valuation:</strong> \${$formattedValuation}
                </div>

                <table class='summary-table' style='margin-bottom: 15px;'>
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
                            <td style='color: #16a34a;'>+{$formattedIn}</td>
                            <td style='color: #dc2626;'>-{$formattedOut}</td>
                            <td style='color: #d97706;'>{$formattedAdj}</td>
                            <td>{$formattedTotalQty}</td>
                        </tr>
                    </tbody>
                </table>

                <table class='main-table'>
                    <thead>
                        <tr>
                            <th style='width: 15%;'>Date</th>
                            <th style='width: 12%;'>Type</th>
                            <th style='width: 33%;'>Product Name</th>
                            <th style='width: 10%;'>Quantity</th>
                            <th style='width: 18%;'>Note</th>
                            <th style='width: 12%;'>User</th>
                        </tr>
                    </thead>
                    <tbody>{$rows}</tbody>
                    <tfoot>
                        <tr class='bg-total'>
                            <td colspan='3' style='border: 1px solid #cbd5e1; padding: 5px; text-align: right;'><strong>TOTAL QUANTITY:</strong></td>
                            <td style='border: 1px solid #cbd5e1; padding: 5px; text-align: right;'><strong>{$formattedTotalQty}</strong></td>
                            <td colspan='2' style='border: 1px solid #cbd5e1;'></td>
                        </tr>
                    </tfoot>
                </table>
            </body>
            </html>";

            $pdf = Pdf::loadHTML($html);
        }

        $pdf->setPaper('a4', 'portrait')
            ->setOptions([
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'chroot' => public_path(),
                'defaultFont' => 'sans-serif',
                'isFontSubsettingEnabled' => true,
            ]);

        return $pdf->download('stock-movement-report-' . date('Y-m-d') . '.pdf');
    }
}