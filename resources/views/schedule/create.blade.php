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
            <li href="{{url('admin/package')}}">Schedule</li>
            <li class="active">Create</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-white">
		<div class="panel-body">
    <form class="form-horizontal" action="{{route('package.store')}}" method="post" enctype="multipart/form-data" files=true>
      @csrf
      <fieldset class="content-group">
        <legend class="text-bold">Create Schedule</legend>
        <div class="form-group">
          <label class="control-label col-lg-3">Package - Type<span class="text-danger">*</span></label>
          <div class="col-lg-9">
            <select id="type" class="select-search" data-placeholder="Choose Quiz Type" name="quiz_type">
                <option value=""></option>
                @foreach($quiztype->whereIn('name',['Private','Group'])->sortBy('quiz_category_id') as $value1 => $key1)
                    <option value="{{$key1->id}}" {{collect(old('quiz_type'))->contains($key1->id) ? 'selected':''}} class="{{$key1->quiz_category_id}}">{{$key1->quizCategory->root.' - '.$key1->quizCategory->name.' - '.$key1->name}}</option>
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
            <input type="number" min="1" name="quota" class="form-control" value="{{ old('quota') }}" placeholder="">
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
            <input type="number" min="1" name="price" class="form-control" value="{{ old('price') }}" placeholder="">
              @if ($errors->has('price'))
              <label style="padding-top:7px;color:#F44336;">
                  <strong><i class="fa fa-times-circle"></i> {{ $errors->first('price') }}</strong>
              </label>
              @endif
          </div>
        </div>
        <legend class="text-bold">Details</legend>
        <div class="col-lg-12 row">
          <div class="col-md-3">
            <div class="form-group">
              <label class="control-label">Instructor<span class="text-danger">*</span></label>
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
            <a type="" class="btn bg-indigo add-row"><i class="icon-add position-left"></i> Add Details</a>
            <table class="table" id="table-detail">
              <thead>
                <tr>
                  <th class="col-md-3">Instructor</th>
                  <th class="col-md-3">Date and Time</th>
                  <th class="col-md-1">Duration</th>
                  <th class="col-md-3">Meet url</th>
                  <th class="col-md-2">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </fieldset>
      <div>
        <div class="col-md-4">
          <a href="{{route('package.index')}}" type="button" class="btn btn-default"><i class="icon-arrow-left13"></i> Close</a>
        </div>
        <div class="col-md-8 text-right">
          <button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
		</div>
	</div>
	<!-- /state saving -->
</div>
<!-- /content area -->
@endsection
@push('after_script')
<script type="text/javascript">
  $(document).ready(function(){
    $(".add-row").click(function(){
        var instructor = $("#instructor option:selected").text();
        var instructor_id = $("#instructor option:selected").val();
        var datetime = $("#datetime").val();
        var duration = $("#duration").val();
        var urlmeet = $("#urlmeet").val();
        if (instructor == '' || datetime == '' || duration == '' || urlmeet == '') {
            swal({
                text: "Complete the field!",
                icon: "warning",
                dangerMode: true,
            });
        } else {
            var markup = "<tr style='text-align:left'> " +
                            "<td>" + instructor + "<input type='hidden' name='instructor[]' value="+instructor_id+"> </td>" +
                            "<td>" + formatDate(datetime) + "<input type='hidden' name='datetime[]' value="+datetime+"></td> " +
                            "<td>" + duration + "<input type='hidden' name='duration[]' value="+duration+"></td> " +
                            "<td>" + urlmeet + "<input type='hidden' name='urlmeet[]' value="+urlmeet+"></td> " +
                            "<td>" +
                            "<a id='btn-edit' class='btn border-info btn-xs text-info-600 btn-flat btn-icon'><i class='icon-pencil6'></i></a>" +
                            "<a id='delete' class='btn border-warning btn-xs text-warning-600 btn-flat btn-icon'><i class='icon-trash'></i></a>" +
                            "</td>" +
                        "</tr>";
            // var data = ""
            $('#table-detail tbody').append(markup);
            $("#instructor").select2("val", "");
            $("#datetime").val('');
            $("#duration").val('');
            $("#urlmeet").val('');
        }
    });

    $('#table-detail tbody').on( 'click', '#delete', function () {
        $(this).parent().parent().remove();
    });

    function formatDate(date)
    {
        newDate = new Date(date);
        return newDate.getDate()+"-"+newDate.getMonth()+"-"+newDate.getFullYear()+" "+("0" + newDate.getHours()).slice(-2)+":"+newDate.getMinutes();
    }

  });
</script>
@endpush
