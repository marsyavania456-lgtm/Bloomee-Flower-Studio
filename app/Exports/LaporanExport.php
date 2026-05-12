<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private array $filters = []) {}

    public function collection()
    {
        $query = Transaction::with('user', 'items');

        if (!empty($this->filters['tanggal_mulai'])) {
            $query->whereDate('created_at', '>=', $this->filters['tanggal_mulai']);
        }
        if (!empty($this->filters['tanggal_akhir'])) {
            $query->whereDate('created_at', '<=', $this->filters['tanggal_akhir']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Invoice',
            'Nama Pembeli',
            'Email',
            'Total (Rp)',
            'Metode Bayar',
            'Status',
            'Catatan User',
            'Catatan Admin',
            'Tanggal Pesan',
            'Tanggal Approve',
        ];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        $statuses = Transaction::$statuses;
        $statusLabel = $statuses[$row->status]['label'] ?? $row->status;

        return [
            $i,
            $row->invoice_number,
            $row->user->name ?? '-',
            $row->user->email ?? '-',
            number_format($row->total, 0, ',', '.'),
            strtoupper($row->payment_method),
            $statusLabel,
            $row->notes ?? '-',
            $row->admin_notes ?? '-',
            $row->created_at->format('d/m/Y H:i'),
            $row->approved_at ? $row->approved_at->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}