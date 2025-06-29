@extends('layouts.install') {{-- Extend the same layout as Step 1 --}}

@section('content')
    {{-- The main container with the background and centering, matching the install-step1-view --}}
    <div class="min-h-screen min-w-[470px] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        {{-- The content box, matching the design of the installer's steps --}}
        <div class="w-full max-w-xl bg-white rounded-xl border-2 border-solid rounded-lg p-10 space-y-8 transform transition duration-300">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 leading-tight">
                <span class="block">🛠️ Setup Required</span>
                <span class="block text-xl font-semibold text-gray-600 mt-2">Your Application Needs Configuration</span>
            </h1>
            <p class="text-center text-gray-700 text-lg leading-relaxed">
                It looks like this application hasn't been set up yet. Please click the button below to start the quick installation process.
            </p>

            <div class="w-full flex justify-center mt-6">
                <a href="{{ $installationUrl }}"
                    class="px-10 py-4 bg-rose-400 text-white font-bold rounded-lg shadow-md hover:bg-rose-400 focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-opacity-75 transition duration-300 transform hover:scale-105 cursor-pointer">
                    Start Installation &rarr;
                </a>
            </div>

            <hr class="border-t border-gray-200 my-8">

            <p class="text-center text-sm text-blue-600 leading-relaxed bg-blue-50 p-3 rounded-lg">
                <span class="font-semibold">Need help?</span> If you're unsure how to proceed, please consult the application's documentation or contact support.
            </p>
        </div>
    </div>
@endsection
