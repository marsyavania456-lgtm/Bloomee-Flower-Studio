<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksi = auth()->user()->transactions()->with('items')->latest()->paginate(10);
        return view('transactions.index', compact('transaksi'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $transaction->load('items.product', 'user');
        return view('transactions.show', compact('transaction'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:transfer,cod,qris',
            'notes'          => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', '❌ Keranjang kamu kosong!');
        }

        $items = [];
        $total = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if (!$product || !$product->is_active) {
                return redirect('/cart')->with('error', '❌ Produk tidak tersedia: ' . ($product->name ?? $productId));
            }
            if ($product->stock < $qty) {
                return redirect('/cart')->with('error', '❌ Stok tidak mencukupi untuk: ' . $product->name);
            }

            $subtotal = $product->price * $qty;
            $items[]  = [
                'product'      => $product,
                'product_name' => $product->name,
                'qty'          => $qty,
                'price'        => $product->price,
                'subtotal'     => $subtotal,
            ];
            $total += $subtotal;
        }

        // Buat transaksi
        $transaction = Transaction::create([
            'invoice_number' => Transaction::generateInvoice(),
            'user_id'        => auth()->id(),
            'total'          => $total,
            'status'         => 'pending',
            'payment_method' => $request->payment_method,
            'notes'          => $request->notes,
        ]);

        // Buat item & kurangi stok
        foreach ($items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $item['product']->id,
                'product_name'   => $item['product_name'],
                'qty'            => $item['qty'],
                'price'          => $item['price'],
                'subtotal'       => $item['subtotal'],
            ]);

            $item['product']->decrement('stock', $item['qty']);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect('/transaksi/' . $transaction->id)
            ->with('success', '🌸 Pesanan berhasil dibuat! Invoice: ' . $transaction->invoice_number);
    }

    public function cetak(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $transaction->load('items', 'user');
        return view('transactions.cetak', compact('transaction'));
    }

    // Tandai notifikasi sebagai terbaca
    public function readNotification($id)
    {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return back();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi dibaca!');
    }
}