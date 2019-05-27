@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')
@include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                {{trans('messages.Add Dashboard Category')}}
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
                   <form action="{{ url('/dashboard-categories') }}" data-parsley-validate="" method="post">
                       @csrf
                       <div class="box m-b-30"> 
                        <div class="row">
                            <div class="form-group col-12 col-lg-6 col-md-6">
                                <label>Dashboard Category Name *</label>
                                <input type="text" required="" data-parsley-required-message="Please fill in a Dashboard Category Name" autocomplete='dashcatname' class="form-control" maxlength="50"  placeholder="Dashboard Category Name" name="dashcatname">
                                @if ($errors->has('dashcatname'))
                                <span class="errors">{{$errors->first('dashcatname')}}</span>  
                                @endif
                            </div>

                            <div class="form-group col-12 col-lg-6 col-md-6">
                                <label>Dashboards</label>
                                <select class="form-control" name="dashboard[]" id="dashboard" multiple>
                                    @if(count($dashboard))
                                    <option disabled></option>
                                    @foreach($dashboard as $dash)
                                    <option value="{{ $dash->id }}">{{ $dash->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                @if(!count($dashboard))
                                <small class="errors">No Dashboards found – please create one</small>
                                @endif
                            </div>
                        </div>
                      </div>
                      <div class="form-group col-12 text-center">
                        <button type="submit" class="btn btn-theme w-200">Add</button>
                        <a href="{{ url('/dashboard-categories') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                      </div>  
                    </form>
                </div>
                
            </div>
        </div>
    </div>
@section('js')
<script src="{{asset('public/js/multiple-select.js')}}"></script>
<script>
        $("#dashboard").multipleSelect({
            placeholder: "Select Dashboard"
        });
    </script>
@endsection
@endsection
