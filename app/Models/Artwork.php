<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'artist_id',
        'id',
    ];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    public function purchases()
    {
        return $this->hasMany(ArtworkPurchase::class);
    }
}
