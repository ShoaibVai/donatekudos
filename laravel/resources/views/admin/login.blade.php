@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white rounded-lg shadow-sm">
        <div class="px-6 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 text-center">Admin Panel</h1>
            <p class="text-gray-600 text-center mb-8">Enter admin password to continue</p>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.verify') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Admin Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Enter password"
                        required
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors"
                >
                    Access Admin Panel
                </button>
            </form>

            <hr class="my-6">

            <p class="text-gray-600 text-sm text-center">
                <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">Back to Home</a>
            </p>
        </div>
    </div>
</div>
@endsection
