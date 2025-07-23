@extends('layouts.guest')

@section('content')

@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif

<h4 class="mb-4 text-center text-dark-green">Register</h4>

<p class="text-muted text-center mb-4 text-dark-green">Please register a new account to continue.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input id="name" type="text" class="form-control custom-input border-bottom-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input id="email" type="email" class="form-control custom-input border-bottom-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
        @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input id="password" type="password" class="form-control custom-input border-bottom-input @error('password') is-invalid @enderror" name="password" required>
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input id="password_confirmation" type="password" class="form-control custom-input border-bottom-input" name="password_confirmation" required>
    </div>

    <!-- Remember Me (Optional) -->
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input custom-checkbox" id="remember_me" name="remember">
        <label class="form-check-label text-dark-green" for="remember_me">Remember Me</label>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('login') }}" class="text-decoration-none text-dark-green text-secondary">Already registered?</a>
        <button type="submit" class="btn btn-success px-4 btn-custom">Register</button>
    </div>
</form>

@endsection