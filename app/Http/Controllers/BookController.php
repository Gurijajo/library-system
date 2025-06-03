<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'category']);
        
        if ($request->search) {
            $query->search($request->search);
        }
        
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->author_id) {
            $query->where('author_id', $request->author_id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->available_only) {
            $query->available();
        }
        
        $books = $query->paginate(12);
        $authors = Author::all();
        $categories = Category::all();
        
        return view('books.index', compact('books', 'authors', 'categories'));
    }

    public function show(Book $book)
    {
        $book->load(['author', 'category', 'currentBorrowings.user', 'activeReservations.user']);
        return view('books.show', compact('book'));
    }

    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'description' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'required|integer|min:1',
            'publication_date' => 'nullable|date',
            'publisher' => 'nullable|string|max:255',
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,maintenance'
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        $validated['available_copies'] = $validated['total_copies'];
        
        $book = Book::create($validated);
        
        return redirect()->route('books.show', $book)
                        ->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => ['required', 'string', Rule::unique('books')->ignore($book->id)],
            'description' => 'nullable|string',
            'author_id' => 'required|exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'total_copies' => 'required|integer|min:1',
            'publication_date' => 'nullable|date',
            'publisher' => 'nullable|string|max:255',
            'language' => 'required|string|max:50',
            'pages' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,maintenance'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        // Update available copies if total copies changed
        if ($validated['total_copies'] !== $book->total_copies) {
            $difference = $validated['total_copies'] - $book->total_copies;
            $validated['available_copies'] = max(0, $book->available_copies + $difference);
        }
        
        $book->update($validated);
        
        return redirect()->route('books.show', $book)
                        ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if ($book->borrowings()->active()->exists()) {
            return back()->with('error', 'Cannot delete book with active borrowings!');
        }

        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }

        $book->delete();
        
        return redirect()->route('books.index')
                        ->with('success', 'Book deleted successfully!');
    }
}