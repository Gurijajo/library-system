<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::withCount('books');
        
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('nationality', 'like', "%{$request->search}%");
        }
        
        if ($request->nationality) {
            $query->where('nationality', $request->nationality);
        }
        
        $authors = $query->paginate(12);
        
        // Get unique nationalities for filter
        $nationalities = Author::distinct()
                              ->whereNotNull('nationality')
                              ->pluck('nationality')
                              ->sort();
        
        return view('authors.index', compact('authors', 'nationalities'));
    }

    public function show(Author $author)
    {
        $author->load(['books.category']);
        return view('authors.show', compact('author'));
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'death_date' => 'nullable|date|after:birth_date',
            'nationality' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('author-photos', 'public');
        }

        $author = Author::create($validated);
        
        return redirect()->route('authors.show', $author)
                        ->with('success', 'Author created successfully!');
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_date' => 'nullable|date|before:today',
            'death_date' => 'nullable|date|after:birth_date',
            'nationality' => 'nullable|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($author->photo) {
                Storage::disk('public')->delete($author->photo);
            }
            $validated['photo'] = $request->file('photo')->store('author-photos', 'public');
        }

        $author->update($validated);
        
        return redirect()->route('authors.show', $author)
                        ->with('success', 'Author updated successfully!');
    }

    public function destroy(Author $author)
    {
        if ($author->books()->exists()) {
            return back()->with('error', 'Cannot delete author with existing books!');
        }

        if ($author->photo) {
            Storage::disk('public')->delete($author->photo);
        }

        $author->delete();
        
        return redirect()->route('authors.index')
                        ->with('success', 'Author deleted successfully!');
    }
}