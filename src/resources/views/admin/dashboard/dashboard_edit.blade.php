@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')
@include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                {{trans('messages.Edit Dashboard')}}
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
                       {!! Form::model($dashboard, ['method' => 'PATCH', 'route' => ['dashboard.update', $dashboard->id],'files' => true, 'data-parsley-validate'=>'']) !!}
                       {{ csrf_field() }}
                           <div class="box m-b-30"> 
                            <div class="row">
                                <div class="form-group col-12 col-lg-6 col-md-6">
                                    <label>Name *</label>
                                    <input type="text" required="" class="form-control"  placeholder="Dashboard Name" value="{{ $dashboard->name }}" autocomplete='name' name="name">
                                    @if ($errors->has('name'))
                                    <span class="errors">{{$errors->first('name')}}</span>  
                                    @endif
                                </div>
                                <div class="form-group col-12 col-lg-6 col-md-6">
                                    <label>Category</label>
                                    <select name="dashcat" class="form-control" >
                                        <option value="">Category</option>
                                        @foreach($dashcat as $category)
                                        <option {{ ($dashboard->dashboardcategory_id === $category->id) ? 'selected' : null }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6 col-md-6">
                                    <label>Folder Name *</label>
                                    <select required=""  name="foldername" class="form-control" >
                                        @foreach($files as $file)
                                        <option {{ $dashboard->folder_name === $file ? 'selected' : null }} value="{{$file}}">{{ $file }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-12 col-lg-6 col-md-6">
                                    <label>Link </label>
                                    <input type="text" class="form-control" placeholder="Dashboard Web Link" autocomplete='dashboard_link' value="{{ $dashboard->dashboard_link }}" data-parsley-type="url" data-parsley-type-message="Please insert a valid link" name="dashboard_link">
                                </div>
                                <div class="form-group col-12 col-lg-6 col-md-6">
                                    <label>Description</label>
                                    <textarea class="form-control" autocomplete='description' placeholder="Dashboard Description" name="description">{{ $dashboard->description }}</textarea>
                                </div>
                            </div>
                          </div>
                          <div class="form-group col-12 text-center">
                            <button type="submit" id="submit" class="btn btn-theme w-200">Update</button>
                            <a href="{{ url('/dashboard') }}" ><button type="button" class="btn btn-theme w-200">Discard Changes</button></a>
                          </div>  
                        {{ Form::close() }}
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
$("body").on("change", "#fileUpload", function () {
var allowedFiles = [".txt", ".csv"];
var fileUpload = $("#fileUpload");
var lblError = $("#lblError");
var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
if (!regex.test(fileUpload.val().toLowerCase())) {
    lblError.html("Please upload files having extensions: <b>" + allowedFiles.join(', ') + "</b> only.");
    return false;
}
lblError.html('');
return true;
});
</script>
@endsection
@endsection
