@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Admin Panel</h1>
                <p class="text-gray-600 mt-2">Manage users and view system data</p>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-red-700 transition-colors">
                    Logout
                </button>
            </form>
        </div>

        <!-- Navigation Tabs -->
        <div class="bg-white rounded-lg shadow-sm mb-8 border-b border-gray-200">
            <div class="flex gap-8 px-6">
                <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 font-semibold {{ request()->route()->getName() === 'admin.dashboard' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                    Users ({{ $users->total() }})
                </a>
                <a href="{{ route('admin.deleted-users') }}" class="py-4 px-2 border-b-2 font-semibold text-gray-600 hover:text-gray-900 border-transparent">
                    Deleted Users
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Total Users</h2>
                <p class="text-4xl font-bold text-blue-600">{{ $users->total() }}</p>
            </div>
            <a href="{{ route('admin.export-xml') }}" class="bg-green-600 text-white rounded-lg shadow-sm p-6 hover:bg-green-700 transition-colors flex items-center justify-center">
                <div class="text-center">
                    <h2 class="text-lg font-semibold mb-2">Export Data</h2>
                    <p class="text-sm">Download all users as XML</p>
                </div>
            </a>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Users</h2>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6">
                    <div class="flex gap-4">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Search by name or email..."
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                            Search
                        </button>
                        @if($search)
                            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>

                @if($users->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Profile</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $user->id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($user->profile)
                                                <a href="{{ route('profile.public', $user->profile->profile_url) }}" target="_blank" class="text-blue-600 hover:underline">
                                                    @{{ $user->profile->profile_url }}
                                                </a>
                                            @else
                                                <span class="text-gray-500">No profile</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600">No users found{{ $search ? ' matching "' . $search . '"' : '' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
