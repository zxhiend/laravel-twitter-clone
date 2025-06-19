<?php
// app/Models/Tweet.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tweet extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['content', 'user_id'];

    // app/Models/Tweet.php
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    // Menambahkan method untuk menampilkan waktu tweet dalam format yang mudah dibaca
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans(); // Menggunakan Carbon untuk format waktu seperti '2 hours ago'
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'created_at' => $this->getOriginal('created_at'),
        ];
    }

    /**
     * Extract hashtags from the tweet content.
     */
    public function extractHashtags()
    {
        // Only match words that start with # and are not just a single #
        preg_match_all('/#(\w{1,50})/u', $this->content, $matches);
        return array_filter($matches[1] ?? [], function($tag) {
            return !empty($tag);
        });
    }

    /**
     * Extract the main trending phrase from the tweet content (most frequent word, excluding hashtags).
     */
    public function extractTrendingPhrase()
    {
        // Remove hashtags
        $content = preg_replace('/#\w+/u', '', $this->content);
        // Split into words
        $words = preg_split('/\s+/', trim($content));
        $words = array_filter($words, function($w) { return !empty($w); });
        if (empty($words)) return null;
        // Count frequency
        $counts = array_count_values(array_map('mb_strtolower', $words));
        arsort($counts);
        // Return the most frequent word
        return array_key_first($counts);
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
