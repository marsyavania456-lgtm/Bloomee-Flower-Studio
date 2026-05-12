<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user', 'items');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->whereHas('items.product', fn($q) => $q->where('category', $request->category));
        }

        $transaksi        = $query->latest()->paginate(15)->withQueryString();
        $totalPendapatan  = (clone $query)->whereIn('status', ['approved', 'completed'])->sum('total');
        $totalTransaksi   = (clone $query)->count();
        $totalApproved    = (clone $query)->whereIn('status', ['approved', 'completed'])->count();
        $totalPending     = (clone $query)->where('status', 'pending')->count();
        $statuses         = Transaction::$statuses;
        $categories       = \App\Models\Product::$categories;

        return view('laporan.index', compact(
            'transaksi', 'totalPendapatan', 'totalTransaksi',
            'totalApproved', 'totalPending', 'statuses', 'categories'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new LaporanExport($request->all()), 'laporan-bloomee-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with('user', 'items');

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('created_at', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transaksi       = $query->latest()->get();
        $totalPendapatan = $transaksi->whereIn('status', ['approved', 'completed'])->sum('total');

        $pdf = Pdf::loadView('laporan.pdf', compact('transaksi', 'totalPendapatan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-bloomee-' . now()->format('Y-m-d') . '.pdf');
    }
}