<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

        $menu = Menu::findOrFail($request->menu_id);
        $quantity = (int) $request->quantity;
        $subtotal = $menu->price * $quantity;

        // Cek apakah item sudah ada di cart
        $item = $cart->items()->where('menu_id', $menu->id)->first();

        if ($item) {
            // Update quantity dan subtotal
            $item->quantity += $quantity;
            $item->subtotal += $subtotal;
            $item->save();
        } else {
            // Buat item baru
            $cart->items()->create([
                'menu_id' => $menu->id,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }

        return back()->with('success', 'Ditambahkan ke keranjang');
    }
}