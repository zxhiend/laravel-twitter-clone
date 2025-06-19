<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrendingPhrase extends Model
{
    protected $fillable = ['phrase', 'count'];
    public $timestamps = false;
}
