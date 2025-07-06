@extends('layouts.install')

@section('content')
    @if (session('error'))
        <p class="text-red-600 mb-4">{{ session('error') }}</p>
    @endif

    <div class="min-h-screen min-w-[470px] flex items-center justify-center">
        <div class="w-full max-w-lg bg-white border-2 border-solid rounded-lg p-10 space-y-8">
            <h1 class="text-3xl font-extrabold text-center text-gray-800">Step 3: Final Setup</h1>
            <p class="text-center text-gray-600 text-lg">Please set up the super admin account.</p>

            <form method="POST" action="{{ route('install.postStep3') }}">
                @csrf
                <div class="space-y-4">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Super Admin Name <span class="text-red-500">*</span></label>
                        <input name="admin_name" value="{{ old('admin_name') }}" placeholder="Admin Name" required class="mt-1 block w-full border border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        @error('admin_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Enter the name for the super admin.</p>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Super Admin Email <span class="text-red-500">*</span></label>
                        <input name="admin_email" value="{{ old('admin_email') }}" placeholder="Admin Email" required type="email" class="mt-1 block w-full border border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        @error('admin_email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Enter a valid email address for the super admin.</p>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Super Admin Password <span class="text-red-500">*</span></label>
                        <input name="admin_password" value="{{ old('admin_password') }}" placeholder="Admin Password" required type="password" class="mt-1 block w-full border border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        @error('admin_password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Choose a strong password for the super admin.</p>
                    </div>
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700">Retype Password <span class="text-red-500">*</span></label>
                        <input name="admin_password_confirmation" value="{{ old('admin_password_confirmation') }}" placeholder="Confirm Password" required type="password" class="mt-1 block w-full border border-gray-300 outline-2 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-3" />
                        @error('admin_password_confirmation')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Confirm the password for the admin user.</p>
                    </div>
                </div>

                <div class="w-full flex justify-between mt-6">
                    <a href="{{ route('install.step2') }}"
                    class="px-8 py-3 bg-gray-300 text-white font-semibold rounded-lg hover:bg-gray-400 transition duration-300 transform hover:scale-105 cursor-pointer">
                        Back
                    </a>
                    <button type="submit" class="px-8 py-3 bg-rose-300 text-white font-semibold rounded-lg hover:bg-rose-400 transition duration-300 transform hover:scale-105 cursor-pointer">
                        Install
                    </button>
                </div>
            </form>
            <!-- Overlay -->
            <div id="installing-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="text-center text-white text-xl font-semibold bg-gray-800 bg-opacity-90 px-10 py-6 rounded-2xl shadow-2xl">
                    <p>Installing<span id="dots">.</span></p>
                    <p class="text-sm mt-2 text-gray-300">Please don’t refresh or close this window. The installation may take a few seconds. You will be redirected once installation completed...</p>
                </div>
            </div>

            <!-- JS -->
            <script>
                document.querySelector('form').addEventListener('submit', function () {
                    const overlay = document.getElementById('installing-overlay');
                    overlay.classList.remove('hidden');

                    // Animate dots
                    const dots = document.getElementById('dots');
                    let count = 1;
                    setInterval(() => {
                        dots.textContent = '.'.repeat(count);
                        count = count < 3 ? count + 1 : 1;
                    }, 500);
                });
            </script>
        </div>
    </div>
@endsection
