<?php

namespace App\Traits;

use App\Models\Tweet;
use Illuminate\Http\Request;

trait HandlesMediaUploads
{
    /**
     * Upload images and videos to a tweet (or reply).
     */
    protected function uploadMedia(Request $request, Tweet $tweet): void
    {
        // Upload Images
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('tweets/images', 'public');

                $tweet->medias()->create([
                    'collection' => 'tweet',
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }

        // Upload Videos
        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $video) {

                $path = $video->store('tweets/videos', 'public');

                $tweet->medias()->create([
                    'collection' => 'tweet',
                    'path' => $path,
                    'mime_type' => $video->getMimeType(),
                    'size' => $video->getSize(),
                ]);
            }
        }
    }
}
