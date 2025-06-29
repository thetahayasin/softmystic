@extends('layouts.install')

@section('content')
    <div class="min-h-screen min-w-[470px] flex items-center justify-center py-10">
        <div class="w-full max-w-lg bg-white border-2 border-solid rounded-lg p-10 space-y-8 shadow-xl">
            <h1 class="text-3xl font-extrabold text-center text-gray-800">Step 2: Database & Mail Setup</h1>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('install.postStep2') }}" class="space-y-6">
                @csrf

                <!-- Database Settings Section -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2">Database Settings</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="db_connection" class="block text-sm font-medium text-gray-700">Connection <span class="text-red-500">*</span></label>
                            <input id="db_connection" name="db_connection" value="{{ old('db_connection', env('DB_CONNECTION', 'mysql')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_connection') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">e.g., mysql or pgsql</p>
                            @error('db_connection')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_host" class="block text-sm font-medium text-gray-700">Host <span class="text-red-500">*</span></label>
                            <input id="db_host" name="db_host" value="{{ old('db_host', env('DB_HOST', '127.0.0.1')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_host') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Typically "127.0.0.1" or "localhost"</p>
                            @error('db_host')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_port" class="block text-sm font-medium text-gray-700">Port <span class="text-red-500">*</span></label>
                            <input id="db_port" name="db_port" value="{{ old('db_port', env('DB_PORT', '3306')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_port') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Default MySQL port is 3306</p>
                            @error('db_port')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_database" class="block text-sm font-medium text-gray-700">Database Name <span class="text-red-500">*</span></label>
                            <input id="db_database" name="db_database" value="{{ old('db_database', env('DB_DATABASE')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_database') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Name of the database to use</p>
                            @error('db_database')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_username" class="block text-sm font-medium text-gray-700">Database Username <span class="text-red-500">*</span></label>
                            <input id="db_username" name="db_username" value="{{ old('db_username', env('DB_USERNAME')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_username') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Your database user account username</p>
                            @error('db_username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="db_password" class="block text-sm font-medium text-gray-700">Database Password</label>
                            <input id="db_password" name="db_password" value="{{ old('db_password', env('DB_PASSWORD')) }}" type="password"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('db_password') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Leave empty if not set</p>
                            @error('db_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-t border-gray-200">

                <!-- Application Settings Section -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2">Application Settings</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="app_name" class="block text-sm font-medium text-gray-700">App Name <span class="text-red-500">*</span></label>
                            <input id="app_name" name="app_name" value="{{ old('app_name', env('APP_NAME', 'MyApp')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('app_name') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Displayed in browser title and emails</p>
                            @error('app_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="app_url" class="block text-sm font-medium text-gray-700">App URL <span class="text-red-500">*</span></label>
                            <input id="app_url" name="app_url" value="{{ old('app_url', env('APP_URL', 'http://localhost')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('app_url') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">e.g., http://localhost or your live URL (https://example.com)</p>
                            @error('app_url')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-t border-gray-200">

                <!-- Mail Settings Section -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2">Mail Settings</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="mail_mailer" class="block text-sm font-medium text-gray-700">Mail Driver</label>
                            <input id="mail_mailer" name="mail_mailer" value="{{ old('mail_mailer', env('MAIL_MAILER', 'smtp')) }}"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_mailer') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">e.g., smtp, mailgun, ses, log (for debugging)</p>
                            @error('mail_mailer')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_host" class="block text-sm font-medium text-gray-700">Mail Host</label>
                            <input id="mail_host" name="mail_host" value="{{ old('mail_host', env('MAIL_HOST', 'mailpit.local')) }}"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_host') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">The host address of your mail server</p>
                            @error('mail_host')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_port" class="block text-sm font-medium text-gray-700">Mail Port</label>
                            <input id="mail_port" name="mail_port" value="{{ old('mail_port', env('MAIL_PORT', '1025')) }}"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_port') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Common ports: 587 (TLS), 465 (SSL), 25 (unencrypted)</p>
                            @error('mail_port')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_username" class="block text-sm font-medium text-gray-700">Mail Username</label>
                            <input id="mail_username" name="mail_username" value="{{ old('mail_username', env('MAIL_USERNAME')) }}"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_username') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Username for SMTP authentication (leave empty if not required)</p>
                            @error('mail_username')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_password" class="block text-sm font-medium text-gray-700">Mail Password</label>
                            <input id="mail_password" name="mail_password" value="{{ old('mail_password', env('MAIL_PASSWORD')) }}" type="password"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_password') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">Password for SMTP authentication (leave empty if not required)</p>
                            @error('mail_password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_encryption" class="block text-sm font-medium text-gray-700">Mail Encryption</label>
                            <input id="mail_encryption" name="mail_encryption" value="{{ old('mail_encryption', env('MAIL_ENCRYPTION', 'tls')) }}"
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_encryption') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">e.g., tls, ssl (leave empty for none)</p>
                            @error('mail_encryption')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mail_from_address" class="block text-sm font-medium text-gray-700">Mail From Address <span class="text-red-500">*</span></label>
                            <input id="mail_from_address" name="mail_from_address" value="{{ old('mail_from_address', env('MAIL_FROM_ADDRESS', 'hello@example.com')) }}" required
                                class="mt-1 block w-full border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3 @error('mail_from_address') border-red-500 @enderror" />
                            <p class="text-xs text-gray-500 mt-1">The email address that sends emails</p>
                            @error('mail_from_address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>




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
