{{-- @extends('layouts.app')
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
            <li><a href="{{route('uji-kemampuan.index')}}">Uji Kemampuan</a></li>
            <li class="active">Create</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
  <!-- State saving -->
	<div class="panel panel-flat">
    <div class="panel-body">
  		<form class="form-horizontal form-validate-jquery" action="{{route('uji-kemampuan.store')}}" method="post" enctype="multipart/form-data" files=true>
        {{ csrf_field() }}
  			<fieldset class="content-group">
  				<legend class="text-bold">Creat Quiz Category</legend>

          <div class="form-group">
            <label class="control-label col-lg-3">Category Name <span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="">
                @if ($errors->has('name'))
                <label style="padding-top:7px;color:#F44336;">
                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('name') }}</strong>
                </label>
                @endif
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-lg-3">Description <span class="text-danger">*</span></label>
            <div class="col-lg-9">
              <textarea type="text" name="description" rows="3" class="form-control"  placeholder="">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                <label style="padding-top:7px;color:#F44336;">
                    <strong><i class="fa fa-times-circle"></i>{{ $errors->first('description') }}</strong>
                </label>
                @endif
            </div>
          </div>
          <div class="form-group">
  					<label class="control-label col-lg-3">Picture</label>
  					<div class="col-lg-9">
  						<input type="file" name="picture" class="form-control">
              @if ($errors->has('picture'))
              <label style="padding-top:7px;color:#F44336;">
              <strong><i class="fa fa-times-circle"></i>{{ $errors->first('picture') }}</strong>
              </label>
              @endif
  					</div>
  				</div>
  			</fieldset>
        <div>
          <div class="col-md-4">
            <a href="{{route('uji-kemampuan.index')}}"type="reset" class="btn btn-default" id=""> <i class="icon-arrow-left13"></i> Back</a>
          </div>
          <div class="col-md-8 text-right">
            <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
    				<button type="submit" class="btn btn-primary bg-primary-800">Submit <i class="icon-arrow-right14 position-right"></i></button>
          </div>
  			</div>
  		</form>
  	</div>
	<!-- /state saving -->
  </div>
</div>
<!-- /content area -->
@endsection
@push('after_script')
  <script>

  </script>
@endpush --}}

<div id="modal-create" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      	<div class="panel panel-flat">
          <div class="panel-body">
        		<form class="form-horizontal" id="uji-kemampuan-store" method="post" enctype="multipart/form-data" files=true>
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Create Uji Kemampuan</legend>
                <div class="form-group">
                  <label class="control-label col-lg-3">Name <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Min Score <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="0" name="min_score" class="form-control" value="{{ old('min_score') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Max Score <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="0" name="max_score" class="form-control" value="{{ old('max_score') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Description</label>
                  <div class="col-lg-9">
                    <textarea type="text" name="description" rows="3" class="form-control"  placeholder="">{{ old('description') }}</textarea>
                  </div>
                </div>
        		</fieldset>
              <div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-arrow-left13"></i> Close</button>
                </div>
                <div class="col-md-8 text-right">
                  <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                  <button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
                </div>
        			</div>
        		</form>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /content area -->
@push('after_script')
<script type="text/javascript">
$(document).ready(function(){
    /* save data */
    $('#uji-kemampuan-store').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('uji-kemampuan.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
			if(data.success){
                $('#modal-create').modal('hide');
                toastr.success('Successfully added data!', 'Success', {timeOut: 5000});
                tableUjiKemampuan.ajax.reload();
            } else {
	            for(var count = 0; count < data.errors.length; count++){
	              	toastr.error(data.errors[count], 'Error', {timeOut: 5000});
                }
              }
            },
        });
    });
});

</script>
@endpush
