@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-8 sm:px-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Edit Your Profile</h1>
                <p class="text-gray-600 mb-8">Update your information</p>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Profile URL -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700">
                            <strong>Your Profile URL:</strong> 
                            <a href="{{ route('profile.public', $profile->profile_url) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ url('/@' . $profile->profile_url) }}
                            </a>
                        </p>
                    </div>

                    <!-- Contact Information -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Contact Information</h2>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Phone Number
                            </label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone"
                                value="{{ old('phone', $profile->phone) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="+1 (555) 123-4567"
                            >
                            @error('phone')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                Bio
                            </label>
                            <textarea 
                                id="bio" 
                                name="bio"
                                rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Tell others about yourself..."
                            >{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Cryptocurrency Addresses -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Cryptocurrency Addresses</h2>

                        <div>
                            <label for="bitcoin_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Bitcoin Address
                            </label>
                            <input 
                                type="text" 
                                id="bitcoin_address" 
                                name="bitcoin_address"
                                value="{{ old('bitcoin_address', $profile->bitcoin_address) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="1A1z7agoat..."
                            >
                            @error('bitcoin_address')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="ethereum_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Ethereum Address
                            </label>
                            <input 
                                type="text" 
                                id="ethereum_address" 
                                name="ethereum_address"
                                value="{{ old('ethereum_address', $profile->ethereum_address) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0x742d35Cc6634C0532925a3b844Bc9e7595f7..."
                            >
                            @error('ethereum_address')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="other_addresses" class="block text-sm font-medium text-gray-700 mb-2">
                                Other Addresses (JSON format)
                            </label>
                            <textarea 
                                id="other_addresses" 
                                name="other_addresses"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                                placeholder='{"litecoin": "LdT4ubS5NySFHvMad8f...", "ripple": "rN7n7otQDd6FczFgLdlqXD..."}'
                            >{{ old('other_addresses', $profile->other_addresses ? json_encode($profile->other_addresses) : '') }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Optional: Add other cryptocurrency addresses as JSON</p>
                            @error('other_addresses')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">Social Media</h2>

                        <div>
                            <label for="social_media" class="block text-sm font-medium text-gray-700 mb-2">
                                Social Media Links (JSON format)
                            </label>
                            <textarea 
                                id="social_media" 
                                name="social_media"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                                placeholder='{"twitter": "https://twitter.com/...", "github": "https://github.com/..."}'
                            >{{ old('social_media', $profile->social_media ? json_encode($profile->social_media) : '') }}</textarea>
                            <p class="text-gray-500 text-xs mt-1">Optional: Add your social media profiles as JSON</p>
                            @error('social_media')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-6">
                        <button 
                            type="submit"
                            class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            Save Changes
                        </button>
                        <a 
                            href="{{ route('profile.show') }}"
                            class="flex-1 bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors text-center"
                        >
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
