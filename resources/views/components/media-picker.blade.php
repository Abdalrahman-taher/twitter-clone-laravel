@props([
    'imageInput' => 'images',
    'videoInput' => 'videos',
])

{{-- ========================================= --}}
{{-- Media Picker Component                    --}}
{{-- Reusable for Tweets, Comments, Chats ... --}}
{{-- ========================================= --}}

<div class="flex">

    <div class="w-10"></div>

    <div class="w-64 px-2">

        <div class="flex">

            {{-- Image Upload --}}
            <div class="flex-1 text-center px-1 py-1 m-2">

                <label
                    for="{{ $imageInput }}"
                    class="cursor-pointer mt-1 group flex items-center justify-center text-blue-400 px-2 py-2 rounded-full hover:bg-gray-800 hover:text-blue-300">

                    <svg
                        class="h-7 w-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">

                        <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                    </svg>

                </label>

                <input
                    id="{{ $imageInput }}"
                    type="file"
                    name="{{ $imageInput }}[]"
                    class="hidden"
                    accept="image/*"
                    multiple>

            </div>

            {{-- Video Upload --}}
            <div class="flex-1 text-center py-2 m-2">

                <label
                    for="{{ $videoInput }}"
                    class="cursor-pointer mt-1 group flex items-center justify-center text-blue-400 px-2 py-2 rounded-full hover:bg-gray-800 hover:text-blue-300">

                    <svg
                        class="h-7 w-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">

                        <path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>

                        <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                    </svg>

                </label>

                <input
                    id="{{ $videoInput }}"
                    type="file"
                    name="{{ $videoInput }}[]"
                    class="hidden"
                    accept="video/*"
                    multiple>

            </div>

        </div>

        {{-- Preview Placeholder --}}
        <div id="media-preview"></div>

    </div>

</div>
