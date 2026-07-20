<?php

namespace App\Traits;

use App\Models\Tweet;
use Illuminate\Http\Request;

trait HandlesMediaUploads
{
    /**
     * Upload images and videos to a tweet (or reply).
     */
    protected function uploadMedia(
        Request $request,
        Tweet $tweet,
        string $imageInput = 'images',
        string $videoInput = 'videos',
        string $collection = 'tweet'
    ): void
    {
        // =====================================================
        // Upload Images
        // =====================================================

        if ($request->hasFile($imageInput)) {

            foreach ($request->file($imageInput) as $image) {

                $path = $image->store('tweets/images', 'public');

                $tweet->medias()->create([
                    'collection' => $collection,
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }

        // =====================================================
        // Upload Videos
        // =====================================================

        if ($request->hasFile($videoInput)) {

            foreach ($request->file($videoInput) as $video) {

                $path = $video->store('tweets/videos', 'public');

                $tweet->medias()->create([
                    'collection' => $collection,
                    'path' => $path,
                    'mime_type' => $video->getMimeType(),
                    'size' => $video->getSize(),
                ]);
            }
        }
    }
}
