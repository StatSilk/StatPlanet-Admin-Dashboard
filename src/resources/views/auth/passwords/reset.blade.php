@extends('layouts.splash')

@section('content')
<div class="main">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="text-center p-b-15"><img src="{{ asset('public/images/logo.png') }}" alt="logo" style="width: 280px;"></div>
            <div>
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif
                <form class="box login" method="POST" data-parsley-validate="" action="{{ route('password.request') }}" aria-label="{{ __('Reset Password') }}">
                    @csrf

                    <h3 class="heading text-center">{{ __('Reset Password') }}</h3>

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row">
                        <div class="form-group col-12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"  value="{{ $email ?? old('email') }}" required autofocus placeholder="Email">

                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-12">
                            <input id="password" type="password" data-parsley-pattern="/^(?=.*\d)(?=.*[a-zA-Z]).{6,50}$/" data-parsley-pattern-message="Your password must contain combination of atleast 6 alphanumeric characters." class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">

                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group col-12">
                            <input id="password-confirm" data-parsley-equalto="#password" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                        </div>

                        <div class="form-group col-12">
                            <button type="submit" class="btn btn-theme btn-block btn-lg">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
