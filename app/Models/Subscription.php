<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_id', 'user_id', 'price', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];
    public function price(): Attribute
    {
        return new Attribute(
            get: fn ($price) => $price / 100,
            set: fn ($price) => $price * 100,
        );
    }


    function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
