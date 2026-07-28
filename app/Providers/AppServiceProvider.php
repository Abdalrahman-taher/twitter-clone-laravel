<?php

namespace App\Providers;

use App\Models\Tweet;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('home.left-sidebar', function ($view) {
            $unreadNotificationsCount = 0;

            if (auth()->check()) {
                $unreadNotificationsCount = auth()
                    ->user()
                    ->notifications()
                    ->whereNull('read_at')
                    ->count();
            }

            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });

        View::composer('home.right-sidebar', function ($view) {
            $trendCounts = [];

            $trendTweets = Tweet::latest()
                ->limit(50)
                ->pluck('body');

            foreach ($trendTweets as $body) {

                $words = explode(' ', $body);

                foreach ($words as $word) {

                    $hashtag = trim($word, " \n\r\t\v\0.,!?;:()[]{}\"'");

                    if (! str_starts_with($hashtag, '#')) {
                        continue;
                    }

                    if (strlen($hashtag) <= 1) {
                        continue;
                    }

                    if (! isset($trendCounts[$hashtag])) {
                        $trendCounts[$hashtag] = 0;
                    }

                    $trendCounts[$hashtag]++;
                }
            }

            $trends = collect($trendCounts)
                ->sortDesc()
                ->take(4)
                ->map(function ($count, $hashtag) {
                    return [
                        'hashtag' => $hashtag,
                        'tweets_count' => $count,
                    ];
                })
                ->values();

            $view->with('trends', $trends);
        });
    }
}
