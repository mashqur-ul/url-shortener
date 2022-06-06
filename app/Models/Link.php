<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'url',
        'hash',
        'status',
    ];

    public function shortUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => config('app.url').'/'.$attributes['hash'],
        );
    }
}
