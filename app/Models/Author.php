<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'birth_date',
        'death_date',
        'nationality',
        'photo'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getAgeAttribute()
    {
        if (!$this->birth_date) return null;
        
        $endDate = $this->death_date ?? now();
        return $this->birth_date->diffInYears($endDate);
    }
}