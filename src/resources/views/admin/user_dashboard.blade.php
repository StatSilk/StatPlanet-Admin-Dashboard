@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{asset('public/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
    @include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
               {{trans('messages.Dashboard')}}
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
                  <div class="box">
                  <table id="dashboard" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Dashboard Name</th>
                            <th>Dashboard Category</th>
                            <th>More Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dashboards as $dashboard)
                            <tr>
                                <td><a href="{{ url('/dashboard').'/'.$dashboard->id }}" target="_blank">{{ $dashboard->name }}</a></td>
                                <td>{{ $dashboard->dashcat_detail->name }}</td>
                                <td><a href="{{ $dashboard->dashboard_link }}" target="_blank">{{ $dashboard->dashboard_link }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>        
                 </table>
                </div>
                </div>
                <div class="col-12">
                  <a class="float-right">Total Dashboards: {{ count($dashboards) }}</a>
                </div>
            </div>
        </div>
    </div>
    @section('js')
        <script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('public/js/multiple-select.js')}}"></script>
        <script src="{{asset('public/js/sweetalert2.min.js')}}"></script>
        <script type="text/javascript">
        $(document).ready(function (){   
           $('#dashboard').DataTable();
        });
        </script>
    @endsection    
@endsection
