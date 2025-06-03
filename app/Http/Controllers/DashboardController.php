<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Author;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isLibrarian()) {
            return $this->librarianDashboard();
        }
        
        return $this->memberDashboard();
    }
    
    private function librarianDashboard()
    {
        // Statistics
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::where('role', 'member')->count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'books_borrowed' => Borrowing::active()->count(),
            'books_available' => Book::sum('available_copies'),
            'overdue_books' => Borrowing::overdue()->count(),
            'total_fines' => Borrowing::where('fine_paid', false)->sum('fine_amount'),
        ];
        
        // Recent activities
        $recentBorrowings = Borrowing::with(['user', 'book.author'])
                                   ->latest()
                                   ->take(5)
                                   ->get();
        
        $recentReservations = Reservation::with(['user', 'book.author'])
                                        ->latest()
                                        ->take(5)
                                        ->get();
        
        // Overdue books
        $overdueBooks = Borrowing::overdue()
                                ->with(['user', 'book.author'])
                                ->take(10)
                                ->get();
        
        // Popular books (most borrowed)
        $popularBooks = Book::withCount(['borrowings' => function ($query) {
                              $query->where('created_at', '>=', now()->subMonths(3));
                          }])
                          ->with('author')
                          ->orderBy('borrowings_count', 'desc')
                          ->take(5)
                          ->get();
        
        // Monthly borrowing statistics
        $monthlyStats = Borrowing::select(
                          DB::raw('MONTH(created_at) as month'),
                          DB::raw('COUNT(*) as total')
                        )
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get()
                        ->pluck('total', 'month')
                        ->toArray();
        
        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyStats[$i] ?? 0;
        }
        
        return view('dashboard.librarian', compact(
            'stats', 
            'recentBorrowings', 
            'recentReservations', 
            'overdueBooks', 
            'popularBooks',
            'chartData'
        ));
    }
    
    private function memberDashboard()
    {
        $user = auth()->user();
        
        // User's current borrowings
        $currentBorrowings = $user->currentBorrowings()
                                 ->with(['book.author'])
                                 ->get();
        
        // User's reservations
        $reservations = $user->reservations()
                            ->where('status', 'active')
                            ->with(['book.author'])
                            ->get();
        
        // User's borrowing history
        $borrowingHistory = $user->borrowings()
                                ->with(['book.author'])
                                ->latest()
                                ->take(5)
                                ->get();
        
        // Recommended books (based on user's borrowing history)
        $userCategories = $user->borrowings()
                              ->with('book.category')
                              ->get()
                              ->pluck('book.category.id')
                              ->unique()
                              ->filter();
        
        $recommendedBooks = Book::whereIn('category_id', $userCategories)
                               ->available()
                               ->with(['author', 'category'])
                               ->inRandomOrder()
                               ->take(6)
                               ->get();
        
        // If no borrowing history, show popular books
        if ($recommendedBooks->isEmpty()) {
            $recommendedBooks = Book::withCount('borrowings')
                                  ->available()
                                  ->with(['author', 'category'])
                                  ->orderBy('borrowings_count', 'desc')
                                  ->take(6)
                                  ->get();
        }
        
        // User statistics
        $userStats = [
            'books_borrowed' => $currentBorrowings->count(),
            'total_borrowed' => $user->borrowings()->count(),
            'overdue_books' => $user->overdueBooks()->count(),
            'total_fines' => $user->totalFines(),
            'active_reservations' => $reservations->count(),
        ];
        
        return view('dashboard.member', compact(
            'currentBorrowings',
            'reservations', 
            'borrowingHistory',
            'recommendedBooks',
            'userStats'
        ));
    }
}