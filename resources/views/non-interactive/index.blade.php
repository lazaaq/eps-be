@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Non Interactive</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">Non Interactive</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-flat">


    <div style="padding:20px">
      <a href="{{url('admin/noninteractive/create')}}" id="btn-create" type="button" class="btn btn-primary btn-sm bg-primary-800"><i class="icon-add position-left"></i> Create New</a>
    	<table class="table" id="table-noninteractive" class="display" style="width:100%">
  			<thead>
      		<tr>
             <th>Id</th>
             <th>Package/Type</th>
             <th>Type</th>
             <th>Name</th>
             <th>Description</th>
             <th>File Url</th>
             <th class="col-md-2">Action</th>
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
  var tableData;
    $(document).ready(function(){
  		/* tabel user */
      tableData = $('#table-noninteractive').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-package/non-interactive') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'quiz_type.name', name:'quiz_type.name', visible:true},
            { data: 'type', name:'type', visible:true},
            { data: 'non_interactive.[<br>].name', name:'name', visible:true},
            { data: 'non_interactive.[<br>].description', name:'description', visible:true},
            { data: 'non_interactive.[<br>].file_url', name:'file_url', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /*START OF DELETE DATA*/
      $('#table-noninteractive tbody').on( 'click', 'button', function () {
        var data = tableData.row( $(this).parents('tr') ).data();
        swal({
          text: "Are you sure to delete data?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            $.ajax({
              url: "{{ url('admin/package/delete') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                tableData.ajax.reload();
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
      /*END OF DELETE DATA*/

    });
  </script>
@endpush
