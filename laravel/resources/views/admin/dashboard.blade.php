@extends('layouts.app')

@section('title', 'Admin Dashboard - DonateKudos')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <div>
            <h1 class="text-4xl font-bold gradient-text mb-2">Admin Dashboard</h1>
            <p class="text-gray-600">System overview and quick access to management tools</p>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-4 md:mt-0">
            @csrf
            <button type="submit" class="btn-secondary">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Active Users Card -->
        <div class="card group hover:shadow-lg transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                        </svg>
                    </div>
                    <a href="{{ route('admin.users') }}" class="text-blue-600 hover:text-blue-700 font-semibold text-sm">View →</a>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalUsers }}</p>
                <p class="text-sm text-gray-600">Active Users</p>
            </div>
        </div>

        <!-- Deleted Users Card -->
        <div class="card group hover:shadow-lg transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-red-100">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <a href="{{ route('admin.deleted-users') }}" class="text-red-600 hover:text-red-700 font-semibold text-sm">View →</a>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalDeletedUsers }}</p>
                <p class="text-sm text-gray-600">Deleted Users</p>
            </div>
        </div>

        <!-- Ratio Card -->
        <div class="card">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-600">Archive %</span>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">
                    @php
                        $ratio = $totalUsers > 0 ? round(($totalDeletedUsers / ($totalUsers + $totalDeletedUsers)) * 100, 1) : 0;
                        echo $ratio;
                    @endphp%
                </p>
                <p class="text-sm text-gray-600">Deletion Rate</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card">
        <div class="border-b border-gray-200 px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Quick Actions</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('admin.users') }}" class="p-4 border-2 border-purple-200 hover:border-purple-600 hover:bg-purple-50 rounded-lg transition flex items-center gap-3">
                    <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM9 12a6 6 0 11-12 0 6 6 0 0112 0z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Manage Active Users</p>
                        <p class="text-xs text-gray-600">View and manage active user accounts</p>
                    </div>
                </a>

                <a href="{{ route('admin.deleted-users') }}" class="p-4 border-2 border-red-200 hover:border-red-600 hover:bg-red-50 rounded-lg transition flex items-center gap-3">
                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">View Deleted Users</p>
                        <p class="text-xs text-gray-600">Access archived user records</p>
                    </div>
                </a>

                <a href="{{ route('home') }}" class="p-4 border-2 border-gray-200 hover:border-gray-600 hover:bg-gray-50 rounded-lg transition flex items-center gap-3">
                    <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">Back to Home</p>
                        <p class="text-xs text-gray-600">Return to the main website</p>
                    </div>
                </a>

                <button onclick="alert('Feature coming soon!')" class="p-4 border-2 border-blue-200 hover:border-blue-600 hover:bg-blue-50 rounded-lg transition flex items-center gap-3 w-full text-left">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zm4 2v4h8V8H6z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold text-gray-900">System Settings</p>
                        <p class="text-xs text-gray-600">Configure system preferences</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
