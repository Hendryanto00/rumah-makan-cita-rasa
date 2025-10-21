<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Review;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function __construct()
    {
        // Middleware akan diatur di routes
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $menuId = $request->get('menu_id');
        $menu = null;
        
        if ($menuId) {
            $menu = Menu::findOrFail($menuId);
        }

        return view('reviews.create', compact('menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = Review::create([
            'user_id' => Auth::id(),
            'menu_id' => $request->menu_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('menus.show', $request->menu_id)
            ->with('success', 'Review berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        Gate::authorize('view', $review);

        $review->load(['user', 'menu']);

        return view('reviews.show', compact('review'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        Gate::authorize('update', $review);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()
            ->with('success', 'Review berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return redirect()->back()
            ->with('success', 'Review berhasil dihapus!');
    }

    /**
     * Get reviews for a specific menu (public method)
     */
    public function getMenuReviews(Menu $menu)
    {
        $reviews = $menu->reviews()
            ->with('user')
            ->latest()
            ->paginate(5);

        return response()->json($reviews);
    }
}
