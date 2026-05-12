<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $today = Carbon::today();

        $totalProduk        = Product::count();
        $totalUser          = User::where('role', 'user')->count();
        $totalTransaksi     = Transaction::count();
        $transaksiPending   = Transaction::where('status', 'pending')->count();
        $transaksiHariIni   = Transaction::whereDate('created_at', $today)->count();
        $pendapatanHariIni  = Transaction::whereDate('created_at', $today)
                                ->whereIn('status', ['approved', 'completed'])->sum('total');
        $pendapatanBulanIni = Transaction::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->whereIn('status', ['approved', 'completed'])->sum('total');
        $pendapatanTotal    = Transaction::whereIn('status', ['approved', 'completed'])->sum('total');

        $transaksiTerbaru = Transaction::with('user')->latest()->take(5)->get();

        // Chart data: transaksi per hari 7 hari terakhir
        $chartLabels = [];
        $chartData   = [];
        for ($i = 6; $i >= 0; $i--) {
            $date          = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[]   = Transaction::whereDate('created_at', $date)->count();
        }

        // Produk terlaris
        $produkTerlaris = \App\Models\TransactionItem::selectRaw('product_id, product_name, SUM(qty) as total_terjual')
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return view('dashboard.admin', compact(
            'totalProduk', 'totalUser', 'totalTransaksi', 'transaksiPending',
            'transaksiHariIni', 'pendapatanHariIni', 'pendapatanBulanIni', 'pendapatanTotal',
            'transaksiTerbaru', 'chartLabels', 'chartData', 'produkTerlaris'
        ));
    }

    private function userDashboard()
    {
        $user = auth()->user();

        $totalOrder     = $user->transactions()->count();
        $orderPending   = $user->transactions()->where('status', 'pending')->count();
        $orderSelesai   = $user->transactions()->where('status', 'completed')->count();
        $totalBelanja   = $user->transactions()->whereIn('status', ['approved', 'completed'])->sum('total');
        $orderTerbaru   = $user->transactions()->with('items')->latest()->take(5)->get();
        $notifikasi     = $user->unreadNotifications()->take(5)->get();

        $produkUnggulan = Product::active()->latest()->take(4)->get();

        return view('dashboard.user', compact(
            'totalOrder', 'orderPending', 'orderSelesai', 'totalBelanja',
            'orderTerbaru', 'notifikasi', 'produkUnggulan'
        ));
    }
}