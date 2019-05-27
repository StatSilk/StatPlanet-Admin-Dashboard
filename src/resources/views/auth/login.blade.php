@extends('layouts.splash')
@section('content')
    <div class="main m-b-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="text-center p-b-15"><img src="{{ asset('public/images/logo.png') }}" alt="logo" style="width: 280px;"></div>
                     @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    @endif
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <div class="login-heading-top">
                        <h3>{{ Config::get('constant.title') }}</h3>
                        <h5>{{ Config::get('constant.subtitle') }}</h5>
                    </div>
                   <form class="box login" data-parsley-validate="" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                   @csrf
                        <h3 class="heading text-center">Login</h3>
                        <div class="row">
                            <div class="form-group col-12">
                                <input id="identity" type="text" class="form-control{{ $errors->has('identity') ? ' is-invalid' : '' }}" required="" data-parsley-required-message="Username or Email is required." name="identity"
                                value="{{ old('identity') }}" autofocus placeholder="Username or Email" autofocus>

                                @if ($errors->has('identity'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('identity') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required="" data-parsley-required-message="Password is required." name="password"  placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class=" form-group col-12">
                                <button type="submit" class="btn btn-theme btn-block btn-lg">Login</button>
                            </div>
                            <div class="col-12 text-center">
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 col-md-10">
                    <p class="text-center p-t-20">{{ Config::get('constant.description') }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-7 col-md-10 social">
                	@foreach(Config::get('constant.images') as $image)
                		<a href="{{ $image['link'] }}" target="_blank"><img src="{{ asset('public/images').'/'.$image['image'] }}" style="width: 40px;"></a>
                	@endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-12 p-t-30">
                    <p class="text-center">{{ Config::get('constant.footer-text') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection