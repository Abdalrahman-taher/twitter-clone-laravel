<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-[#15202b] shadow sm:rounded-lg overflow-hidden">

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PATCH')

                    {{-- Cover image --}}
                    <div class="relative w-full h-48 bg-gray-800 bg-cover bg-center"
                         @if($user->cover)
                             style="background-image: url('{{ asset('storage/' . $user->cover) }}');"
                        @endif>

                        {{-- Upload cover input --}}
                        <input type="file" id="coverInput" name="cover" accept="image/*" class="hidden">

                        <label for="coverInput"
                               class="absolute bottom-3 right-3 cursor-pointer bg-black/60 hover:bg-black/80 text-white p-2 rounded-full">
                            <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </label>
                    </div>

                    <div class="px-4 pb-6">

                        <div class="flex justify-between items-start">

                            {{-- Profile image --}}
                            <div class="-mt-16 relative">
                                <div class="h-32 w-32 rounded-full border-4 border-[#15202b] bg-gray-700 overflow-hidden flex items-center justify-center">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <svg class="h-16 w-16 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10zM4 22a8 8 0 1116 0H4z"/>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Upload avatar input --}}
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden">

                                <label for="avatarInput"
                                       class="absolute bottom-1 right-1 cursor-pointer bg-black/60 hover:bg-black/80 text-white p-1.5 rounded-full">
                                    <svg class="h-4 w-4" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <circle cx="12" cy="13" r="3"/>
                                    </svg>
                                </label>
                            </div>

                            {{-- Save button --}}
                            <button type="submit"
                                    class="mt-3 bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-full">
                                Save
                            </button>
                        </div>

                        {{-- Name --}}
                        <div class="mt-3">
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                   placeholder="Name"
                                   class="bg-transparent w-full text-xl font-bold text-white focus:outline-none border-b border-transparent focus:border-blue-400">
                        </div>

                        {{-- Username --}}
                        <div class="flex items-center text-gray-500">
                            <span>@</span>
                            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                   placeholder="username"
                                   class="bg-transparent w-full text-sm font-medium text-gray-500 focus:outline-none border-b border-transparent focus:border-blue-400">
                        </div>

                        {{-- Bio --}}
                        <div class="mt-3">
                            <textarea name="bio" rows="2" placeholder="Bio"
                                      class="bg-transparent w-full text-white leading-tight focus:outline-none resize-none">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        {{-- Location and Website --}}
                        <div class="text-gray-500 flex flex-wrap gap-x-4 gap-y-2 mt-2">

                            {{-- Location --}}
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <input type="text" name="location" value="{{ old('location', $user->location) }}"
                                       placeholder="Location"
                                       class="bg-transparent text-gray-500 focus:outline-none border-b border-transparent focus:border-blue-400">
                            </span>

                            {{-- Website --}}
                            <span class="flex items-center">
                                <svg class="h-5 w-5 mr-1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5"/>
                                    <path d="M10.172 13.828a4 4 0 010-5.656l3-3a4 4 0 015.656 5.656l-1.5 1.5"/>
                                </svg>
                                <input type="text" name="website" value="{{ old('website', $user->website) }}"
                                       placeholder="Website"
                                       class="bg-transparent text-blue-400 focus:outline-none border-b border-transparent focus:border-blue-400">
                            </span>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
