<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600">{{ __("You're logged in!") }}</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('public_profile.edit') }}" class="block p-4 border border-gray-200 rounded-lg hover:border-indigo-500 hover:shadow transition">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Edit My Profile Page</h4>
                                    <p class="text-sm text-gray-500">Customize your public profile</p>
                                </div>
                            </div>
                        </a>

                        @if(Auth::user()->profile)
                        <a href="{{ route('public_profile.show', Auth::user()->profile->slug) }}" target="_blank" class="block p-4 border border-gray-200 rounded-lg hover:border-green-500 hover:shadow transition">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-900">View Public Profile</h4>
                                    <p class="text-sm text-gray-500">See how others see your page</p>
                                </div>
                            </div>
                        </a>
                        @endif

                        @can('admin')
                        <a href="{{ route('admin.dashboard') }}" class="block p-4 border border-gray-200 rounded-lg hover:border-red-500 hover:shadow transition">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Admin Dashboard</h4>
                                    <p class="text-sm text-gray-500">Manage users and content</p>
                                </div>
                            </div>
                        </a>
                        @endcan
                    </div>
                </div>
            </div>

            @if(Auth::user()->profile)
            <!-- Profile Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900">Your Profile Stats</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Gallery Images</p>
                            <p class="text-2xl font-bold text-gray-900">{{ Auth::user()->profile->galleryImages->count() }}/10</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Theme</p>
                            <p class="text-2xl font-bold text-gray-900 capitalize">{{ Auth::user()->profile->theme }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-500">Profile URL</p>
                            <p class="text-sm font-mono text-indigo-600 truncate">/{{ Auth::user()->profile->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
