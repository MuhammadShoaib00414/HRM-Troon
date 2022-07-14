@extends('layouts.auth')

@section('page-title')
       {{ __('Reset Password') }}
       @endsection

 @section('content')
     <div class="login-contain">
         <div class="login-inner-contain">
             <div class="login-form">
        <div class="page-title"><h5>{{__('Reset Password')}}</h5></div>
        @if(session('status'))
            <div class="alert alert-primary">
                {{ session('status') }}
            </div>
        @endif
        <p class="text-xs text-muted">{{__('We will send a link to reset your password')}}</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-control-label">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <small>{{ $message }}</small>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn-login">{{ __('Send Password Reset Link') }}</button>
            <div class="or-text">{{__('OR')}}</div>
            <div class="text-xs text-muted text-center">
                {{__("Back to")}} <a href="{{route('login')}}">{{__('Login')}}</a>
            </div>
        </form>
    </div>
         </div>
     </div>
@endsection




