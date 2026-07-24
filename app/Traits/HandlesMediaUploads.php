<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait HandlesMediaUploads
{
    /**
     * Upload images and videos for any model using morphMany media.
     */
    protected function uploadMedia(
        Request $request,
                $model,
        string $imageInput = 'images',
        string $videoInput = 'videos',
        string $collection = 'default'
    ): void
    {

        // Upload Images
        if ($request->hasFile($imageInput)) {

            foreach ($request->file($imageInput) as $image) {

                $path = $image->store('media/images', 'public');

                $model->medias()->create([
                    'collection' => $collection,
                    'path' => $path,
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);
            }
        }


        // Upload Videos
        if ($request->hasFile($videoInput)) {

            foreach ($request->file($videoInput) as $video) {

                $path = $video->store('media/videos', 'public');

                $model->medias()->create([
                    'collection' => $collection,
                    'path' => $path,
                    'mime_type' => $video->getMimeType(),
                    'size' => $video->getSize(),
                ]);
            }
        }
    }
}
