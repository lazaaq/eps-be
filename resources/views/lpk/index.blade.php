@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">LPK</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">LPK</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-flat">
    <div style="padding:20px">
      <button id="btn-create" type="button" class="btn btn-primary btn-sm bg-primary-800"><i class="icon-add position-left"></i> Create New</button>
    	<table class="table" id="table-lpk" class="display" style="width:100%">
  			<thead>
      		<tr>
             <th>Id</th>
             <th>LPK</th>
             <th>Address</th>
             <th>Phone Number</th>
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
<input type="hidden" name="lpk_id_user" id="lpk_id_user" value="{{Auth::user()->lpk}}">
<!-- /content area -->

@include('lpk.create')
@include('lpk.edit')
@endsection
@push('after_script')
  <script>
  var tableData;
    $(document).ready(function(){
      /* Trigger modal create*/
      $("#btn-create").on('click', function(){
          $('input[name=name]').val('');
          $('input[name=phone_number]').val('');
          $('textarea[name=address]').val('');
          $('#modal-create').modal('show');
      });
      /* End of Trigger modal create*/
  		/* tabel user */
      tableData = $('#table-lpk').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-lpk') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'name', name:'name', visible:true},
            { data: 'address', name:'address', visible:true},
            { data: 'phone_number', name:'phone_number', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-lpk tbody").on('click','#btn-edit', function(){
          $("#lpk-edit :input").val('');
          $('#modal-edit').modal('show');
          var data = tableData.row( $(this).parents('tr') ).data();
          var id = data['id'];
          var token = $('input[name=_token]').val();
          var urlData = " {{ url('admin/lpk') }}"+"/"+id+"/edit";
          var d = new Date();
          $.getJSON( urlData, function(data){
            $('input[name=_method]').val('PUT');
            $('input[name=_token]').val(token);
            $('input[name=name_edit]').val(data['data']['name']);
            $('textarea[name=address_edit]').val(data['data']['address']);
            $('input[name=phone_number_edit]').val(data['data']['phone_number']);
            $('input[name=id_edit]').val(data['data']['id']);
          });
      });
      /*END OF GET DATA FOR FORM EDIT*/

      /*START OF DELETE DATA*/
      $('#table-lpk tbody').on( 'click', 'button', function () {
        var data = tableData.row( $(this).parents('tr') ).data();
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
              url: "{{ url('admin/lpk/delete') }}"+"/"+data['id'],
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
