@extends('layouts.splash')

@section('content')
<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
            <div class="text-center p-b-15"><img src="{{ asset('public/images/logo.png') }}" alt="logo" style="width: 280px;"></div>
                    <div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif

                        <form class="box login" method="POST" data-parsley-validate="" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                            @csrf
                            <h3 class="heading text-center">{{ __('Reset Password') }}</h3>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" data-parsley-required-message="Email is required." name="email" value="{{ old('email') }}" required placeholder="Email">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-12">
                                        <button type="submit" class="btn btn-theme btn-block btn-lg">
                                            {{ __('Send Email') }}
                                        </button>
                                </div>
                                <div class="col-12 text-center">
                                    <a href="{{ route('login') }}">Back to Login</a>
                                </div>
                            </div>
                        </form>
                        
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
