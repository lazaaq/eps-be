<div id="modal-create" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      	<div class="panel panel-flat">
          <div class="panel-body">
        		<form class="form-horizontal" id="quiz-type-store" method="post" enctype="multipart/form-data" files=true>
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Create Quiz Type</legend>
                <!-- <div class="form-group div-lpk">
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
                </div> -->
                <div class="form-group">
                  <label class="control-label col-lg-3">Category Name <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                  <select id="quiz_category" class="select-search" name="quiz_category">
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Type Name <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Description <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <textarea type="text" name="description" rows="3" class="form-control"  placeholder="">{{ old('description') }}</textarea>
                  </div>
                </div>
                <div class="form-group">
        					<label class="control-label col-lg-3">Picture</label>
        					<div class="col-lg-9">
										<input type="file" name="picture" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
        					</div>
        				</div>
                <div class="form-group">
        					<label class="control-label col-lg-3 text-bold">Add to Package?</label>
        					<div class="col-lg-9">
                    <div class="checkbox checkbox-switch">
                        <label>
                          <input type="checkbox" id="chk" name="chk[]" value="yes" data-off-color="danger" data-on-text="Yes" data-off-text="No" class="switch">
                        </label>
                    </div>
        					</div>
        				</div>
                <div class="form-group" id="div-price">
                  <label class="control-label col-lg-3">Price <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="10000000">
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
    $('#div-price').hide();
    $('#chk').on('switchChange.bootstrapSwitch', function (event, state) {
      if ($("#chk").prop('checked') == true){
        $('#div-price').slideDown();
      } else {
        $('#div-price').slideUp();
      }
    });
    $('#quiz-type-store').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('quiztype.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                $('#modal-create').modal('hide');
								toastr.success('Successfully added data!', 'Success', {timeOut: 5000});
								tableQuizType.ajax.reload();
              }else{
								console.log(data);
	              for(var count = 0; count < data.errors.length; count++){
	              	toastr.error(data.errors[count], 'Error', {timeOut: 5000});
                }
              }
            },

        });
    });

    $('#quiz_category').select2({
      ajax : {
        url :  "{{ url('select/data-quiz-category') }}",
        dataType: 'json',
        data: function(params){
            return {
                term: params.term,
            };
        },
        processResults: function(data){
            return {
                results: data
            };
        },
        cache : true,
      },
    });

});

</script>
@endpush
