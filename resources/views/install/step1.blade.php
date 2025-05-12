@extends('layouts.install')

@section('content')
    @php
        $canProceed = $requirements['php']['status'] &&
                      $requirements['laravel']['status'] &&
                      collect($extensions)->every(fn($ext) => extension_loaded($ext));
    @endphp

    <div class="min-h-screen min-w-[470px] flex items-center justify-center">
        <div class="w-full max-w-lg bg-white border-2 border-solid rounded-lg p-10 space-y-8">
            <h1 class="text-3xl font-extrabold text-center text-gray-800">Step 1: Check Requirements</h1>
            <p class="text-center text-gray-600 text-lg">Please ensure that your system meets the necessary requirements.</p>

            <div class="space-y-6">
                <ul class="space-y-4 text-md text-gray-700">
                    <li class="flex justify-between">
                        <span>PHP Version ({{ $requirements['php']['required'] }}+):</span>
                        <span class="font-semibold">
                            @if ($requirements['php']['status'])
                                <span class="text-green-500">✅</span>
                            @else
                                <span class="text-red-500">❌</span>
                            @endif
                            {{ $requirements['php']['current'] }}
                        </span>
                    </li>

                    <li class="flex justify-between">
                        <span>Laravel Version ({{ $requirements['laravel']['required'] }}+):</span>
                        <span class="font-semibold">
                            @if ($requirements['laravel']['status'])
                                <span class="text-green-500">✅</span>
                            @else
                                <span class="text-red-500">❌</span>
                            @endif
                            {{ $requirements['laravel']['current'] }}
                        </span>
                    </li>

                    @foreach ($extensions as $ext)
                        <li class="flex justify-between">
                            <span>{{ $ext }} Extension:</span>
                            <span class="font-semibold">
                                @if (extension_loaded($ext))
                                    <span class="text-green-500">✅ Installed</span>
                                @else
                                    <span class="text-red-500">❌ Not Installed</span>
                                @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <form method="POST" action="{{ route('install.postStep1') }}">
                @csrf
                <div class="w-full flex justify-end mt-6">
                    <button type="submit"
                        class="{{ $canProceed 
                            ? 'px-8 py-3 bg-rose-300 text-white font-semibold rounded-lg hover:bg-rose-400 transition duration-300 transform hover:scale-105 cursor-pointer'
                            : 'px-8 py-3 bg-rose-200 text-white font-semibold rounded-lg opacity-60 cursor-not-allowed' }}"
                        {{ $canProceed ? '' : 'disabled' }}>
                        Next
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
