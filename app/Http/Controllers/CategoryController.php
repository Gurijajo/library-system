<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('books');
        
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('description', 'like', "%{$request->search}%");
        }
        
        $categories = $query->paginate(12);
        
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $category->load(['books.author']);
        $books = $category->books()->with('author')->paginate(12);
        
        return view('categories.show', compact('category', 'books'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/'
        ]);

        $category = Category::create($validated);
        
        return redirect()->route('categories.show', $category)
                        ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[a-fA-F0-9]{6}$/'
        ]);

        $category->update($validated);
        
        return redirect()->route('categories.show', $category)
                        ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->books()->exists()) {
            return back()->with('error', 'Cannot delete category with existing books!');
        }

        $category->delete();
        
        return redirect()->route('categories.index')
                        ->with('success', 'Category deleted successfully!');
    }
}