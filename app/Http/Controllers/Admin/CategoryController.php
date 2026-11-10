<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display all categories.
     */
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('events')
            ->orderBy('name')
            ->paginate(12);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a new category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('categories', 'name')],
            'description' => ['nullable', 'string', 'max:500'],
            'color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ], [], [
            'name' => 'nama kategori',
            'color' => 'warna',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the given category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
        ], [], [
            'name' => 'nama kategori',
            'color' => 'warna',
        ]);

        $validated['slug'] = Category::uniqueSlug($validated['name'], $category->id);

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil diperbarui.');
    }

    /**
     * Delete the given category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Kategori berhasil dihapus.');
    }
}
