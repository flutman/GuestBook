<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'text'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
