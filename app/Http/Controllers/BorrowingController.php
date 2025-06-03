<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book.author', 'issuedBy']);
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->overdue_only) {
            $query->overdue();
        }
        
        $borrowings = $query->latest()->paginate(15);
        $users = User::where('role', 'member')->get();
        
        return view('borrowings.index', compact('borrowings', 'users'));
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'book.author', 'issuedBy', 'returnedTo']);
        return view('borrowings.show', compact('borrowing'));
    }

    public function create(Request $request)
    {
        $book = null;
        $user = null;
        
        if ($request->book_id) {
            $book = Book::findOrFail($request->book_id);
        }
        
        if ($request->user_id) {
            $user = User::findOrFail($request->user_id);
        }
        
        $books = Book::available()->with('author')->get();
        $users = User::where('role', 'member')
                    ->where('status', 'active')
                    ->get();
        
        return view('borrowings.create', compact('books', 'users', 'book', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'borrowed_date' => 'required|date|before_or_equal:today',
            'due_date' => 'required|date|after:borrowed_date',
            'notes' => 'nullable|string'
        ]);

        $user = User::findOrFail($validated['user_id']);
        $book = Book::findOrFail($validated['book_id']);

        // Check if user can borrow books
        if (!$user->canBorrowBooks()) {
            return back()->with('error', 'User cannot borrow books due to restrictions!');
        }

        // Check if book is available
        if (!$book->isAvailable()) {
            return back()->with('error', 'Book is not available for borrowing!');
        }

        $validated['issued_by'] = auth()->id();
        
        $borrowing = Borrowing::create($validated);
        
        // Update book availability
        $book->decrement('available_copies');
        
        return redirect()->route('borrowings.show', $borrowing)
                        ->with('success', 'Book borrowed successfully!');
    }

    public function return(Borrowing $borrowing)
    {
        if ($borrowing->status !== 'borrowed' && $borrowing->status !== 'overdue') {
            return back()->with('error', 'This book has already been returned!');
        }

        $borrowing->update([
            'returned_date' => now(),
            'status' => 'returned',
            'returned_to' => auth()->id()
        ]);

        // Calculate and update fine if overdue
        if ($borrowing->isOverdue()) {
            $fine = $borrowing->calculateFine();
            $borrowing->update(['fine_amount' => $fine]);
        }

        // Update book availability
        $borrowing->book->increment('available_copies');
        
        return redirect()->route('borrowings.show', $borrowing)
                        ->with('success', 'Book returned successfully!');
    }

    public function markOverdue()
    {
        $overdueBorrowings = Borrowing::where('due_date', '<', now())
                                    ->where('status', 'borrowed')
                                    ->get();

        foreach ($overdueBorrowings as $borrowing) {
            $borrowing->update([
                'status' => 'overdue',
                'fine_amount' => $borrowing->calculateFine()
            ]);
        }

        return back()->with('success', count($overdueBorrowings) . ' borrowings marked as overdue!');
    }

    public function payFine(Borrowing $borrowing)
    {
        if ($borrowing->fine_amount <= 0) {
            return back()->with('error', 'No fine to pay!');
        }

        $borrowing->update(['fine_paid' => true]);
        
        return back()->with('success', 'Fine paid successfully!');
    }
}