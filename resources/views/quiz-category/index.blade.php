@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Quiz Category</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li class="active">Quiz Category</li>
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
    	<table class="table" id="table-quiz-category" class="display" style="width:100%">
  			<thead>
      		<tr>
             <th>Id</th>
             <th>LPK</th>
             <th>Root</th>
             <th>Name</th>
             <th>Description</th>
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

@include('quiz-category.create')
@include('quiz-category.edit')
@endsection
@push('after_script')
  <script>
  var tableQuizCategory;
    $(document).ready(function(){
      /* START kalau role nya admin lpk */
      if ($('#lpk_id_user').val()){
        $(".div-lpk").hide()
        $("#lpk_edit").val('umum').trigger('change')
        $("#lpk").val('umum').trigger('change')
      }
      /* END kalau role nya admin lpk */

      /* Trigger modal create*/
      $("#btn-create").on('click', function(){
          $('input[name=name]').val('');
          $('textarea[name=description]').val('');
          $('.fileinput-remove-button').click();
          $('#modal-create').modal('show');
      });
      /* End of Trigger modal create*/
  		/* tabel user */
      tableQuizCategory = $('#table-quiz-category').DataTable({
        processing	: true,
        language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records"
                  },
        // dom 		: "<fl<t>ip>",
  			serverSide	: true,
  			stateSave: true,
        ajax		: {
            url : "{{ url('table/data-quiz-category') }}",
            type: "GET",
        },
        columns: [
            { data: 'id', name:'id', visible:false},
            { data: 'lpk_name', name:'lpk_name', visible:true},
            { data: 'root', name:'root', visible:true},
            { data: 'name', name:'name', visible:true},
            { data: 'description', name:'description', visible:true},
            { data: 'action', name:'action', visible:true},
        ],
      });

      /* START OF GET DATA FOR FORM EDIT */
      $("#table-quiz-category tbody").on('click','#btn-edit', function(){
          $('.fileinput-remove-button').click();
          $("#quiz-category-edit :input").val('');
          $('#modal-edit').modal('show');
          var data = tableQuizCategory.row( $(this).parents('tr') ).data();
          var id = data['id'];
          var token = $('input[name=_token]').val();
          var urlData = " {{ url('admin/quizcategory') }}"+"/"+id+"/edit";
          var d = new Date();
          $.getJSON( urlData, function(data){
          /*START GET PICTURE*/
            $('#img-edit').empty();
            var img = $('<img id="img-quizcategory" class="img-responsive" src="{{asset('img/blank.jpg')}}" alt="Quiz Type" title="" width="100" height="50"><br>');
            if (data['data']['pic_url'] != "blank.jpg") {
              var img = $('<img id="img-quizcategory" class="img-responsive" src="{{ url('storage/quiz_category/') }}/'+id+'?'+d.getTime()+'" alt="Quiz Type" title="" width="100" height="50"><br>');
            }
            $('#img-edit').append(img);
          /*END GET PICTURE*/
            $('input[name=_method]').val('PUT');
            $('input[name=_token]').val(token);
            $('input[name=root_edit]').val(data['data']['root']);
            $('input[name=name_edit]').val(data['data']['name']);
            $('input[name=id_edit]').val(data['data']['id']);
            if (data['data']['lpk']) {
              $("#lpk_edit").val(data['data']['lpk']).trigger('change');
            } else {
              $("#lpk_edit").val('umum').trigger('change');
            }
            $('textarea[name=description_edit]').val(data['data']['description']);
          });
      });
      /*END OF GET DATA FOR FORM EDIT*/

      /*START OF DELETE DATA*/
      $('#table-quiz-category tbody').on( 'click', 'button', function () {
        var data = tableQuizCategory.row( $(this).parents('tr') ).data();
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
              url: "{{ url('admin/quizcategory/delete') }}"+"/"+data['id'],
              method: 'get',
              success: function(result){
                tableQuizCategory.ajax.reload();
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
