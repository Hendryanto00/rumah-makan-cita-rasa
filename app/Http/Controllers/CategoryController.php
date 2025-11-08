<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories with search and filter.
     */
    public function index(Request $request)
    {
        $query = Category::withCount('menus');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }
        
        $categories = $query->orderBy('name')->paginate(15)->withQueryString();
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
        ]);

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category)
    {
        $category->loadCount('menus');
        $category->load('menus'); // Load menus untuk ditampilkan
        $allCategories = Category::where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();
        
        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    /**
     * Update the category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'move_menus_to' => 'nullable|exists:categories,id',
            'selected_menus' => 'nullable|array',
            'selected_menus.*' => 'exists:menus,id',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique' => 'Nama kategori sudah digunakan.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'description.max' => 'Deskripsi maksimal 1000 karakter.',
            'move_menus_to.exists' => 'Kategori tujuan tidak valid.',
            'selected_menus.array' => 'Menu yang dipilih tidak valid.',
            'selected_menus.*.exists' => 'Salah satu menu yang dipilih tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            // If moving selected menus to another category
            if ($request->has('move_menus_to') && $request->move_menus_to && $request->has('selected_menus')) {
                $targetCategoryId = $request->move_menus_to;
                $selectedMenuIds = $request->selected_menus;
                
                // Verify that selected menus belong to this category
                $menusInCategory = Menu::where('category_id', $category->id)
                    ->whereIn('id', $selectedMenuIds)
                    ->pluck('id')
                    ->toArray();
                
                if (count($menusInCategory) > 0) {
                    Menu::whereIn('id', $menusInCategory)
                        ->update(['category_id' => $targetCategoryId]);
                }
            }

            // Update category
            $category->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori.');
        }
    }

    /**
     * Remove the category.
     */
    public function destroy(Category $category)
    {
        // Check if category has menus
        $menuCount = $category->menus()->count();
        
        if ($menuCount > 0) {
            return back()
                ->with('error', "Kategori tidak dapat dihapus karena masih memiliki {$menuCount} menu. Pindahkan atau hapus menu terlebih dahulu.");
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
