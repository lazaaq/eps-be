@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Payment Method</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">Payment Method</li>
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
    	<table class="table" id="table-payment-method" class="display" style="width:100%">
  			<thead>
      		<tr>
             <th>Id</th>
             <th style="width:1px">Logo</th>
             <th>Account</th>
             <th>Owner</th>
             <th>ID</th>
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

@include('payment-method.create')
@include('payment-method.edit')
@endsection
@push('after_script')
  <script>
  var tableData;
    $(document).ready(function(){
      /* Trigger modal create*/
      $("#btn-create").on('click', function(){
          $('input[name=name]').val('');
          $('.fileinput-remove-button').click();
          $('#modal-create').modal('show');
      });
      /* End of Trigger modal create*/
  		/* tabel user */
      tableData = $('#table-payment-method').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-payment-method') }}",
            type: "GET",
        },
        columns: [
            { data: 'com_cd', name:'com_cd', visible:false},
            { data: 'logo', name:'logo', visible:true},
            { data: 'code_nm', name:'code_nm', visible:true},
            { data: 'note', name:'note', visible:true},
            { data: 'code_value', name:'code_value', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-payment-method tbody").on('click','#btn-edit', function(){
          $('.fileinput-remove-button').click();
          $("#payment-method-edit :input").val('');
          $('#modal-edit').modal('show');
          var data = tableData.row( $(this).parents('tr') ).data();
          var id = data['com_cd'];
          var token = $('input[name=_token]').val();
          var urlData = " {{ url('admin/payment-method') }}"+"/"+id+"/edit";
          var d = new Date();
          $.getJSON( urlData, function(data){
          /*START GET PICTURE*/
            $('#img-edit').empty();
            if (data['data']['note2']) {
              var img = data['data']['logo'];
            }
            $('#img-edit').append(img);
          /*END GET PICTURE*/
            $('input[name=_method]').val('PUT');
            $('input[name=_token]').val(token);
            $('input[name=id_edit]').val(data['data']['com_cd']);
            $('input[name=account_name_edit]').val(data['data']['code_nm']);
            $('input[name=id_number_edit]').val(data['data']['code_value']);
            $('input[name=owner_edit]').val(data['data']['note']);
          });
      });
      /*END OF GET DATA FOR FORM EDIT*/

      /*START OF DELETE DATA*/
      $('#table-payment-method tbody').on( 'click', 'button', function () {
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
              url: "{{ url('admin/payment-method/delete') }}"+"/"+data['com_cd'],
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
