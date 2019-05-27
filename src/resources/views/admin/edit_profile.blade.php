@extends('layouts.app')

@section('content')
@include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                {{trans('messages.Edit Profile')}}
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 p-b-20">
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
                </div>
            </div>    
            <div class="row">    
                <div class="col-lg-6 col-md-6">
                    <form action="{{ url('post-profile') }}" data-parsley-validate="" method="post">
                    <div class="box m-b-30">
                     
                         @csrf
                         <div class="row">
                            <div class="form-group col-12">
                                <label>First Name*</label>
                                <input type="text" required="" class="form-control"  placeholder="First Name" value="{{$user->firstname}}" data-parsley-pattern="/^[a-zA-Z ]{2,30}$/" autocomplete="section-blue shipping address-level2" data-parsley-pattern-message="First name must contain using character" name="firstname">
                                @if ($errors->has('firstname'))
                                <span class="errors">{{$errors->first('firstname')}}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label>Last Name*</label>
                                <input type="text" class="form-control" value="{{$user->lastname}}" data-parsley-pattern="/^[a-zA-Z ]{2,30}$/" 
                                data-parsley-pattern-message="Last name must contain using character"  placeholder="Last Name" autocomplete="section-blue shipping address-level2" required="" name="lastname">
                                @if ($errors->has('lastname')) 
                                <span class="errors">{{ $errors->first('lastname') }}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label>Email *</label>
                                <input type="email" class="form-control" value="{{$user->email}}" required=""  name="email" autocomplete="section-blue shipping address-level2" placeholder="Email">
                                @if ($errors->has('email')) 
                                <span class="errors">{{ $errors->first('email') }}</span>  
                                @endif
                            </div>
                        </div>
                    </div>    
                        <div class="form-group col-12 text-center">
                            <button type="submit" class="btn btn-theme w-200">Update</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6">
                        <form action="{{ url('post-password') }}" data-parsley-validate="" method="post">
                            @csrf
                           <div class="box m-b-30"> 
                            <div class="row">
                                <div class="form-group col-12 ">
                                    <label>Old Password *</label>
                                    <input type="password" required="" class="form-control"  placeholder="Old Password" autocomplete="section-blue shipping address-level2" name="old_password">
                                    @if ($errors->has('old_password'))
                                          <span class="errors">{{$errors->first('old_password')}}</span>  
                                    @endif
                                </div>
                                <div class="form-group col-12 ">
                                    <label>New Password *</label>
                                    <input type="password" class="form-control" id="pwd" data-parsley-pattern="/^(?=.*\d)(?=.*[a-zA-Z]).{6,50}$/" 
                                    data-parsley-pattern-message="Your password must contain combination of atleast 6 alphanumeric characters." placeholder="New Password" required="" autocomplete="section-blue shipping address-level2" name="new_password">
                                    @if ($errors->has('new_password')) 
                                          <span class="errors">{{ $errors->first('new_password') }}</span>  
                                    @endif
                                </div>
                                <div class="form-group col-12 ">
                                    <label>Confirm Password *</label>
                                    <input data-parsley-equalto="#pwd" type="password" class="form-control" required="" autocomplete="section-blue shipping address-level2"  name="confirm_password" placeholder="Confirm Password">
                                </div>
                            </div>
                          </div>
                          <div class="form-group col-12 text-center">
                                <button type="submit" class="btn btn-theme w-200">Change Password</button>
                                <a href="{{ url('/dashboard') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                          </div>  
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
