<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'reserved_date',
        'expiry_date',
        'fulfilled_date',
        'notes',
    ];

    protected $casts = [
        'reserved_date' => 'date',
        'expiry_date' => 'date',
        'fulfilled_date' => 'date',
    ];

    /**
     * Get the user that made the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was reserved.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Scope for active reservations.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for expired reservations.
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')
                    ->orWhere(function($q) {
                        $q->where('status', 'active')
                          ->where('expiry_date', '<', now());
                    });
    }

    /**
     * Check if reservation is expired.
     */
    public function isExpired()
    {
        return $this->status === 'expired' || 
               ($this->status === 'active' && $this->expiry_date < now());
    }

    /**
     * Check if reservation is active.
     */
    public function isActive()
    {
        return $this->status === 'active' && $this->expiry_date >= now();
    }

    /**
     * Get days until expiry.
     */
    public function daysUntilExpiry()
    {
        if ($this->status !== 'active') {
            return 0;
        }

        return max(0, now()->diffInDays($this->expiry_date, false));
    }

    /**
     * Mark reservation as fulfilled.
     */
    public function fulfill()
    {
        $this->update([
            'status' => 'fulfilled',
            'fulfilled_date' => now(),
        ]);
    }

    /**
     * Cancel the reservation.
     */
    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    /**
     * Mark reservation as expired.
     */
    public function expire()
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Get reservation priority (lower number = higher priority).
     */
    public function getPriority()
    {
        return $this->created_at->timestamp;
    }
}