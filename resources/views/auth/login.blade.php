@extends('auth.layouts.app')
@section('title', 'Login')

@section('content')
  <div class="container" id="container">
    <div class="form-container sign-in">
      <form method="POST" action="{{ route('login.custom') }}">
        @csrf
        <h1 class="title-brand">Sign In</h1>

        <div class="spacer-30"></div>

        <input
          id="email"
          type="email"
          class="form-control @error('email') is-invalid @enderror"
          name="email"
          value="{{ old('email') }}"
          placeholder="Email"
          required
          autocomplete="email"
          autofocus
        />
        @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror

        <input
          id="password"
          type="password"
          class="form-control @error('password') is-invalid @enderror"
          name="password"
          placeholder="password"
          required
          autocomplete="current-password"
        />

        @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror

        <div class="form-check">
          <input
            class="form-check-input"
            type="checkbox"
            name="remember"
            id="remember"
            {{ old('remember') ? 'checked' : '' }}
          />

          <label class="form-check-label" for="remember">RememberMe</label>
        </div>
        <div class="spacer-10"></div>

        <button type="submit">Sign In</button>
      </form>
    </div>
    <div class="toggle-container">
      <div class="toggle">
        <div class="toggle-panel toggle-left">
          <img
            class="logo-brand"
            src="{{ asset('images/logo_meta.png') }}"
            alt="logo"
          />
          <button class="hidden" id="login">Sign In</button>
        </div>
        <div class="toggle-panel toggle-right">
          <img
            class="logo-brand"
            src="{{ asset('images/logo_meta.png') }}"
            alt="logo"
          />
        </div>
      </div>
    </div>
  </div>
@endsection
