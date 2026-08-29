<?php

namespace App\Exports;

use App\Models\StockTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StockTransactionsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = StockTransaction::with(['product', 'supplier', 'user']);

        // ត្រងតាមប្រភេទចលនា (Type)
        if ($this->request->filled('type')) {
            $query->where('type', $this->request->type);
        }

        // ត្រងតាមផលិតផល (Product ID)
        if ($this->request->filled('product_id')) {
            $query->where('product_id', $this->request->product_id);
        }

        // ត្រងតាមកាលបរិច្ឆេទចាប់ពីថ្ងៃទី (Date From)
        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        // ត្រងតាមកាលបរិច្ឆេទដល់ថ្ងៃទី (Date To)
        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Date',
            'Type',
            'Product Name',
            'Quantity',
            'Note / Details',
            'User'
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->created_at->format('Y-m-d H:i'),
            strtoupper($transaction->type),
            $transaction->product->name ?? 'N/A',
            $transaction->quantity,
            $transaction->note ?? '-',
            $transaction->user->name ?? 'N/A'
        ];
    }
}