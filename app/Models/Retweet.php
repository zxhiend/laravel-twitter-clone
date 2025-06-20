<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Retweet extends Pivot
{
    protected $table = 'retweets';

    protected $fillable = ['user_id', 'tweet_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
