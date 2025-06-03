<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the reservations.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'book.author', 'book.category']);

        // Filter by user role
        if (!auth()->user()->isLibrarian()) {
            $query->where('user_id', auth()->id());
        }

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('user_id') && auth()->user()->isLibrarian()) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('book_id')) {
            $query->where('book_id', $request->book_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        
        if (in_array($sortField, ['created_at', 'reserved_date', 'expiry_date', 'status'])) {
            $query->orderBy($sortField, $sortDirection);
        }

        $reservations = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => Reservation::count(),
            'active' => Reservation::where('status', 'active')->count(),
            'fulfilled' => Reservation::where('status', 'fulfilled')->count(),
            'expired' => Reservation::where('status', 'expired')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        // Get users for filter (librarians only)
        $users = auth()->user()->isLibrarian() ? User::orderBy('name')->get() : collect();

        return view('reservations.index', compact('reservations', 'stats', 'users'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $book = null;
        if ($request->filled('book_id')) {
            $book = Book::with(['author', 'category'])->findOrFail($request->book_id);
            
            // Check if book is available
            if ($book->available_copies > 0) {
                return redirect()->route('borrowings.create', ['book_id' => $book->id])
                    ->with('info', 'This book is available for immediate borrowing. You don\'t need to make a reservation.');
            }

            // Check if user already has active reservation for this book
            if (auth()->user()->reservations()->where('book_id', $book->id)->where('status', 'active')->exists()) {
                return redirect()->back()->with('error', 'You already have an active reservation for this book.');
            }
        }

        $books = Book::with(['author', 'category'])
                    ->where('available_copies', 0)
                    ->orderBy('title')
                    ->get();

        return view('reservations.create', compact('book', 'books'));
    }

    /**
     * Store a newly created reservation in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $book = Book::findOrFail($request->book_id);
        $user = auth()->user();

        // Check if book is available
        if ($book->available_copies > 0) {
            return redirect()->route('borrowings.create', ['book_id' => $book->id])
                ->with('info', 'This book is available for immediate borrowing.');
        }

        // Check if user already has active reservation for this book
        if ($user->reservations()->where('book_id', $book->id)->where('status', 'active')->exists()) {
            return redirect()->back()->with('error', 'You already have an active reservation for this book.');
        }

        // Check user's borrowing limits
        if (!$user->canMakeReservation()) {
            return redirect()->back()->with('error', 'You have reached your reservation limit or have outstanding fines.');
        }

        // Create reservation
        $reservation = Reservation::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'active',
            'reserved_date' => now(),
            'expiry_date' => now()->addDays(7), // 7 days to collect once available
            'notes' => $request->notes,
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully! You will be notified when the book becomes available.');
    }

    /**
     * Display the specified reservation.
     */
    public function show(Reservation $reservation)
    {
        // Check authorization
        if (!auth()->user()->isLibrarian() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->load(['user', 'book.author', 'book.category']);

        // Get queue position
        $queuePosition = Reservation::where('book_id', $reservation->book_id)
            ->where('status', 'active')
            ->where('created_at', '<', $reservation->created_at)
            ->count() + 1;

        return view('reservations.show', compact('reservation', 'queuePosition'));
    }

    /**
     * Cancel the specified reservation.
     */
    public function cancel(Reservation $reservation)
    {
        // Check authorization
        if (!auth()->user()->isLibrarian() && $reservation->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reservation->status !== 'active') {
            return redirect()->back()->with('error', 'Only active reservations can be cancelled.');
        }

        $reservation->cancel();

        return redirect()->route('reservations.index')
            ->with('success', 'Reservation cancelled successfully.');
    }

    /**
     * Fulfill the specified reservation (librarian only).
     */
    public function fulfill(Reservation $reservation)
    {
        if (!auth()->user()->isLibrarian()) {
            abort(403);
        }

        if ($reservation->status !== 'active') {
            return redirect()->back()->with('error', 'Only active reservations can be fulfilled.');
        }

        $book = $reservation->book;
        if ($book->available_copies <= 0) {
            return redirect()->back()->with('error', 'No copies available to fulfill this reservation.');
        }

        $reservation->fulfill();

        // Redirect to create borrowing
        return redirect()->route('borrowings.create', [
            'book_id' => $book->id,
            'user_id' => $reservation->user_id,
            'reservation_id' => $reservation->id
        ])->with('success', 'Reservation fulfilled. Please create the borrowing record.');
    }

    /**
     * Mark expired reservations.
     */
    public function markExpired()
    {
        if (!auth()->user()->isLibrarian()) {
            abort(403);
        }

        $expiredCount = Reservation::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->update(['status' => 'expired']);

        return redirect()->back()
            ->with('success', "Marked {$expiredCount} reservations as expired.");
    }

    /**
     * Get reservation queue for a book.
     */
    public function queue(Book $book)
    {
        if (!auth()->user()->isLibrarian()) {
            abort(403);
        }

        $reservations = $book->reservations()
            ->with('user')
            ->where('status', 'active')
            ->orderBy('created_at')
            ->get();

        return view('reservations.queue', compact('book', 'reservations'));
    }

    public function updateNotes(Request $request, Reservation $reservation)
{
    // Check authorization
    if (!auth()->user()->isLibrarian() && $reservation->user_id !== auth()->id()) {
        abort(403);
    }

    $request->validate([
        'notes' => 'nullable|string|max:500',
    ]);

    $reservation->update([
        'notes' => $request->notes,
    ]);

    return redirect()->route('reservations.show', $reservation)
        ->with('success', 'Reservation notes updated successfully.');
}
}