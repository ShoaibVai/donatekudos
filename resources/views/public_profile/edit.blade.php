<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Public Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Profile Settings -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Update your public profile information.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('public_profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <x-input-label for="slug" :value="__('Public URL Slug')" />
                                <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $profile->slug)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                                <p class="text-sm text-gray-500 mt-1">Your profile will be at: {{ url('/') }}/<span x-text="document.getElementById('slug').value"></span></p>
                            </div>

                            <div>
                                <x-input-label for="bio" :value="__('Bio')" />
                                <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                            </div>

                            <div>
                                <x-input-label for="theme" :value="__('Theme')" />
                                <select id="theme" name="theme" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="monochrome" {{ $profile->theme === 'monochrome' ? 'selected' : '' }}>Monochrome (Clean)</option>
                                    <option value="techy" {{ $profile->theme === 'techy' ? 'selected' : '' }}>Techy (8-bit)</option>
                                    <option value="artsy" {{ $profile->theme === 'artsy' ? 'selected' : '' }}>Artsy (Luxurious)</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('theme')" />
                            </div>

                            <!-- Advanced Customization -->
                            <div x-data="{ open: false }">
                                <button type="button" @click="open = !open" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Show Advanced Customization (HTML/CSS)
                                </button>
                                <div x-show="open" class="mt-4 space-y-4">
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-yellow-700">
                                                    <strong>Security Notice:</strong> Custom HTML and CSS are sanitized. JavaScript is disabled for security. Dangerous tags and scripts will be removed.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label for="custom_html" :value="__('Custom HTML (Sanitized)')" />
                                        <textarea id="custom_html" name="custom_html" class="mt-1 block w-full font-mono text-sm border-gray-300 rounded-md" rows="4" placeholder="<div>Your custom HTML here...</div>">{{ old('custom_html', $profile->custom_html) }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">Script tags and event handlers will be removed for security.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="custom_css" :value="__('Custom CSS (Sanitized)')" />
                                        <textarea id="custom_css" name="custom_css" class="mt-1 block w-full font-mono text-sm border-gray-300 rounded-md" rows="4" placeholder=".my-class { color: blue; }">{{ old('custom_css', $profile->custom_css) }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">javascript: and data: URLs will be removed from CSS.</p>
                                    </div>
                                    <div>
                                        <x-input-label for="custom_js" :value="__('Custom JavaScript (Disabled)')" />
                                        <textarea id="custom_js" name="custom_js" class="mt-1 block w-full font-mono text-sm border-gray-300 rounded-md bg-gray-100" rows="4" disabled readonly>{{ __('Custom JavaScript is disabled for security reasons') }}</textarea>
                                        <p class="text-xs text-red-500 mt-1">JavaScript execution is disabled for security purposes.</p>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="template_id" value="1">

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('success'))
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ session('success') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Gallery Images -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Gallery Images') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Upload up to 10 images to showcase on your profile.") }}
                            </p>
                        </header>

                        <div class="mt-6">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                                @foreach($profile->galleryImages as $image)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($image->image_path) }}" class="w-full h-32 object-cover rounded-lg">
                                        <form method="post" action="{{ route('public_profile.image.delete', $image->id) }}" class="absolute top-2 right-2">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600" onclick="return confirm('Delete this image?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>

                            @if($profile->galleryImages->count() < 10)
                                <form method="post" action="{{ route('public_profile.image.upload') }}" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="image" :value="__('Upload Image')" />
                                        <input id="image" name="image" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                                    </div>
                                    <x-primary-button>{{ __('Upload') }}</x-primary-button>
                                </form>
                            @else
                                <p class="text-yellow-600">You have reached the maximum of 10 images.</p>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <a href="{{ route('public_profile.show', $profile->slug) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-bold text-lg">
                        View My Public Profile &rarr;
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
