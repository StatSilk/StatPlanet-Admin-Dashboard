@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')
@include('layouts.nav')
<div class="main">
    <div class="inner-heading">
        <div class="container">
            Add User Group
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
                <form action="{{ url('/user-groups') }}" data-parsley-validate="" method="post">
                 @csrf
                 <div class="box m-b-30"> 
                    <div class="row">
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>User Group Name*</label>
                            <input type="text" required="" class="form-control" maxlength="50"  placeholder="User Group Name" autocomplete='usergroupname' data-parsley-required-message="Please fill in a User Group Name" name="usergroupname">
                            @if ($errors->has('usergroupname'))
                            <span class="errors">{{$errors->first('usergroupname')}}</span>  
                            @endif
                        </div>
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>Dashboard Categories</label>
                            <select class="form-control" name="dashcat[]" id="dashcat" multiple>
                                @if(count($dashcat))
                                <option disabled></option>
                                @foreach($dashcat as $dashcategory)
                                <option value="{{ $dashcategory->id }}">{{ $dashcategory->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(!count($dashcat))
                            <small class="errors">No Dashboard Categories found – please create one</small>
                            @endif
                        </div>
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>Users</label>
                            <select class="form-control" name="users[]" id="users" multiple>
                                @if(count($users))
                                <option disabled></option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->firstname.' '.$user->lastname }}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(!count($users))
                            <small class="errors">No Users found – please create one</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 text-center">
                    <button type="submit" class="btn btn-theme w-200">Add</button>
                    <a href="{{ url('/user-groups') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
            </form>
        </div>
        
    </div>
</div>
</div>
@section('js')
<script src="{{asset('public/js/multiple-select.js')}}"></script>
<script>
    $("#users").multipleSelect({
        placeholder: "Select Users"
    });
    $("#dashcat").multipleSelect({
        placeholder: "Select Dashboard Category"
    });
</script>
@endsection
@endsection
