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
                            <th></th>
                            <th>Dashboard</th>
                            <th>Dashboard Categories</th>
                            <th>More Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dashboards as $dashboard)
                            <tr>
                                <td><input name="dashboardsid" value="{{ $dashboard->id }}" onclick="myFunction()" type="checkbox" />
                                <input type="hidden" id="{{ $dashboard->id }}" value="{{$dashboard->name  }}">
                                </td>
                                <td><a href="{{ url('/dashboard').'/'.$dashboard->id }}" title="{{ $dashboard->name }}" target="_blank">{{ $dashboard->name }}</a></td>
                                <td>{{ $dashboard->dashcat_detail->name }}</td>
                                <td><a href="{{ $dashboard->dashboard_link }}" title="{{ $dashboard->description }}" target="_blank">{{ $dashboard->description }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>        
                    </table>
            </div>
        </div>
        <div class="col-12">
            <a href="{{url('/dashboard/create')}}" class="btn btn-secondary f-14 f-14 m-b-15">Add Dashboard </a>
            <a href="javascript:void()" id="edit" class="btn btn-secondary disabled f-14 f-14 m-b-15">Edit Selected Dashboard </a>
            <a href="javascript:void()" id="remove" class="btn btn-secondary disabled f-14 f-14 m-b-15">Remove Selected Dashboards</a>
            <a href="javascript:void()" id="view" class="btn btn-secondary disabled f-14 f-14 m-b-15">View Dashboard</a>
            <a href="{{url('/dashboard/rich-file-manager')}}" class="btn btn-secondary f-14 f-14 m-b-15">Add Dashboard Folder </a>
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
   var table = $('#dashboard').DataTable({
      'columnDefs': [{
         'targets': 0,
         'searchable':false,
         'orderable':false,
         'className': 'dt-body-center',
         
      }],
      "pageLength": 10,
      /*"aLengthMenu": [[1, 5, 10, 15], [1, 5, 10, "All"]],
      "iDisplayLength": 1,*/
      'order': [1, 'asc'],
      "createdRow": function(row, data, dataIndex){
         $(row).attr("id", "tblRow_" + data[0]);
      }
   });
});
var sel = [];
function myFunction(){
  var sel = getValueUsingClass();
  var name = getNameUsingCheckbox();
  var selected = '';
  selected = sel.join(',');
  var nameJoin = '';
  nameJoin = name.join(','); 
  if(sel.length < 2 && $('input[type=checkbox]').is(':checked')){
    $('#edit').attr('data-val',sel);
    $('#view').attr('data-val',sel);
    $('#remove').attr('data-val',sel);
    $('#remove').attr('data-name',name);
    $("#edit").removeClass("disabled");
    $("#view").removeClass("disabled");
    $("#remove").removeClass("disabled");
  }else if (sel.length > 1) {
    $("#edit").addClass("disabled");
    $("#view").addClass("disabled");
    $('#remove').attr('data-val',selected);
    $('#remove').attr('data-name',nameJoin);
    $("#remove").removeClass("disabled");
  }else{
    $("#view").addClass("disabled");
    $("#edit").addClass("disabled");
    $("#remove").addClass("disabled");
  }
}
function getValueUsingClass(){
  /* declare an checkbox array */
  var chkArray = [];
  /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
  $("input[type=checkbox]:checked").each(function() {
    chkArray.push($(this).val());
  });
  return chkArray;
}
function getNameUsingCheckbox(){
  /* declare an checkbox array */
  var nameArr = [];
  /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
  $("input[type=checkbox]:checked").each(function() {
    var id = $(this).val();
    nameArr.push($('#'+id).val());
  });
  return nameArr;
}
// function for edit users
$("#edit").click(function(){
  if($(this).attr("data-val") !== ''){
    window.location.href = window.location+'/'+$(this).attr("data-val")+'/edit';
  }else{
    $('#edit').prop('disabled', true);
    swal('Oops!', "Please select one dashboard", 'error');
  }
});
// function for remove users
$("#remove").click(function(){
  if($(this).attr("data-val")){
    var name = $(this).attr("data-name");
    swal({
      title: "Are you sure?",
      text: "you wish to remove the following dashboards (this cannot be undone): "+ name,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    })
    .then((willDelete) => {
        if (willDelete.value) {
          $.ajax({
                type: "GET",
                url: window.location+'/delete',
                data:{id:$(this).attr("data-val")},
                success: function(result) {
                          if(result >= 1){
                            swal({title: "Success!",icon:"success", text: "Dashboards deleted successfully!", type: "success"}).then((ok)=>{
                              location.reload();
                            });
                          }else{
                            swal('Oops!', 'something went wrong', 'error');
                          }
                      }
              });
        }
    });
  }else{
    $('#remove').prop('disabled', true);
    swal("Sorry!","Please select atleast one dashboard","warning");
  }
});

// function for view dashboard
$("#view").click(function(){
  if($(this).attr("data-val")){
    window.open(window.location+'/'+$(this).attr("data-val"), '_blank');
  }
});
</script>
@endsection    
@endsection
