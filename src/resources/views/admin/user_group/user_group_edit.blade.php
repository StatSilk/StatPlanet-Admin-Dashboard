@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')
@include('layouts.nav')
<div class="main">
    <div class="inner-heading">
        <div class="container">
            Edit User Group
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
                $udashcat = [];
                $userid = [];
                foreach($usergroup->userGroupHasDashCat as $userDashcat){
                    array_push($udashcat,$userDashcat->dashboardcategory_id);
                }
                foreach($usergroup->userHasUsergroup as $userDetail){
                    array_push($userid,$userDetail->user_id);
                }
                ?>
                {!! Form::model($usergroup, ['method' => 'PATCH', 'route' => ['user-groups.update', $usergroup->id], 'data-parsley-validate'=>'']) !!}
                {{ csrf_field() }}
                <div class="box m-b-30"> 
                    <div class="row">
                        <div class="form-group col-12 col-lg-4 col-md-4">
                            <label>User Group Name*</label>
                            <input type="text" required="" value="{{ $usergroup->name }}" class="form-control" maxlength="50" autocomplete='usergroupname' placeholder="User Group Name" name="usergroupname">
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
                                <option {{in_array($dashcategory->id, $udashcat)? 'selected':''  }} value="{{ $dashcategory->id }}">{{ $dashcategory->name }}</option>
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
                                <option {{in_array($user->id, $userid)? 'selected':''  }} value="{{ $user->id }}"> {{ $user->lastname.' '.$user->firstname }}</option>
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
                    <button type="submit" class="btn btn-theme w-200">Update</button>
                    <a href="{{ url('/user-groups') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                </div>  
                {{ Form::close() }}

            </div>

        </div>
    </div>
</div>
@section('js')
<script src="{{asset('public/js/multiple-select.js')}}"></script>
<script>
    $("#dashcat").multipleSelect({
        placeholder: "Select Dashboard Categories"
    });
    $("#users").multipleSelect({
        placeholder: "Select Users"
    });
</script>
@endsection
@endsection
