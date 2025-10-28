<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart;
        
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }
        
        $cartItems = $cart->items()->with('menu')->get();
        $total = $cartItems->sum('subtotal');
        $totalQuantity = $cartItems->sum('quantity');
        
        return view('cart.index', compact('cartItems', 'total', 'totalQuantity'));
    }

    public function add(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);

            $menu = Menu::findOrFail($request->menu_id);
            $quantity = (int) $request->quantity ?? 1;
            $notes = $request->notes ?? '';
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
                    'notes' => $notes,
                ]);
            }

            // Get updated cart count
            $cartCount = $cart->items()->sum('quantity');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Menu berhasil ditambahkan ke keranjang',
                    'cart_count' => $cartCount,
                    'menu_name' => $menu->name
                ]);
            }

            return back()->with('success', 'Ditambahkan ke keranjang');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan ke keranjang: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menambahkan ke keranjang');
        }
    }

    public function update(Request $request, $itemId)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;
            
            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Keranjang tidak ditemukan'], 404);
            }
            
            $item = $cart->items()->findOrFail($itemId);
            $quantity = (int) $request->quantity;
            $notes = $request->notes ?? '';
            
            if ($quantity <= 0) {
                $item->delete();
            } else {
                $item->quantity = $quantity;
                $item->subtotal = $item->menu->price * $quantity;
                $item->notes = $notes;
                $item->save();
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function remove(Request $request, $itemId)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;
            
            if (!$cart) {
                return response()->json(['success' => false, 'message' => 'Keranjang tidak ditemukan'], 404);
            }
            
            $item = $cart->items()->findOrFail($itemId);
            $item->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    public function clear(Request $request)
    {
        try {
            $user = $request->user();
            $cart = $user->cart;
            
            if ($cart) {
                $cart->items()->delete();
            }
            
            return response()->json(['success' => true, 'message' => 'Keranjang berhasil dikosongkan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}