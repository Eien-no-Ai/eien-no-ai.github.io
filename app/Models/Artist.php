<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'featured_artwork_id',
    ];

    public function artworks()
    {
        return $this->hasMany(Artwork::class);
    }

    public function featuredArtwork()
    {
        return $this->belongsTo(Artwork::class, 'featured_artwork_id');
    }
    public function purchases()
    {
        return $this->hasMany(ArtworkPurchase::class);
    }
}
