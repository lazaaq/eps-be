<div id="modal-create" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      	<div class="panel panel-flat">
          <div class="panel-body">
        		<form class="form-horizontal" id="quiz-store" method="post" enctype="multipart/form-data" files=true>
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Create Quiz</legend>
                <div class="form-group div-lpk">
                  <label class="control-label col-lg-3">LPK <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                  <select class="select-search" data-placeholder="Choose LPK" name="lpk" id="lpk" require>
                      <option value=""></option>
                      <option value="umum">Umum</option>
                      @foreach(\App\Lpk::get()->sortBy('name') as $value => $key)
                      <option value="{{$key->id}}">{{$key->name}}</option>
                      @endforeach
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Quiz Category - Type<span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <select id="type" class="select-search" name="quiz_type">
                        @foreach($quiztype as $value1 => $key1)
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
                  <label class="control-label col-lg-3">Title <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="">
                      @if ($errors->has('title'))
                      <label style="padding-top:7px;color:#F44336;">
                          <strong><i class="fa fa-times-circle"></i> {{ $errors->first('title') }}</strong>
                      </label>
                      @endif
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Total Visible Question <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="0" name="total_visible_question" class="form-control" value="{{ old('total_visible_question') }}" placeholder="">
                      @if ($errors->has('total_visible_question'))
                      <label style="padding-top:7px;color:#F44336;">
                          <strong><i class="fa fa-times-circle"></i> {{ $errors->first('total_visible_question') }}</strong>
                      </label>
                      @endif
                  </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Time (minute)<span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                    <input type="number" min="1" name="time" class="form-control" value="{{ old('time') }}" placeholder="">
                        @if ($errors->has('time'))
                        <label style="padding-top:7px;color:#F44336;">
                            <strong><i class="fa fa-times-circle"></i> {{ $errors->first('time') }}</strong>
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
										<input type="file" name="picture" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
        						{{-- <input type="file" name="picture" class="form-control"> --}}
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
<script type="text/javascript" src="{{asset('js/libraries/jquery.chained.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
		$("#type").chained("#category");
    /* save data */
    $('#quiz-store').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('quiz.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                id = data.data.id;
                $('#modal-create').modal('hide');
                window.location.href = "{{ url('admin/quiz') }}"+"/"+id;
                toastr.success('Successfully added data!', 'Success', {timeOut: 5000});
              }else{
								console.log(data);
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
