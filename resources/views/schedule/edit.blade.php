@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Schedule</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li href="{{url('admin/schedule')}}">Schedule</li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-white">
		<div class="panel-body">
      <fieldset class="content-group">
        <legend class="text-bold">Edit Schedule</legend>
        <form class="form-horizontal" action="{{route('package.update',$data->id)}}" method="post" enctype="multipart/form-data" files=true>
        @method('PUT')
        @csrf
          <div class="form-group">
            <label class="control-label col-lg-3">Quiz Category - Type<span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <select id="type" class="select-search" data-placeholder="Choose Quiz Type" name="quiz_type">
                  <option value=""></option>
                  @foreach($quiztype->whereIn('name',['Private','Group'])->sortBy('quiz_category_id') as $value1 => $key1)
                      <option value="{{$key1->id}}" {{ collect(old('quiz_type'))->contains($key1->id) ? 'selected': (($key1->id == $data->quiz_type_id) ? 'selected' : '')}} class="{{$key1->quiz_category_id}}">{{$key1->quizCategory->root.' - '.$key1->quizCategory->name.' - '.$key1->name}}</option>
                  @endforeach
              </select>
                @if ($errors->has('quiz_type'))
                <label style="padding-top:7px;color:#F44336;">
                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('quiz_type') }}</strong>
                </label>
                @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3">Quota <span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <input type="number" min="1" name="quota" class="form-control" value="{{ old('quota') ? old('quota') : $data->quota }}" placeholder="">
                @if ($errors->has('quota'))
                <label style="padding-top:7px;color:#F44336;">
                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('quota') }}</strong>
                </label>
                @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3">Price <span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <input type="number" min="1" name="price" class="form-control" value="{{ old('price') ? old('price') : $data->price }}" placeholder="">
                @if ($errors->has('price'))
                <label style="padding-top:7px;color:#F44336;">
                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('price') }}</strong>
                </label>
                @endif
            </div>
          </div>
          <div>
            <div class="col-md-4">
                <a href="{{route('package.index')}}" type="button" class="btn btn-default"><i class="icon-arrow-left13"></i> Close</a>
            </div>
            <div class="col-md-8 text-right"  style="margin-bottom:30px">
              <button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
            </div>
          </div>
        </form>
        <legend class="text-bold">Details</legend>
        <div class="col-lg-12 row">
          <form class="form-horizontal" id="schedule-detail-store" method="post" enctype="multipart/form-data" files=true>
          @csrf
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Instructor<span class="text-danger">*</span></label>
                <input type="hidden" name="package_id" id="package_id" class="form-control" value="{{$data->id}}" placeholder="" require>
                <input type="hidden" name="schedule_detail_id" id="schedule_detail_id" class="form-control" value="" placeholder="">
                <select class="select-search" data-placeholder="Choose Instructor" name="instructor" id="instructor" require>
                    @foreach(\App\Instructor::get() as $value => $key)
                        <option value=""></option>
                        <option value="{{$key->id}}">{{$key->name}}</option>
                    @endforeach
                </select>
                  @if ($errors->has('instructor'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('instructor') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Date & Time<span class="text-danger">*</span></label>
                  <input type="datetime-local" name="datetime" id="datetime" class="form-control" value="{{ old('datetime') }}" placeholder="" require>
                  @if ($errors->has('datetime'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('datetime') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Duration<span class="text-danger">*</span></label>
                  <input type="number" name="duration" id="duration" min="0" class="form-control" value="{{ old('duration') }}" placeholder="in minutes" require>
                  @if ($errors->has('duration'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('duration') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Meet url<span class="text-danger">*</span></label>
                <input type="url" name="urlmeet" id="urlmeet" class="form-control" value="{{ old('urlmeet') }}" placeholder="https://......." require>
                  @if ($errors->has('urlmeet'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('urlmeet') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-12 text-right">
              <button type="submit" id="btn-submit-detail" class="btn bg-indigo add-row">Update Details</button>
            </div>
          </form>
          <div class="col-md-12 text-right">
            <table class="table" id="table-detail">
              <thead>
                <tr>
                  <th class="">ID</th>
                  <th class="col-md-3">Instructor</th>
                  <th class="col-md-3">Date and Time</th>
                  <th class="col-md-1">Duration</th>
                  <th class="col-md-3">Meet url</th>
                  <th class="col-md-2">Action</th>
                </tr>
              </thead>
              <tbody style="text-align:left">
              </tbody>
            </table>
          </div>
        </div>
      </fieldset>
		</div>
	</div>
	<!-- /state saving -->
</div>
<!-- /content area -->
@include('schedule.modal-edit')
@endsection
@push('after_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function(){
    package_id = {{$data->id}}
    /* START OF DATATABLE */
    tableData = $('#table-detail').DataTable({
      bFilter: false, bInfo: false,
      processing	: true,
      language: {
                  search: "_INPUT_",
                  searchPlaceholder: "Search records"
                },
      // dom 		: "<fl<t>ip>",
      serverSide	: true,
      stateSave: true,
      ajax		: {
          url: "{{url('table/data-schedule/')}}"+"/"+package_id ,
          type: "GET",
      },
      columns: [
          { data: 'id', name:'id', visible:false},
          { data: 'instructor.name', name:'instructor.name', visible:true},
          { data: 'schedule', name:'schedule', visible:true},
          { data: 'duration', name:'duration', visible:true},
          { data: 'url_meet', name:'url_meet', visible:true},
          { data: 'action', name:'action', visible:true},
      ],
    });
    /* END  OF DATATABLE */

    /* START OF CREATE DETAIL*/
    $('#schedule-detail-store').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('schedule-detail.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                tableData.ajax.reload();
                toastr.success('Successfully added data!', 'Success', {timeOut: 5000});
                $("#schedule_detail_id").val('');
                $("#instructor").select2("val", "");
                $("#datetime").val('');
                $("#duration").val('');
                $("#urlmeet").val('');
              }else{
	              for(var count = 0; count < data.errors.length; count++){
	              	toastr.error(data.errors[count], 'Error', {timeOut: 5000});
                }
              }
            },

        });
    });
    /* END OF CREATE DETAIL*/

    /*START OF EDIT DETAIL*/
    $('#table-detail tbody').on('click', '#edit', function () {
        $('#modal-edit').modal('show');
        let data = tableData.row( $(this).parents('tr') ).data();
        let token = $('input[name=_token]').val();
        $('input[name=_method]').val('PUT');
        $('input[name=_token]').val(token);
        $('#id_edit').val(data['id']);
        $("#instructor_edit").val(data['instructor_id']).trigger('change');
        $("#datetime_edit").val(data['schedule'].replace(" ","T"));
        $("#duration_edit").val(data['duration']);
        $("#urlmeet_edit").val(data['url_meet']);
    });
    /*END OF EDIT DETAIL*/

    /*START OF DELETE DETAIL*/
      $('#table-detail tbody').on( 'click', '#delete', function () {
        var data = tableData.row( $(this).parents('tr') ).data();
        if (tableData.rows().count() == 1) {
            swal({
                text: "Can't delete last data!",
                icon: "warning",
                dangerMode: true,
            });
        } else {
            swal({
            text: "Are you sure to delete data?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                url: "{{ url('admin/schedule-detail/delete') }}"+"/"+data['id'],
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
        }
      });
      /*END OF DELETE DATA*/

    function formatDate(date)
    {
        newDate = new Date(date);
        return newDate.getDate()+"-"+newDate.getMonth()+"-"+newDate.getFullYear()+" "+("0" + newDate.getHours()).slice(-2)+":"+newDate.getMinutes();
    }

  });
</script>
@endpush
