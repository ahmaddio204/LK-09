<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year',
        'category',
        'description',
        'cover'
    ];

    /**
     * Get the cover image URL.
     */
    public function getCoverUrlAttribute(): string
    {
        if ($this->cover && Storage::disk('public')->exists($this->cover)) {
            return Storage::url($this->cover);
        }
        
        // Fallback premium placeholder
        return 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?q=80&w=387&auto=format&fit=crop';
    }
}
