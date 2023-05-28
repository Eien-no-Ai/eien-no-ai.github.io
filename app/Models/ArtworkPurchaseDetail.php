<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtworkPurchaseDetail extends Model
{
    protected $fillable = [
        'purchase_id',
        'artwork_id',
        'artist_id',
        'user_id',
        'price',
        'status_id',
    ];

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase()
    {
        return $this->belongsTo(ArtworkPurchase::class, 'purchase_id');
    }

    public function artworkPurchase()
    {
        return $this->belongsTo('App\Models\ArtworkPurchase', 'purchase_id');
    }
}
