<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'date_of_birth',
        'role',
        'status',
        'membership_id',
        'membership_expiry',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'membership_expiry' => 'date',
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function currentBorrowings()
    {
        return $this->borrowings()->whereIn('status', ['borrowed', 'overdue']);
    }

    public function overdueBooks()
    {
        return $this->borrowings()->where('status', 'overdue');
    }

    public function totalFines()
    {
        return $this->borrowings()->where('fine_paid', false)->sum('fine_amount');
    }

    public function canBorrowBooks()
    {
        return $this->status === 'active' && 
               $this->currentBorrowings()->count() < 5 && 
               $this->totalFines() < 50;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLibrarian()
    {
        return in_array($this->role, ['admin', 'librarian']);
    }

        public function getPreferencesAttribute($value)
    {
        $defaults = [
            'notifications' => [
                'email' => true,
                'sms' => false,
                'due_date_reminders' => true,
                'new_book_alerts' => false,
                'newsletter' => false,
            ],
            'display' => [
                'theme' => 'light',
                'language' => 'en',
                'items_per_page' => 20,
            ],
        ];

        $preferences = json_decode($value, true) ?? [];
        
        return array_merge_recursive($defaults, $preferences);
    }

        public function activeReservations()
        {
            return $this->reservations()->where('status', 'active');
        }


        public function canMakeReservation()
        {
            
            $maxReservations = 3; 
            if ($this->activeReservations()->count() >= $maxReservations) {
                return false;
            }

        
            if ($this->totalFines() > 0) {
                return false;
            }

        
            if ($this->status !== 'active') {
                return false;
            }

            return true;
        }
}