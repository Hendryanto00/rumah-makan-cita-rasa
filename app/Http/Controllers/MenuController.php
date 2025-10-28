<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Menu::with('category', 'reviews')
            ->where('is_active', true);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                    $categoryQuery->where('name', 'like', "%{$searchTerm}%");
                });
            });
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $menus = $query->paginate(12);
        $categories = \App\Models\Category::all();

        // If it's an AJAX request, return only the menu grid and pagination
        if ($request->ajax()) {
            return response()->json([
                'menu_grid' => view('menus.partials.menu-grid', compact('menus'))->render(),
                'pagination' => view('menus.partials.pagination', compact('menus'))->render()
            ]);
        }

        return view('menus.index', compact('menus', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['category', 'reviews' => function($query) {
            $query->with('user')->latest();
        }]);

        return view('menus.show', compact('menu'));
    }
}
