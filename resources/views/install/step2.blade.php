@extends('layouts.install')

@section('content')
    <div class="min-h-screen min-w-[470px] flex items-center justify-center">
        <div class="w-full max-w-lg bg-white border-2 border-solid rounded-lg p-10 space-y-8">
            <h1 class="text-3xl font-extrabold text-center text-gray-800">Step 2: Database Setup</h1>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('install.postStep2') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Connection <span class="text-red-500">*</span></label>
                        <input name="db_connection" value="{{ old('db_connection', env('DB_CONNECTION', 'mysql')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">mysql or pgsql</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Host <span class="text-red-500">*</span></label>
                        <input name="db_host" value="{{ old('db_host', env('DB_HOST', '127.0.0.1')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Typically "127.0.0.1" or "localhost"</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Port <span class="text-red-500">*</span></label>
                        <input name="db_port" value="{{ old('db_port', env('DB_PORT', '3306')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Default MySQL port is 3306</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Database <span class="text-red-500">*</span></label>
                        <input name="db_database" value="{{ old('db_database', env('DB_DATABASE')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Name of the database to use</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username <span class="text-red-500">*</span></label>
                        <input name="db_username" value="{{ old('db_username', env('DB_USERNAME')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Your database user account</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input name="db_password" value="{{ old('db_password', env('DB_PASSWORD')) }}" type="password"
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Leave empty if not set</p>
                    </div>
                </div>

                <hr class="my-4 border-t">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">App Name <span class="text-red-500">*</span></label>
                        <input name="app_name" value="{{ old('app_name', env('APP_NAME', 'MyApp')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">Displayed in browser title and emails</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">App URL <span class="text-red-500">*</span></label>
                        <input name="app_url" value="{{ old('app_url', env('APP_URL', 'http://localhost')) }}" required
                            class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        <p class="text-xs text-gray-500 mt-1">e.g. http://localhost or your live URL eg. https://example.com</p>
                    </div>
                </div>

                <div class="w-full flex justify-between mt-6">
                    <!-- Back Button (left) -->
                    <a href="{{ route('install.step1') }}"
                    class="px-8 py-3 bg-gray-300 text-white font-semibold rounded-lg hover:bg-gray-400 transition duration-300 transform hover:scale-105 cursor-pointer">
                        Back
                    </a>

                    <!-- Next Button (right) -->
                    <button type="submit"
                        class="px-8 py-3 bg-rose-300 text-white font-semibold rounded-lg hover:bg-rose-400 transition duration-300 transform hover:scale-105 cursor-pointer">
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
