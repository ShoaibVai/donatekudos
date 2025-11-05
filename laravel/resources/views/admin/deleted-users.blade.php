@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-900">Admin Panel</h1>
                <p class="text-gray-600 mt-2">View deleted users</p>
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
                <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 font-semibold text-gray-600 hover:text-gray-900 border-transparent">
                    Users
                </a>
                <a href="{{ route('admin.deleted-users') }}" class="py-4 px-2 border-b-2 font-semibold {{ request()->route()->getName() === 'admin.deleted-users' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-600 hover:text-gray-900' }}">
                    Deleted Users ({{ $deletedUsers->total() }})
                </a>
            </div>
        </div>

        <!-- Deleted Users Table -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Deleted Users Archive</h2>

                <!-- Search -->
                <form method="GET" action="{{ route('admin.deleted-users') }}" class="mb-6">
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
                            <a href="{{ route('admin.deleted-users') }}" class="bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-lg hover:bg-gray-300 transition-colors">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>

                @if($deletedUsers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Original ID</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deleted At</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deleted By</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($deletedUsers as $deletedUser)
                                    @php
                                        $userData = $deletedUser->user_data;
                                        $name = $userData['name'] ?? 'N/A';
                                        $email = $userData['email'] ?? 'N/A';
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900">#{{ $deletedUser->original_user_id }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $email }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $deletedUser->deleted_at->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">Admin</td>
                                        <td class="px-6 py-4 text-sm">
                                            <button 
                                                onclick="showDetails({{ json_encode($deletedUser->user_data) }})"
                                                class="text-blue-600 hover:text-blue-800 font-medium"
                                            >
                                                View Details
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $deletedUsers->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600">No deleted users found{{ $search ? ' matching "' . $search . '"' : '' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full max-h-96 overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">User Details</h3>
            <button onclick="closeDetails()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>
        <div id="detailsContent" class="px-6 py-4">
            <!-- Content will be inserted here -->
        </div>
    </div>
</div>

<script>
function showDetails(data) {
    const modal = document.getElementById('detailsModal');
    const content = document.getElementById('detailsContent');
    
    let html = '<pre class="text-sm text-gray-700 bg-gray-50 p-4 rounded overflow-x-auto">';
    html += JSON.stringify(data, null, 2);
    html += '</pre>';
    
    content.innerHTML = html;
    modal.classList.remove('hidden');
}

function closeDetails() {
    document.getElementById('detailsModal').classList.add('hidden');
}
</script>
@endsection
