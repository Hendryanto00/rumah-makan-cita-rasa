<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Gate::allows('moderate', Review::class)) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of all reviews for moderation.
     */
    public function index(Request $request)
    {
        $query = Review::with(['user', 'menu']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search by user name or menu name
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('menu', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'menu']);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Approve a review.
     */
    public function approve(Review $review)
    {
        $review->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', 'Review berhasil disetujui.');
    }

    /**
     * Hide a review.
     */
    public function hide(Review $review)
    {
        $review->update(['status' => 'hidden']);

        return redirect()->back()
            ->with('success', 'Review berhasil disembunyikan.');
    }

    /**
     * Reject a review (delete).
     */
    public function reject(Review $review)
    {
        $review->delete();

        return redirect()->back()
            ->with('success', 'Review berhasil ditolak dan dihapus.');
    }

    /**
     * Bulk actions for multiple reviews.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,hide,reject',
            'review_ids' => 'required|array|min:1',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        $reviewIds = $request->review_ids;
        $action = $request->action;

        switch ($action) {
            case 'approve':
                Review::whereIn('id', $reviewIds)->update(['status' => 'approved']);
                $message = 'Review yang dipilih berhasil disetujui.';
                break;
            case 'hide':
                Review::whereIn('id', $reviewIds)->update(['status' => 'hidden']);
                $message = 'Review yang dipilih berhasil disembunyikan.';
                break;
            case 'reject':
                Review::whereIn('id', $reviewIds)->delete();
                $message = 'Review yang dipilih berhasil ditolak dan dihapus.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get statistics for dashboard.
     */
    public function statistics()
    {
        $stats = [
            'total' => Review::count(),
        ];

        return response()->json($stats);
    }
}
