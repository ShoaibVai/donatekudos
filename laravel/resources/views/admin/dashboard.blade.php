@extends('layouts.app')

@section('title', 'Admin Dashboard - DonateKudos')

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1>Admin Dashboard</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div class="card">
            <h2 style="color: #3498db;">{{ $totalUsers }}</h2>
            <p>Active Users</p>
            <a href="{{ route('admin.users') }}" style="color: #3498db; text-decoration: none;">View Users →</a>
        </div>

        <div class="card">
            <h2 style="color: #e74c3c;">{{ $totalDeletedUsers }}</h2>
            <p>Deleted Users</p>
            <a href="{{ route('admin.deleted-users') }}" style="color: #e74c3c; text-decoration: none;">View Deleted Users →</a>
        </div>
    </div>

    <div class="card">
        <h2>Quick Links</h2>
        <ul style="list-style: none;">
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ route('admin.users') }}">Manage Active Users</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ route('admin.deleted-users') }}">View Deleted Users</a>
            </li>
            <li style="margin-bottom: 0.5rem;">
                <a href="{{ route('home') }}">Back to Home</a>
            </li>
        </ul>
    </div>
</div>
@endsection
