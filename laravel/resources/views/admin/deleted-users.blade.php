@extends('layouts.app')

@section('title', 'Deleted Users - DonateKudos Admin')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Deleted Users Archive</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    @if($deletedUsers->count() > 0)
        <div class="card" style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th>Deleted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>{{ $user->deleted_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.export-xml', $user->id) }}" style="color: #3498db; text-decoration: none;">Export XML</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 2rem;">
            {{ $deletedUsers->links() }}
        </div>
    @else
        <div class="card">
            <p>No deleted users found.</p>
        </div>
    @endif

    <div style="margin-top: 1rem;">
        <a href="{{ route('admin.dashboard') }}" style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #95a5a6; color: white; text-decoration: none; border-radius: 4px;">Back to Dashboard</a>
    </div>
</div>
@endsection
