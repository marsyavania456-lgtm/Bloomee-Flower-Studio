<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(): array
    {
        return session()->get('cart', []);
    }

    private function saveCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function index()
    {
        $cart    = $this->getCart();
        $items   = [];
        $total   = 0;

        foreach ($cart as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $qty;
                $items[]  = ['product' => $product, 'qty' => $qty, 'subtotal' => $subtotal];
                $total   += $subtotal;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        if ($product->stock < $request->qty) {
            return back()->with('error', '❌ Stok tidak mencukupi!');
        }

        $cart = $this->getCart();
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $request->qty;

        // Cek total tidak melebihi stok
        if ($cart[$product->id] > $product->stock) {
            $cart[$product->id] = $product->stock;
        }

        $this->saveCart($cart);

        return back()->with('success', '🛒 ' . $product->name . ' ditambahkan ke keranjang!');
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['qty' => 'required|integer|min:1']);
        $product = Product::findOrFail($productId);

        $cart = $this->getCart();
        if (isset($cart[$productId])) {
            if ($request->qty > $product->stock) {
                return back()->with('error', '❌ Stok tidak mencukupi!');
            }
            $cart[$productId] = $request->qty;
            $this->saveCart($cart);
        }

        return back()->with('success', '✅ Keranjang diperbarui!');
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        $this->saveCart($cart);

        return back()->with('success', '🗑️ Item dihapus dari keranjang!');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', '🗑️ Keranjang dikosongkan!');
    }

    public function cartCount(): int
    {
        return array_sum($this->getCart());
    }
}