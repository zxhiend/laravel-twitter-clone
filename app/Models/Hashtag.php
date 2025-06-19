<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['tag', 'count'];
    public $timestamps = false;
}
