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
            <li>Master Data</li>
            <li><a href="{{url('admin/noninteractive')}}">Non Interactive</a></li>
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
    <form class="form-horizontal" id="form-non-interactive" method="post" enctype="multipart/form-data" files=true>
      @csrf
      <fieldset class="content-group">
        <legend class="text-bold">Create Non Interactive</legend>
        <div class="form-group">
          <label class="control-label col-lg-3">Package - Type<span class="text-danger">*</span></label>
          <div class="col-lg-9">
            <select id="type" class="select-search" data-placeholder="Choose Quiz Type" name="quiz_type">
                <option value=""></option>
                @foreach($quiztype->where('name','Non Interactive')->sortBy('quiz_category_id') as $value1 => $key1)
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
          <label class="control-label col-lg-3">Price <span class="text-danger">*</span></label>
          <div class="col-lg-9">
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="">
              @if ($errors->has('price'))
              <label style="padding-top:7px;color:#F44336;">
                  <strong><i class="fa fa-times-circle"></i> {{ $errors->first('price') }}</strong>
              </label>
              @endif
          </div>
        </div>
        <legend class="text-bold">Details</legend>
        <div class="col-lg-12 row">
          <div class="col-lg-12 row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Type File<span class="text-danger">*</span></label>
                <select class="select-search" data-placeholder="Choose Type File" name="typefile" id="typefile" require>
                    @foreach(comGroup('TYPE_FILE') as $value => $key)
                        <option value=""></option>
                        <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                    @endforeach
                </select>
                  @if ($errors->has('typefile'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('typefile') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Source<span class="text-danger">*</span></label>
                <select class="select-search" data-placeholder="Choose Source" name="source" id="source" require>
                    @foreach(comGroup('SOURCE') as $value => $key)
                        <option value=""></option>
                        <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                    @endforeach
                </select>
                  @if ($errors->has('source'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('source') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3" id="div-external_source_vid">
              <div class="form-group">
                <label class="control-label">Eksternal Source Vid<span class="text-danger">*</span></label>
                <select class="select-search" data-placeholder="Choose External Source" name="external_source_vid" id="external_source_vid" require>
                    @foreach(comGroup('SOURCE_EX_VID') as $value => $key)
                        <option value=""></option>
                        <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                    @endforeach
                </select>
                  @if ($errors->has('external_source_vid'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('external_source_vid') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3" id="div-external_source_pdf">
              <div class="form-group">
                <label class="control-label">Eksternal Source PDF<span class="text-danger">*</span></label>
                <select class="select-search" data-placeholder="Choose External Source" name="external_source_pdf" id="external_source_pdf" require>
                    @foreach(comGroup('SOURCE_EX_PDF') as $value => $key)
                        <option value=""></option>
                        <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                    @endforeach
                </select>
                  @if ($errors->has('external_source_pdf'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('external_source_pdf') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3" id="div-fileurl">
              <div class="form-group">
                <label class="control-label">File Url<span class="text-danger">*</span></label>
                <input type="url" name="fileurl" id="fileurl" class="form-control" value="{{ old('fileurl') }}" placeholder="https://......." require>
                  @if ($errors->has('fileurl'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('fileurl') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3" id="div-file_upload">
              <div class="form-group">
                <label class="control-label">File Upload<span class="text-danger">*</span></label>
                <input type="file" name="file_upload" id="file_upload" class="form-control" value="{{ old('file_upload') }}" placeholder="" require>
                  @if ($errors->has('file_upload'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('file_upload') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
          </div>

          <div class="col-lg-12 row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Name<span class="text-danger">*</span></label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="" require>
                  @if ($errors->has('name'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('name') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="control-label">Description<span class="text-danger">*</span></label>
                  <input type="text" name="description" id="description" class="form-control" value="{{ old('description') }}" placeholder=" " require>
                  @if ($errors->has('description'))
                  <label style="padding-top:7px;color:#F44336;">
                      <strong><i class="fa fa-times-circle"></i> {{ $errors->first('description') }}</strong>
                  </label>
                  @endif
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <a type="" class="btn bg-indigo add-row"><i class="icon-add position-left"></i> Add Details</a>
            <table class="table" id="table-detail">
              <thead>
                <tr>
                  <th class="col-md-3">Type</th>
                  <th class="col-md-3">Name</th>
                  <th class="col-md-1">Description</th>
                  <th class="col-md-3">File Url</th>
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
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-arrow-left13"></i> Close</button>
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
    $("#div-external_source_vid").hide()
    $("#div-external_source_pdf").hide()
    $("#div-file_upload").hide()
    $("#div-fileurl").hide()

    $('#source').change(function() {
      getFileType();
    });
    $('#typefile').change(function() {
      getFileType();
    });

    $(".add-row").click(function(){
        var typefile = $("#typefile").val();
        var name = $("#name").val();
        var description = $("#description").val();
        var fileurl = $("#fileurl").val() || $("#file_upload").val();
        // console.log($("#file_upload").prop('files')[0])
        if (typefile == '' || name == '' || description == '' || fileurl == '') {
            swal({
                text: "Complete the field!",
                icon: "warning",
                dangerMode: true,
            });
        } else {
            var markup = "<tr style='text-align:left'> " +
                            "<td>" +  $("#typefile option:selected").text() + "<input type='hidden' name='typefile[]' value="+typefile+"> </td>" +
                            "<td>" + name + "<input type='hidden' name='name[]' value="+name+"></td> " +
                            "<td>" + description + "<input type='hidden' name='description[]' value="+description+"></td> " +
                            "<td>" + fileurl + "</td> " +
                            "<td>" +
                            "<a id='btn-edit' class='btn border-info btn-xs text-info-600 btn-flat btn-icon'><i class='icon-pencil6'></i></a>" +
                            "<a id='delete' class='btn border-warning btn-xs text-warning-600 btn-flat btn-icon'><i class='icon-trash'></i></a>" +
                            "</td>" +
                        "</tr>";
            // var data = ""
            $('#table-detail tbody').append(markup);
            $("#name").val('');
            $("#description").val('');
            $("#fileurl").val('');
            $("#file_upload").val('');
        }
    });
    $('#table-detail tbody').on( 'click', '#delete', function () {
        $(this).parent().parent().remove();
    });

    $("#form-non-interactive").submit(function(e){
        console.log('a')
        e.preventDefault();
        $(':input[value=""] :select').attr('disabled', true);
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('noninteractive.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
                console.log(data);
            },
        });
    });

  });



  function getFileType(){
    if ($('#source').val() == 'SOURCE_1') {
        $("#div-external_source_vid").hide()
        $("#div-external_source_pdf").hide()
        $("#div-file_upload").show()
        $("#div-fileurl").hide()
    } else if ($('#source').val() == 'SOURCE_2') {
        if ($('#typefile').val() == 'TYPE_FILE_1') {
          $("#div-external_source_vid").hide()
          $("#div-external_source_pdf").show()
          $("#div-file_upload").hide()
          $("#div-fileurl").show()
        } else if($('#typefile').val() == 'TYPE_FILE_2') {
          $("#div-external_source_vid").show()
          $("#div-external_source_pdf").hide()
          $("#div-file_upload").hide()
          $("#div-fileurl").show()
        }
    }
  }
</script>
@endpush
