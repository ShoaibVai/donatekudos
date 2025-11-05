@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Dashboard</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($profile)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">{{ $profile->username }}</h2>
                <p class="text-gray-600 mb-4">{{ $profile->bio }}</p>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Contact Info</h3>
                    @if($profile->contact_info)
                        <dl class="text-sm">
                            @foreach($profile->contact_info as $key => $value)
                                <dt class="font-medium">{{ ucfirst($key) }}:</dt>
                                <dd class="text-gray-600 mb-2">{{ $value }}</dd>
                            @endforeach
                        </dl>
                    @else
                        <p class="text-gray-500">No contact information added</p>
                    @endif
                </div>

                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Wallet Addresses</h3>
                    @if($profile->wallet_addresses)
                        <ul class="text-sm space-y-2">
                            @foreach($profile->wallet_addresses as $address)
                                <li class="text-gray-600 break-all">{{ $address }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">No wallet addresses added</p>
                    @endif
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit Profile
                    </a>
                    <a href="{{ route('gallery.manage') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Manage Gallery
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('2fa.enable') }}" class="block bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center">
                        Setup 2FA
                    </a>
                    
                    <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure? This cannot be undone.');">
                        @csrf
                        <button type="button" onclick="showDeleteModal()" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Delete Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Gallery Preview -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Gallery Preview</h2>
            @if($galleries->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($galleries as $gallery)
                        <img src="{{ $gallery->image_url }}" alt="Gallery" class="w-full h-40 object-cover rounded">
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No images in gallery</p>
            @endif
        </div>
    @else
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            No profile found. Please complete your registration.
        </div>
    @endif
</div>

<script>
    function showDeleteModal() {
        const password = prompt('Enter your password to confirm deletion:');
        if (password) {
            const form = document.querySelector('form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'password';
            input.value = password;
            form.appendChild(input);
            form.submit();
        }
    }
</script>
@endsection
