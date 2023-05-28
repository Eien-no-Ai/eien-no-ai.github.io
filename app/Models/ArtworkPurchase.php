<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtworkPurchase extends Model
{
    protected $fillable = [
        'user_id',
        'artwork_id',
        'artist_id',
        'price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function artwork()
    {
        return $this->belongsTo(Artwork::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function details()
    {
        return $this->hasOne(ArtworkPurchaseDetail::class, 'purchase_id');
    }
    public function artworkPurchases()
    {
        return $this->hasMany(ArtworkPurchase::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($artworkPurchase) {
            $artworkPurchase->artworkPurchaseDetails()->update(['status_id' => $artworkPurchase->status_id]);
        });
    }

    public function artworkPurchaseDetails()
    {
        return $this->hasMany(ArtworkPurchaseDetail::class, 'purchase_id');
    }
}
