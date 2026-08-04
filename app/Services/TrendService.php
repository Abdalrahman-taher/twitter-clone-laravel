<?php

namespace App\Services;

use App\Models\Retweet;
use App\Models\Tweet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TrendService
{
    private const CACHE_KEY = 'global_trending_hashtags';

    public function topHashtags(): Collection
    {
        $trends = Cache::remember(self::CACHE_KEY, now()->addMinutes(5), function () {
            $counts = [];

            Tweet::query()
                ->select('body')
                ->pluck('body')
                ->each(function (?string $body) use (&$counts) {
                    $this->countHashtags($counts, $body);
                });

            Retweet::query()
                ->with(['tweet:id,body'])
                ->select('id', 'tweet_id')
                ->get()
                ->each(function (Retweet $retweet) use (&$counts) {
                    $this->countHashtags($counts, $retweet->tweet?->body);
                });

            return collect($counts)
                ->sortDesc()
                ->take(10)
                ->map(function (int $count, string $hashtag) {
                    return [
                        'hashtag' => $hashtag,
                        'tweets_count' => $count,
                    ];
                })
                ->values()
                ->all();
        });

        return collect($trends);
    }

    private function countHashtags(array &$counts, ?string $body): void
    {
        foreach ($this->extractHashtags($body) as $hashtag) {
            $counts[$hashtag] = ($counts[$hashtag] ?? 0) + 1;
        }
    }

    private function extractHashtags(?string $body): array
    {
        if (blank($body)) {
            return [];
        }

        preg_match_all('/(?<![\p{L}\p{N}_])#[\p{L}\p{N}_]+/u', $body, $matches);

        return collect($matches[0])
            ->map(fn (string $hashtag) => '#' . Str::lower(Str::after($hashtag, '#')))
            ->unique()
            ->values()
            ->all();
    }
}
