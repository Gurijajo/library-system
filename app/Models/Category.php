<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function getBooksCountAttribute()
    {
        return $this->books()->count();
    }
}