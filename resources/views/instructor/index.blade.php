@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Instructor</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">Instructor</li>
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
    	<table class="table" id="table-instructor" class="display" style="width:100%">
  			<thead>
      		<tr>
             <th>Id</th>
             <th style="width:1px">Picture</th>
             <th>Name</th>
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

@include('instructor.create')
@include('instructor.edit')
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
      tableData = $('#table-instructor').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-instructor') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'picture', name:'picture', visible:true},
            { data: 'name', name:'name', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-instructor tbody").on('click','#btn-edit', function(){
          $('.fileinput-remove-button').click();
          $("#instructor-edit :input").val('');
          $('#modal-edit').modal('show');
          var data = tableData.row( $(this).parents('tr') ).data();
          var id = data['id'];
          var token = $('input[name=_token]').val();
          var urlData = " {{ url('admin/instructor') }}"+"/"+id+"/edit";
          var d = new Date();
          $.getJSON( urlData, function(data){
          /*START GET PICTURE*/
            $('#img-edit').empty();
            var img = $('<img id="img-instructor" class="img-responsive" src="{{asset('img/blank.jpg')}}" alt="instructor" title="" width="100" height="50"><br>');
            if (data['data']['pic_url'] != "blank.jpg") {
              var img = $('<img id="img-instructor" class="img-responsive" src="{{ url('storage/instructor/') }}/'+id+'?'+d.getTime()+'" alt="instructor" title="" width="100" height="50"><br>');
            }
            $('#img-edit').append(img);
          /*END GET PICTURE*/
            $('input[name=_method]').val('PUT');
            $('input[name=_token]').val(token);
            $('input[name=name_edit]').val(data['data']['name']);
            $('input[name=id_edit]').val(data['data']['id']);
          });
      });
      /*END OF GET DATA FOR FORM EDIT*/

      /*START OF DELETE DATA*/
      $('#table-instructor tbody').on( 'click', 'button', function () {
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
              url: "{{ url('admin/instructor/delete') }}"+"/"+data['id'],
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
