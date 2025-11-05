@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- User Count Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Total Users</h2>
            <p class="text-3xl font-bold mt-2">{{ $userCount }}</p>
        </div>

        <!-- Profile Count Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Total Profiles</h2>
            <p class="text-3xl font-bold mt-2">{{ $profileCount }}</p>
        </div>

        <!-- Quick Links Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Quick Actions</h2>
            <div class="mt-4 space-y-2">
                <a href="{{ route('admin.users.index') }}" class="block text-blue-500 hover:text-blue-700">View All Users</a>
                <a href="{{ route('admin.export.xml') }}" class="block text-blue-500 hover:text-blue-700">Export XML</a>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-700">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold">Recent Users</h2>
        </div>
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Created</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($recentUsers as $user)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-500 hover:text-blue-700">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
