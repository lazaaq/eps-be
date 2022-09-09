<!-- Content area -->
<div id="modal-edit" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      	<div class="panel panel-flat">
          <div class="panel-body">
        		<form class="form-horizontal" id="quiz-edit" method="post" enctype="multipart/form-data" files=true>
							@method('PUT')
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Edit Quiz</legend>
                <div class="form-group div-lpk">
                  <label class="control-label col-lg-3">LPK <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                  <select class="select-search" name="lpk_edit" id="lpk_edit" require>
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
										<input type="hidden" name="id_edit" class="form-control" value="" placeholder="">
                    <select id="type-edit" class="select-search" name="quiz_type_edit">
                        @foreach($quiztype as $value => $key)
                            <option value="{{$key->id}}" class="{{$key->quiz_category_id}}">{{$key->quizCategory->root.' - '.$key->quizCategory->name.' - '.$key->name}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Title <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="title_edit" class="form-control" value="" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Total Question <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="1" name="total_question_edit" class="form-control" value="" placeholder="" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Total Visible Question <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="0" max="" name="total_visible_question_edit" class="form-control" value="" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Time (minute) <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" min="1" max="" name="time" class="form-control" value="" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Description <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <textarea type="text" name="description_edit" rows="3" class="form-control"  placeholder=""></textarea>
                  </div>
                </div>
                <div class="form-group">
        					<label class="control-label col-lg-3">Picture</label>
                  <div id="img-edit" class="col-lg-9"></div>
									<label class="control-label col-lg-3"></label>
									<div class="col-lg-9">
										<input type="file" name="picture_edit" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
									</div>
        				</div>
        			</fieldset>
              <div>
                <div class="col-md-4">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="icon-arrow-left13"></i> Close</button>
                </div>
                <div class="col-md-8 text-right">
                  <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                  <button type="submit" id="btn-save-konsul" class="btn btn-primary">Simpan</button>
                </div>
        			</div>
        		</form>
        	</div>
      	<!-- /state saving -->
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /content area -->
@push('after_script')
<script type="text/javascript">
$(document).ready(function(){
	$("#type-edit").chained("#category-edit");
    /* START OF SAVE DATA */
		$('#quiz-edit').on('submit', function (e) {
      e.preventDefault();
			id = $('input[name=id_edit]').val();
        $.ajax({
						'type': 'post',
						'url' : "{{ url('admin/quiz') }}"+"/"+id,
						'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                $('#modal-edit').modal('hide');
								toastr.success('Successfully updated data!', 'Success', {timeOut: 5000});
								tableQuiz.ajax.reload();
              }else{
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
