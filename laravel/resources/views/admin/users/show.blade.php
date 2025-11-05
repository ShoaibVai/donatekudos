@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">User Details</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- User Info -->
        <div class="col-span-2 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">{{ $user->email }}</h2>

            @if($profile)
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-2">{{ $profile->username }}</h3>
                    <p class="text-gray-600 mb-4">{{ $profile->bio }}</p>

                    @if($profile->contact_info)
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Contact Info</h4>
                            <dl class="text-sm space-y-1">
                                @foreach($profile->contact_info as $key => $value)
                                    <div>
                                        <dt class="font-medium">{{ ucfirst($key) }}:</dt>
                                        <dd class="text-gray-600">{{ $value }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    @endif

                    @if($profile->wallet_addresses)
                        <div class="mb-4">
                            <h4 class="font-semibold mb-2">Wallet Addresses</h4>
                            <ul class="text-sm space-y-1">
                                @foreach($profile->wallet_addresses as $address)
                                    <li class="text-gray-600 break-all">{{ $address }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-gray-500 mb-4">No profile created yet</p>
            @endif
        </div>

        <!-- Stats -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold text-lg mb-4">User Stats</h3>
            <dl class="space-y-3 text-sm">
                <div>
                    <dt class="text-gray-500">Email Verified</dt>
                    <dd class="font-semibold">{{ $user->email_verified_at ? 'Yes' : 'No' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Registered</dt>
                    <dd class="font-semibold">{{ $user->created_at->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Gallery Images</dt>
                    <dd class="font-semibold">{{ $galleries->count() }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Gallery -->
    @if($galleries->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-semibold mb-6">Gallery</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($galleries as $gallery)
                    <img src="{{ $gallery->image_url }}" alt="Gallery" class="w-full h-40 object-cover rounded">
                @endforeach
            </div>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}" class="text-blue-500 hover:text-blue-700">← Back to Users</a>
    </div>
</div>
@endsection
