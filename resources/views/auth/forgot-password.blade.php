@extends('layouts.guest')

@section('content')

    <div class="mb-4 text-sm text-gray-600 text-dark-green">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control custom-input" type="email" name="email" :value="old('email')" required autofocus />
           @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="btn btn-success btn-custom">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>

    @endsection
