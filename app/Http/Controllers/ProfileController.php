<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get user statistics
        $stats = [
            'total_borrowings' => $user->borrowings()->count(),
            'current_borrowings' => $user->currentBorrowings()->count(),
            'overdue_books' => $user->overdueBooks()->count(),
            'total_fines' => $user->totalFines(),
            'books_returned' => $user->borrowings()->where('status', 'returned')->count(),
        ];

        // Get recent borrowing history
        $recentBorrowings = $user->borrowings()
            ->with(['book.author', 'book.category'])
            ->latest()
            ->take(5)
            ->get();

        // Get current borrowings
        $currentBorrowings = $user->currentBorrowings()
            ->with(['book.author', 'book.category'])
            ->get();

        return view('profile.show', compact('user', 'stats', 'recentBorrowings', 'currentBorrowings'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($updateData);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    /**
     * Show the settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        $preferences = $user->preferences ?? [];

        return view('profile.settings', compact('user', 'preferences'));
    }

    /**
     * Update user preferences.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email_notifications' => ['boolean'],
            'sms_notifications' => ['boolean'],
            'due_date_reminders' => ['boolean'],
            'new_book_alerts' => ['boolean'],
            'newsletter_subscription' => ['boolean'],
            'theme' => ['in:light,dark,auto'],
            'language' => ['in:en,es,fr,de'],
            'items_per_page' => ['integer', 'min:10', 'max:100'],
        ]);

        $preferences = [
            'notifications' => [
                'email' => $request->boolean('email_notifications'),
                'sms' => $request->boolean('sms_notifications'),
                'due_date_reminders' => $request->boolean('due_date_reminders'),
                'new_book_alerts' => $request->boolean('new_book_alerts'),
                'newsletter' => $request->boolean('newsletter_subscription'),
            ],
            'display' => [
                'theme' => $request->theme ?? 'light',
                'language' => $request->language ?? 'en',
                'items_per_page' => $request->items_per_page ?? 20,
            ],
        ];

        $user->update(['preferences' => $preferences]);

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Delete the user's avatar.
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return back()->with('success', 'Avatar deleted successfully!');
    }
}