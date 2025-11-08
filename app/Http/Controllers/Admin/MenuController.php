<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Menu::with('category');
        
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
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $menus = $query->latest()->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();
        
        return view('admin.menus.index', compact('menus', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $menu = Menu::create([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? true),
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('images/menu');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug($menu->name) . '.' . $extension;
            $request->file('image')->move($directory, $filename);
        }

        $page = $request->query('page', 1);
        return redirect()->route('admin.menus.index', ['page' => $page])->with('success', 'Menu berhasil dibuat');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Menu $menu)
    {
        $categories = Category::orderBy('name')->get();
        $currentPage = $request->query('page', 1);
        return view('admin.menus.edit', compact('menu', 'categories', 'currentPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $menu->update([
            'name' => $data['name'],
            'category_id' => $data['category_id'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'description' => $data['description'] ?? null,
            'is_active' => (bool)($data['is_active'] ?? false),
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('images/menu');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::slug($menu->name) . '.' . $extension;
            // Hapus file lama dengan ekstensi umum jika ada
            foreach (['jpg','jpeg','png','webp'] as $ext) {
                $old = $directory . '/' . Str::slug($menu->getOriginal('name') ?? $menu->name) . '.' . $ext;
                if (File::exists($old)) {
                    File::delete($old);
                }
            }
            $request->file('image')->move($directory, $filename);
        } else {
            // Jika nama berubah, dan tidak upload gambar baru, pindahkan file lama (jika ada) ke nama baru
            $directory = public_path('images/menu');
            $oldSlug = Str::slug($menu->getOriginal('name') ?? $menu->name);
            $newSlug = Str::slug($menu->name);
            if ($oldSlug !== $newSlug && File::exists($directory)) {
                foreach (['jpg','jpeg','png','webp'] as $ext) {
                    $oldPath = $directory . '/' . $oldSlug . '.' . $ext;
                    if (File::exists($oldPath)) {
                        @File::move($oldPath, $directory . '/' . $newSlug . '.' . $ext);
                    }
                }
            }
        }

        $page = $request->input('page', $request->query('page', 1));
        $redirectParams = ['page' => $page];
        if ($request->query('search')) $redirectParams['search'] = $request->query('search');
        if ($request->query('category')) $redirectParams['category'] = $request->query('category');
        if ($request->query('status')) $redirectParams['status'] = $request->query('status');
        return redirect()->route('admin.menus.index', $redirectParams)->with('success', 'Menu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Menu $menu)
    {
        // Hapus gambar jika ada
        $directory = public_path('images/menu');
        foreach (['jpg','jpeg','png','webp'] as $ext) {
            $path = $directory . '/' . Str::slug($menu->name) . '.' . $ext;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $menu->delete();
        $page = $request->query('page', 1);
        $redirectParams = ['page' => $page];
        if ($request->query('search')) $redirectParams['search'] = $request->query('search');
        if ($request->query('category')) $redirectParams['category'] = $request->query('category');
        if ($request->query('status')) $redirectParams['status'] = $request->query('status');
        return redirect()->route('admin.menus.index', $redirectParams)->with('success', 'Menu berhasil dihapus');
    }
}
