<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Notifications\StatusTransaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $transaksi = $query->latest()->paginate(15);
        $statuses  = Transaction::$statuses;

        return view('admin.transactions.index', compact('transaksi', 'statuses'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('items.product', 'user');
        $statuses = Transaction::$statuses;
        return view('admin.transactions.show', compact('transaction', 'statuses'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status'      => 'required|in:pending,approved,completed,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $transaction->status;

        $data = [
            'status'      => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        if ($request->status === 'approved' && $oldStatus !== 'approved') {
            $data['approved_at'] = now();
        }

        // Kembalikan stok jika ditolak
        if ($request->status === 'rejected' && $oldStatus !== 'rejected') {
            foreach ($transaction->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->qty);
                }
            }
        }

        $transaction->update($data);

        // Kirim notifikasi ke user
        $transaction->user->notify(new StatusTransaksi($transaction));

        return redirect('/admin/transaksi')
            ->with('success', '✅ Status transaksi berhasil diubah!');
    }
}