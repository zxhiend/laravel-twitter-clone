<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TrendingPhrase;
use App\Models\Tweet;

class CleanUpTrends extends Command
{
    protected $signature = 'trends:cleanup';
    protected $description = 'Remove invalid or low-count trending phrases';

    public function handle()
    {
        // Remove phrase trends with count < 5 or not found in any tweet
        $deleted = 0;
        foreach (\App\Models\TrendingPhrase::all() as $phrase) {
            // Check if phrase is found in any tweet (case-insensitive, word boundary)
            $count = Tweet::whereRaw('LOWER(content) REGEXP ?', [
                '[[:<:]]' . preg_quote(strtolower($phrase->phrase), '/') . '[[:>:]]'
            ])->count();
            if ($phrase->count < 5 || $count === 0) {
                $phrase->delete();
                $deleted++;
            } else {
                $phrase->count = $count;
                $phrase->save();
            }
        }
        // Remove hashtag trends with no tweets
        $hashtagTrends = \App\Models\Hashtag::all();
        $removed = 0;
        foreach ($hashtagTrends as $hashtag) {
            $count = Tweet::where('content', 'LIKE', '%#'.$hashtag->tag.'%')->count();
            if ($count == 0) {
                $hashtag->delete();
                $removed++;
            } else {
                $hashtag->count = $count;
                $hashtag->save();
            }
        }
        $this->info("Deleted $deleted invalid trending phrases and $removed invalid hashtags.");
    }
}
