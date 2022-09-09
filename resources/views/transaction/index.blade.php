@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Transaction</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li class="active">Transaction</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-flat">
    <div style="padding:20px">
    	<table class="table" id="table-transaction" class="display" style="width:100%">
  			<thead>
      		<tr>
                <th>Id</th>
                <th>Collager</th>
                <th>Package</th>
                <th>Payment</th>
                <th>Status</th>
                <th class="col-md-2">Action</th>
            </tr>
  			</thead>
  			<tbody>
  			</tbody>
  		</table>
              <span>
              </span>
    </div>
	</div>
	<!-- /state saving -->
</div>
@include('transaction.edit')
<!-- /content area -->
@endsection
@push('after_script')
  <script>
  var tableData;
    $(document).ready(function(){
  	/* tabel transaction */
      tableData = $('#table-transaction').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-transaction') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'collager.user.name', name:'collager.user.name', visible:true},
            { data: 'package_name', name:'package_name', visible:true},
            { data: 'bank_amount', name:'bank_amount', visible:true},
            // { data: 'valid', name:'valid', visible:true},
            { data: 'status_transaksi', name:'status_transaksi', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-transaction tbody").on('click','#btn-edit', function(){
          var data = tableData.row($(this).parents("tr")).data();
          console.log(data)
          $("#transaction-edit :input").val('');
          $("#payment_method").select2("val", "");
          $("#status").select2("val", "");
          $('#modal-edit').modal('show');
          var token = $('input[name=_token]').val();

          $('input[name=_method]').val('PUT');
          $('input[name=_token]').val(token);

          $('input[name=transaction_id]').val(data['id']);
          $("#collager").text(': ' + data['collager']['user']['name']);
          $("#package").html(data['package_name']);
          // $("#package").text(': ' + data['package_name']['quiz_type']['quiz_category']['root'] + ' - ' + data['package_name']['quiz_type']['quiz_category']['name'] + ' - ' + data['package_name']['quiz_type']['name']);
          $("#amount").text(': ' + data['amount']);
          if (data['start_date'] != null) {
            $('input[name=start_date]').val(data['start_date'].replace(" ","T").substring(0,16));
          }
          if (data['expired_date'] != null) {
            $('input[name=expired_date]').val(data['expired_date'].replace(" ","T").substring(0,16));
          }
          $("#payment_method").val(data['payment_method']['com_cd']).trigger('change');
          $("#status").val(data['status_transaction']['com_cd']).trigger('change');

      });
      /* END OF GET DATA FOR FORM EDIT */

      /* START ubah status */
        $("#table-transaction tbody").on("click", ".status-item", function () {
            let status = $(this).data('value');
            var data = tableData.row($(this).parents("tr")).data();
            swal({
                text: "Are you sure to change status?",
                icon: "warning",
                buttons: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                    $.ajax({
                        url: "{{ url('table/data-transaction/change') }}"+"/"+data['id'],
                        data: {
                            status:status
                        },
                        method: 'get',
                        success: function(result){
                            if (result.status == 'success') {
                              tableData.ajax.reload();
                              toastr.success('Status changed!', 'Success Alert', {timeOut: 5000});
                            } else {
                              toastr.error(result.message, 'Error', {timeOut: 5000});
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            swal(textStatus + ' - ' + errorThrown , {
                              icon: "error",
                            });
                        } 
                    });
                }
            });
        });
      /* END ubah status */

        /*START OF DELETE DATA*/
      $('#table-transaction tbody').on( 'click', '#delete', function () {
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
              url: "{{ url('admin/transaction/delete') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                if(result.status === 'failed'){
                    toastr.error(result.message, 'Error', {timeOut: 5000});
                }
                else {
                  tableData.ajax.reload();
                  toastr.success('Successfully deleted data!', 'Success Alert', {timeOut: 5000});
                }
              }
            });
          }
        });
      });
      /*END OF DELETE DATA*/
    });
  </script>
@endpush
