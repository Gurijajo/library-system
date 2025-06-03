<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn',
        'description',
        'author_id',
        'category_id',
        'total_copies',
        'available_copies',
        'publication_date',
        'publisher',
        'language',
        'pages',
        'cover_image',
        'price',
        'status'
    ];

    protected $casts = [
        'publication_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

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

    public function activeReservations()
    {
        return $this->reservations()->where('status', 'active');
    }

    public function isAvailable()
    {
        return $this->available_copies > 0 && $this->status === 'active';
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_copies', '>', 0)
                    ->where('status', 'active');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('isbn', 'like', "%{$term}%")
              ->orWhereHas('author', function ($author) use ($term) {
                  $author->where('name', 'like', "%{$term}%");
              });
        });
    }

    public function getReservationQueueCount()
    {
        return $this->activeReservations()->count();
    }


    public function hasReservations()
    {
        return $this->activeReservations()->exists();
    }
}