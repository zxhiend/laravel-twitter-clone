<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Like extends Pivot
{
    protected $table = 'likes';

    protected $fillable = ['user_id', 'tweet_id'];
}
