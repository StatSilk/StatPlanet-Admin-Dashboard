@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('public/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('public/css/multiple-select.min.css')}}">
@endsection
@section('content')

@include('layouts.nav')
    <div class="main">
        <div class="inner-heading">
            <div class="container">
                {{trans('messages.Users')}}
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
                  <table id="users" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>{{-- <input name="select_all" value="1" id="example-select-all" type="checkbox" /> --}}</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>User Name</th>
                                <th>User Group</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                        @foreach($users as $user)
                            <tr>
                                <td><input name="userid" value="{{ $user->id }}" onclick="myFunction()" type="checkbox" />
                                <input type="hidden" id="{{ $user->id }}" value="{{ $user->lastname.' '.$user->firstname  }}">
                                </td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    <?php $newarr = []; ?>
                                @foreach($user->userHasUsergroup as $userHasUsergroup)
                                    @if($userHasUsergroup->usergroup_detail)
                                    <?php 
                                       $newarr[] = $userHasUsergroup->usergroup_detail->name;
                                    ?>
                                    @endif
                                @endforeach
                                @if(is_array($newarr))
                                {{ implode(', ',$newarr)}}
                                @else
                                {{$newarr}}
                                @endif
                                </td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>        
                  </table>
                  </div>
                </div>
                <div class="col-12">
                    <a href="{{url('/users/create')}}" class="btn btn-secondary f-14 m-b-15">Add User</a>
                    <a href="javascript:void()" id="edit" class="btn btn-secondary disabled f-14 m-b-15" disabled>Edit Selected User</a>
                    <a href="javascript:void()" id="remove" class="btn btn-secondary disabled f-14 m-b-15" disabled>Remove Selected User</a>
                    <a href="javascript:void()" id="assign" class="btn btn-secondary disabled f-14 m-b-15" disabled>Assign Selected Users to User Group</a>
                    <a class="float-right">Total Users: {{ $count }}</a>
                </div>
            </div>
        </div>
        {{-- User Group Model --}}
        <div id="myModel" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 id="textTitle" class="modal-title pull-left">Please select the User Groups to be assigned to the selected User.</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <form method="post" action="{{ url('/users/assign-usergroup') }}">
              {{ csrf_field() }}
              <div class="modal-body">
                <p>
                  <select class="form-control" required="" name="user_group[]" id="usergroup" multiple>
                      <option disabled></option>
                  </select>
                  <input type="hidden" name="user_id" id="userid">
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
              </div>
            </form>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        {{-- User Group Model --}}
    </div>
@section('js')
<script src="{{asset('public/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/js/multiple-select.js')}}"></script>
<script src="{{asset('public/js/sweetalert2.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function (){   
   var table = $('#users').DataTable({
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
    $('#remove').attr('data-val',sel);
    $('#assign').attr('data-val',sel);
    $('#remove').attr('data-name',name);
    $("#edit").removeClass("disabled");
    $("#remove").removeClass("disabled");
    $("#assign").removeClass("disabled");
  }else if (sel.length > 1) {
    $('#remove').attr('data-val',selected);
    $('#assign').attr('data-val',selected);
    $('#remove').attr('data-name',nameJoin);
    $("#edit").addClass("disabled");
    $("#remove").removeClass("disabled");
    $("#assign").removeClass("disabled");
  }else{
    $("#edit").addClass("disabled");
    $("#remove").addClass("disabled");
    $("#assign").addClass("disabled");
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
    swal("Please select one user");
  }
});
// function for remove users
$("#remove").click(function(){
  if($(this).attr("data-val")){
    var name = $(this).attr("data-name");
    swal({
      title: "Are you sure?",
      text: "you wish to remove the following users (this cannot be undone): "+ name,
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
                            swal({title: "Success!",icon:"success", text: "User deleted successfully!", type: "success"}).then((ok)=>{
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
    swal("Sorry!","Please select atleast one user","warning");
  }
});
// function for assign users to user group
$("#assign").click(function(){
    $('#userid').val($(this).attr("data-val"));
    if($(this).attr("data-val").length > 1){
      $("#textTitle").html("This will assign the User Groups below to the selected users, adding to any existing User Groups for those users.");
    }else{
      $("#textTitle").html("Please select the User Groups to be assigned to the selected User.");
    }
    $.ajax({
      type: "GET",
      url: window.location+'/usergroup-list',
      data: {id:$(this).attr("data-val")},
      success: function(result) {
                if(result.length){
                  $('#myModel').modal('show'); 
                  var _options =""
                  $.each(result, function(key, value) {   
                    if(value.user_has_usergroup != undefined && value.user_has_usergroup.length ){
                      console.log(value.user_has_usergroup);
                      _options +=('<option selected="" value="'+ value.id+'">'+ value.name +'</option>');
                    }else{
                      _options +=('<option value="'+ value.id+'">'+ value.name +'</option>');
                    }
                  });
                  $('#usergroup').html(_options);
                  $("#usergroup").multipleSelect({
                      placeholder: "Select User Group"
                  });
                }else{
                  swal('Sorry!',"No User Groups found – please create one",'warning');
                }
            }
    });
});
</script>
@endsection
@endsection
