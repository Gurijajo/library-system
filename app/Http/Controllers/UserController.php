<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin,librarian']);
    }

    public function index(Request $request)
    {
        $query = User::withCount(['borrowings', 'currentBorrowings']);
        
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('membership_id', 'like', "%{$request->search}%");
            });
        }
        
        if ($request->role) {
            $query->where('role', $request->role);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $users = $query->paginate(15);
        
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load([
            'borrowings.book.author',
            'currentBorrowings.book.author',
            'reservations.book.author'
        ]);
        
        $borrowingHistory = $user->borrowings()
                                ->with('book.author')
                                ->latest()
                                ->paginate(10);
        
        return view('users.show', compact('user', 'borrowingHistory'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:admin,librarian,member',
            'status' => 'required|in:active,inactive,suspended',
            'membership_expiry' => 'nullable|date|after:today',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed'
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['membership_id'] = $this->generateMembershipId();

        $user = User::create($validated);
        
        return redirect()->route('users.show', $user)
                        ->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date|before:today',
            'role' => 'required|in:admin,librarian,member',
            'status' => 'required|in:active,inactive,suspended',
            'membership_expiry' => 'nullable|date',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Only validate password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);
        
        return redirect()->route('users.show', $user)
                        ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->currentBorrowings()->exists()) {
            return back()->with('error', 'Cannot delete user with active borrowings!');
        }

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();
        
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully!');
    }

    private function generateMembershipId()
    {
        do {
            $membershipId = 'LIB' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('membership_id', $membershipId)->exists());

        return $membershipId;
    }
}