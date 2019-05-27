@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')
@include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                Edit User
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
<?php 
$ugrouparr = [];
foreach($users->userHasUsergroup as $userHasUsergroup){
array_push($ugrouparr,$userHasUsergroup->usergroup_id);
}
?>
                   {!! Form::model($users, ['method' => 'PATCH', 'route' => ['users.update', $users->id], 'data-parsley-validate'=>'']) !!}
                       {{ csrf_field() }}
                       <div class="box m-b-30"> 
                        <div class="row">
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>First Name*</label>
                                <input type="text" required="" class="form-control" maxlength="50"  placeholder="First Name" value="{{ $users->firstname }}" data-parsley-pattern="/^[a-zA-Z ]{1,50}$/" data-parsley-pattern-message="First name must contain using character" autocomplete='firstname' name="firstname">
                                @if ($errors->has('firstname'))
                                <span class="errors">{{$errors->first('firstname')}}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>Last Name*</label>
                                <input type="text" class="form-control" data-parsley-pattern="/^[a-zA-Z ]{1,50}$/" maxlength="50" value="{{ $users->lastname }}" data-parsley-pattern-message="Last name must contain using character"  placeholder="Last Name" autocomplete='lastname' required="" name="lastname">
                                @if ($errors->has('lastname')) 
                                <span class="errors">{{ $errors->first('lastname') }}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>User Name*</label>
                                <input type="text" class="form-control" value="{{ $users->username }}" maxlength="75" placeholder="User Name" required="" autocomplete='username' name="username">
                                @if ($errors->has('username')) 
                                <span class="errors">{{ $errors->first('username') }}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-4">
                                <label>Email *</label>
                                <input type="email" class="form-control" value="{{ $users->email }}" maxlength="50" required=""  name="email" autocomplete='email' placeholder="Email">
                                @if ($errors->has('email')) 
                                <span class="errors">{{ $errors->first('email') }}</span>  
                                @endif
                            </div>
                            <div class="form-group col-12 col-lg-4 col-md-6">
                                <label>Password</label>
                                <input type="password" class="form-control" id="pwd" data-parsley-pattern="/^(?=.*\d)(?=.*[a-zA-Z]).{6,50}$/" 
                                data-parsley-pattern-message="Your password must contain combination of atleast 6 alphanumeric characters." autocomplete='password'  placeholder="New Password" name="password">
                                @if ($errors->has('password')) 
                                      <span class="errors">{{ $errors->first('password') }}</span>  
                                @endif
                            </div>
                            {{-- <div class="form-group col-12 col-lg-4 col-md-6">
                                <label>Confirm Password</label>
                                <input data-parsley-equalto="#pwd" type="password" class="form-control" required="" name="confirm_password" placeholder="Confirm Password">
                            </div> --}}
                            <div class="form-group col-12 col-lg-4 col-md-6">
                                <label>User Group</label>
                                <select class="form-control" name="user_group[]" id="lstFruits" multiple>
                                    @if(count($usergroup))
                                    <option disabled></option>
                                    @foreach($usergroup as $ugroup)
                                        <option {{in_array($ugroup->id, $ugrouparr)? 'selected':''  }} value="{{ $ugroup->id }}">{{ $ugroup->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if(!count($usergroup))
                                <small class="errors">No User Groups found – please create one</small>
                                @endif
                            </div>
                        </div>
                      </div>
                      <div class="form-group col-12 text-center">
                    <button type="submit" class="btn btn-theme w-200">Update</button>
                    <a href="{{ url('/users') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
                    {{ Form::close() }}
                </div>
                
            </div>
        </div>
    </div>
@section('js')
<script src="{{asset('public/js/multiple-select.js')}}"></script>
<script>
        $("select").multipleSelect({
            placeholder: "Select User Group"
        });
    </script>
@endsection
@endsection
