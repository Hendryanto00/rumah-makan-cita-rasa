<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use App\Services\ActivityLogger;
use Illuminate\Support\Facades\Auth;

class AdminReviewController extends Controller
{
    public function __construct()
    {
        // Middleware sudah didefinisikan di routes
        // Menggunakan Gate::authorize di setiap method untuk memastikan hanya admin yang bisa akses
    }

    /**
     * Display a listing of all reviews for moderation.
     */
    public function index(Request $request)
    {
        Gate::authorize('moderate', Review::class);
        
        $query = Review::with(['user', 'menu']);

        // Filter by status - hanya filter jika status tidak kosong
        $status = $request->input('status');
        if (!empty($status) && in_array($status, ['pending', 'approved', 'hidden'])) {
            $query->where('status', $status);
        }

        // Search by user name or menu name
        $search = $request->input('search');
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })->orWhereHas('menu', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                });
            });
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'hidden' => Review::where('status', 'hidden')->count(),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Display the specified review.
     */
    public function show(Request $request, $review)
    {
        // Get review by ID (handle both object and ID from route model binding)
        if (is_object($review) && $review instanceof Review) {
            $review = $review;
        } else {
            $review = Review::findOrFail($review);
        }
        
        Gate::authorize('moderate', Review::class);
        
        $review->load(['user', 'menu']);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     */
    public function approve(Request $request, $review)
    {
        // Get review by ID (handle both object and ID from route model binding)
        if (is_object($review) && $review instanceof Review) {
            $review = $review;
        } else {
            $review = Review::findOrFail($review);
        }
        
        Gate::authorize('moderate', Review::class);
        
        $review->update(['status' => 'approved']);
        ActivityLogger::log(
            'Approve Review',
            'reviews',
            $review->id,
            'Menyetujui sebuah ulasan.'
        );
        
        // Clear cache for deleted reviews
        Cache::forget("deleted_reviews_menu_{$review->menu_id}");

        return redirect()->back()
            ->with('success', 'Review berhasil disetujui.');
    }

    /**
     * Hide a review.
     */
    public function hide(Request $request, $review)
    {
        // Get review by ID (handle both object and ID from route model binding)
        if (is_object($review) && $review instanceof Review) {
            $review = $review;
        } else {
            $review = Review::findOrFail($review);
        }
        
        Gate::authorize('moderate', Review::class);
        
        $review->update(['status' => 'hidden']);
        ActivityLogger::log(
            'Sembunyikan Review',
            'reviews',
            $review->id,
            'Menyembunyikan sebuah ulasan.'
        );
        
        // Clear cache for deleted reviews
        Cache::forget("deleted_reviews_menu_{$review->menu_id}");

        return redirect()->back()
            ->with('success', 'Review berhasil disembunyikan.');
    }

    /**
     * Unhide a review (show it again).
     */
    public function unhide(Request $request, $review)
    {
        // Get review by ID (handle both object and ID from route model binding)
        if (is_object($review) && $review instanceof Review) {
            $review = $review;
        } else {
            $review = Review::findOrFail($review);
        }
        
        Gate::authorize('moderate', Review::class);
        
        $review->update(['status' => 'approved']);
        ActivityLogger::log(
            'Tampilkan Review',
            'reviews',
            $review->id,
            'Menampilkan kembali sebuah ulasan.'
        );
        
        // Clear cache for deleted reviews
        Cache::forget("deleted_reviews_menu_{$review->menu_id}");

        return redirect()->back()
            ->with('success', 'Review berhasil ditampilkan kembali.');
    }

    /**
     * Reject a review (delete).
     */
    public function reject(Request $request, $review)
    {
        // Get review by ID (handle both object and ID from route model binding)
        if (is_object($review) && $review instanceof Review) {
            $review = $review;
        } else {
            $review = Review::findOrFail($review);
        }
        
        Gate::authorize('moderate', Review::class);
        
        $menuId = $review->menu_id;
        $reviewId = $review->id;
        
        ActivityLogger::log(
            'Hapus Review',
            'reviews',
            $review->id,
            'Menolak dan menghapus sebuah ulasan.'
        );
        $review->delete();
        
        // Store deleted review ID in cache for real-time sync
        $deletedIds = Cache::get("deleted_reviews_menu_{$menuId}", []);
        $deletedIds[] = $reviewId;
        Cache::put("deleted_reviews_menu_{$menuId}", $deletedIds, now()->addMinutes(10));

        return redirect()->back()
            ->with('success', 'Review berhasil ditolak dan dihapus.');
    }

    /**
     * Bulk actions for multiple reviews.
     */
    public function bulkAction(Request $request)
    {
        Gate::authorize('moderate', Review::class);
        
        $request->validate([
            'action' => 'required|in:approve,hide,unhide,reject',
            'review_ids' => 'required|array|min:1',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        $reviewIds = $request->review_ids;
        $action = $request->action;

        $menuIds = [];
        
        switch ($action) {
            case 'approve':
                $reviews = Review::whereIn('id', $reviewIds)->get();
                foreach ($reviews as $review) {
                    $menuIds[] = $review->menu_id;
                }
                Review::whereIn('id', $reviewIds)->update(['status' => 'approved']);
                $message = 'Review yang dipilih berhasil disetujui.';
                ActivityLogger::log(
                    'Bulk Approve Review',
                    'reviews',
                    null,
                    sprintf('Menyetujui %d ulasan.', count($reviewIds))
                );
                break;
            case 'hide':
                $reviews = Review::whereIn('id', $reviewIds)->get();
                foreach ($reviews as $review) {
                    $menuIds[] = $review->menu_id;
                }
                Review::whereIn('id', $reviewIds)->update(['status' => 'hidden']);
                $message = 'Review yang dipilih berhasil disembunyikan.';
                ActivityLogger::log(
                    'Bulk Hide Review',
                    'reviews',
                    null,
                    sprintf('Menyembunyikan %d ulasan.', count($reviewIds))
                );
                break;
            case 'unhide':
                $reviews = Review::whereIn('id', $reviewIds)->get();
                foreach ($reviews as $review) {
                    $menuIds[] = $review->menu_id;
                }
                Review::whereIn('id', $reviewIds)->update(['status' => 'approved']);
                $message = 'Review yang dipilih berhasil ditampilkan kembali.';
                ActivityLogger::log(
                    'Bulk Unhide Review',
                    'reviews',
                    null,
                    sprintf('Menampilkan kembali %d ulasan.', count($reviewIds))
                );
                break;
            case 'reject':
                $reviews = Review::whereIn('id', $reviewIds)->get();
                foreach ($reviews as $review) {
                    $menuIds[] = $review->menu_id;
                    // Store deleted review ID in cache
                    $deletedIds = Cache::get("deleted_reviews_menu_{$review->menu_id}", []);
                    $deletedIds[] = $review->id;
                    Cache::put("deleted_reviews_menu_{$review->menu_id}", $deletedIds, now()->addMinutes(10));
                }
                Review::whereIn('id', $reviewIds)->delete();
                $message = 'Review yang dipilih berhasil ditolak dan dihapus.';
                ActivityLogger::log(
                    'Bulk Delete Review',
                    'reviews',
                    null,
                    sprintf('Menolak & menghapus %d ulasan.', count($reviewIds))
                );
                break;
        }
        
        // Clear cache for all affected menus
        foreach (array_unique($menuIds) as $menuId) {
            if ($action !== 'reject') {
                Cache::forget("deleted_reviews_menu_{$menuId}");
            }
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get statistics for dashboard (API endpoint).
     */
    public function statistics()
    {
        Gate::authorize('moderate', Review::class);
        
        $stats = [
            'total' => Review::count(),
            'pending' => Review::where('status', 'pending')->count(),
            'approved' => Review::where('status', 'approved')->count(),
            'hidden' => Review::where('status', 'hidden')->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Display review statistics page.
     */
    public function statisticsPage()
    {
        Gate::authorize('moderate', Review::class);
        
        // Total reviews
        $totalReviews = Review::count();
        $approvedReviews = Review::where('status', 'approved')->count();
        
        // Average rating
        $averageRating = Review::where('status', 'approved')->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 2) : 0;
        
        // Star distribution (1-5 stars)
        $starDistribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $count = Review::where('status', 'approved')
                ->where('rating', $i)
                ->count();
            $percentage = $approvedReviews > 0 ? round(($count / $approvedReviews) * 100, 1) : 0;
            $starDistribution[$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }
        
        // Rating trend (last 6 months)
        $ratingTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $monthReviews = Review::where('status', 'approved')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
            
            $monthAvgRating = Review::where('status', 'approved')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->avg('rating');
            
            $ratingTrend[] = [
                'month' => $month->format('M Y'),
                'month_short' => $month->format('M'),
                'count' => $monthReviews,
                'average_rating' => $monthAvgRating ? round($monthAvgRating, 2) : 0
            ];
        }
        
        // Top rated menus
        $topRatedMenus = Review::where('status', 'approved')
            ->selectRaw('menu_id, AVG(rating) as avg_rating, COUNT(*) as review_count')
            ->groupBy('menu_id')
            ->orderByDesc('avg_rating')
            ->orderByDesc('review_count')
            ->limit(10)
            ->with('menu:id,name')
            ->get();
        
        // Reviews by status
        $reviewsByStatus = [
            'approved' => Review::where('status', 'approved')->count(),
            'pending' => Review::where('status', 'pending')->count(),
            'hidden' => Review::where('status', 'hidden')->count(),
        ];
        
        return view('admin.reviews.statistics', compact(
            'totalReviews',
            'approvedReviews',
            'averageRating',
            'starDistribution',
            'ratingTrend',
            'topRatedMenus',
            'reviewsByStatus'
        ));
    }
}
