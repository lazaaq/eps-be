@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">User</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">User</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-flat">
    <div style="padding:20px">
      <div class="col-md-12">
        <a href="{{route('user-package.create')}}" class="btn btn-primary btn-sm bg-primary-800"><i class="icon-add position-left"></i>Create New</a>
      </div>
      <table id="table-user" class="table">
  			<thead>
  				<tr>
            <th>Id</th>
  					<th>Username</th>
  					<th>Password</th>
  					<th>Paket</th>
            <th>No Telepon</th>
  					<th class="col-md-2">Actions</th>
  				</tr>
  			</thead>
  			<tbody>
  			</tbody>
  		</table>
    </div>
	</div>
	<!-- /state saving -->
</div>
<!-- /content area -->
@endsection

@push('after_script')
<script>
var tableUser;
  $(document).ready(function(){
		/* tabel user */
    tableUser = $('#table-user').DataTable({
      processing	: true,
			serverSide	: true,
			stateSave: true,
      language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Search records"
                },
      ajax		: {
          url: "{{ url('table/data-user-package') }}",
          type: "GET",
      },

      columns: [
          { data: 'id', name:'id', visible:false},
          { data: 'username', name:'username', visible:true},
          { data: 'password_show', name:'password_show', visible:true},
          { data: 'package_name', name:'package_name', visible:true},
          { data: 'phone', name : 'phone', visible:true},
          { data: 'action', name:'action', visible:true},
      ],
    });

    $('#table-user tbody').on( 'click', 'button', function () {
        var data = tableUser.row( $(this).parents('tr') ).data();
          swal({
          // title: "Are you sure?",
          text: "Are you sure to delete data?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "{{ url('admin/user-package/delete') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                tableUser.ajax.reload();
                swal("Your data has been deleted!", {
                  icon: "success",
                });
              }
            });
          } else {
            swal("Your data is safe!");
          }
        });
      });
  });

</script>
@endpush
