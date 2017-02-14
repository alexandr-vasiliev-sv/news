<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'news_id', 'user_id', 'text'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
