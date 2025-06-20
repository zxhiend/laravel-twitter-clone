<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Bookmark extends Pivot
{
    protected $table = 'bookmarks';
    protected $fillable = ['user_id', 'tweet_id'];
    public function tweets() {
        return $this->belongsTo(Tweet::class, 'tweet_id', 'id');
    }
}
