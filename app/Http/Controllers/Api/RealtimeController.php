<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RealtimeController extends Controller
{
    /**
     * Get menu updates (stock, price, etc) for real-time sync
     */
    public function getMenuUpdates(Request $request)
    {
        $lastCheck = $request->input('last_check', now()->subMinutes(5)->toDateTimeString());
        
        // Get menus that were updated after last check
        $updatedMenus = Menu::where('updated_at', '>', $lastCheck)
            ->where('is_active', true)
            ->select('id', 'name', 'stock', 'price', 'is_active', 'updated_at')
            ->get();
        
        return response()->json([
            'success' => true,
            'menus' => $updatedMenus,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    /**
     * Get new orders for admin real-time sync
     */
    public function getNewOrders(Request $request)
    {
        $lastCheck = $request->input('last_check', now()->subMinutes(5)->toDateTimeString());
        $status = $request->input('status', 'all');
        
        $query = Order::with(['user', 'details.menu', 'payment'])
            ->where(function($q) use ($lastCheck) {
                $q->where('created_at', '>', $lastCheck)
                  ->orWhere('updated_at', '>', $lastCheck);
            });
        
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        $newOrders = $query->latest('order_date')->get();
        
        // Format orders for response
        $formattedOrders = $newOrders->map(function($order) {
            return [
                'id' => $order->id,
                'user_name' => $order->user->name,
                'user_email' => $order->user->email,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'created_at' => $order->created_at->toDateTimeString(),
                'updated_at' => $order->updated_at->toDateTimeString(),
                'item_count' => $order->details->count(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'orders' => $formattedOrders,
            'count' => $newOrders->count(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    /**
     * Get all orders count for admin (to detect new orders)
     */
    public function getOrdersCount(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');
        
        $query = Order::with(['user']);
        
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $totalCount = $query->count();
        $latestOrder = Order::latest('order_date')->first();
        
        return response()->json([
            'success' => true,
            'total_count' => $totalCount,
            'latest_order_id' => $latestOrder ? $latestOrder->id : null,
            'latest_order_created_at' => $latestOrder ? $latestOrder->created_at->toDateTimeString() : null,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    /**
     * Get review updates for real-time sync (for menu detail page)
     */
    public function getReviewUpdates(Request $request)
    {
        $menuId = $request->input('menu_id');
        $lastCheck = $request->input('last_check', now()->subMinutes(5)->toDateTimeString());
        
        if (!$menuId) {
            return response()->json([
                'success' => false,
                'message' => 'Menu ID is required'
            ], 400);
        }
        
        // Get reviews that were updated after last check for this menu
        $query = Review::where('menu_id', $menuId)
            ->where(function($q) use ($lastCheck) {
                $q->where('created_at', '>', $lastCheck)
                  ->orWhere('updated_at', '>', $lastCheck);
            })
            ->with(['user:id,name'])
            ->select('id', 'user_id', 'menu_id', 'rating', 'comment', 'status', 'created_at', 'updated_at');
        
        // For authenticated users, include their pending reviews
        // For non-authenticated, only approved reviews
        if (auth()->check()) {
            $query->where(function($q) {
                $q->where('status', 'approved')
                  ->orWhere(function($subQ) {
                      $subQ->where('status', 'pending')
                           ->where('user_id', auth()->id());
                  });
            });
        } else {
            $query->where('status', 'approved');
        }
        
        $updatedReviews = $query->latest()->get();
        
        // Format reviews for response
        $formattedReviews = $updatedReviews->map(function($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'status' => $review->status,
                'created_at' => $review->created_at->toDateTimeString(),
                'updated_at' => $review->updated_at->toDateTimeString(),
                'is_own_review' => auth()->check() && auth()->id() === $review->user_id
            ];
        });
        
        // Get deleted review IDs (reviews that were rejected/deleted)
        $deletedReviewIds = Cache::get("deleted_reviews_menu_{$menuId}", []);
        
        return response()->json([
            'success' => true,
            'reviews' => $formattedReviews,
            'deleted_review_ids' => $deletedReviewIds,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}

