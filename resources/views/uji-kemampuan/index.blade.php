@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Uji Kemampuan</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">Uji Kemampuan</li>
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
    	<table class="table" id="table-uji-kemampuan" class="display" style="width:100%">
  			<thead>
      		<tr>
                <th>Id</th>
                <th>Name</th>
                <th>Min Score</th>
                <th>Max Score</th>
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

@include('uji-kemampuan.create')
@include('uji-kemampuan.edit')
@endsection
@push('after_script')
  <script>
  var tableUjiKemampuan;
    $(document).ready(function(){
      /* Trigger modal create*/
      $("#btn-create").on('click', function(){
          $('input[name=name]').val('');
          $('textarea[name=description]').val('');
          $('input[name=min_score]').val()
          $('input[name=max_score]').val();
          $('#modal-create').modal('show');
      });
      /* End of Trigger modal create*/
  		/* tabel user */
      tableUjiKemampuan = $('#table-uji-kemampuan').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-uji-kemampuan') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'name', name:'name', visible:true},
            { data: 'min_score', name:'min_score', visible:true},
            { data: 'max_score', name:'max_score', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-uji-kemampuan tbody").on('click','#btn-edit', function(){
          $("#uji-kemampuan-edit :input").val('');
          $('#modal-edit').modal('show');
          var data = tableUjiKemampuan.row( $(this).parents('tr') ).data();
          var id = data['id'];
          var token = $('input[name=_token]').val();
          var urlData = " {{ url('admin/uji-kemampuan') }}"+"/"+id+"/edit";
          $.getJSON( urlData, function(data){
            $('input[name=_method]').val('PUT');
            $('input[name=_token]').val(token);
            $('input[name=name_edit]').val(data['data']['name']);
            $('input[name=id_edit]').val(data['data']['id']);
            $('textarea[name=description_edit]').val(data['data']['description']);
            $('input[name=min_score_edit]').val(data['data']['min_score']);
            $('input[name=max_score_edit]').val(data['data']['max_score']);

          });
      });
      /*END OF GET DATA FOR FORM EDIT*/

      /*START OF DELETE DATA*/
      $('#table-uji-kemampuan tbody').on( 'click', 'button', function () {
        var data = tableUjiKemampuan.row( $(this).parents('tr') ).data();
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
              url: "{{ url('admin/uji-kemampuan/delete') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                tableUjiKemampuan.ajax.reload();
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
