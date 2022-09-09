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
        		<form class="form-horizontal" id="quiz-type-edit" method="post" enctype="multipart/form-data" files=true>
							@method('PUT')
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Edit Quiz Type</legend>
                <!-- <div class="form-group div-lpk">
                  <label class="control-label col-lg-3">LPK <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                  <select class="select-search" name="lpk_edit" id="lpk_edit" require>
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
                  <select id="quiz_category_edit" class="select-search" name="quiz_category_edit">
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Type Name <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="hidden" name="id_edit" class="form-control" value="" placeholder="">
                    <input type="text" name="name_edit" class="form-control" value="" placeholder="">
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
										{{-- <input type="file" name="picture_edit" class="form-control"> --}}
									</div>
        				</div>
                <div class="form-group" id="div-add-package-edit">
        					<label class="control-label col-lg-3 text-bold">Add to Package?</label>
        					<div class="col-lg-9">
                    <div class="checkbox checkbox-switch">
                        <label>
                          <input type="checkbox" id="chk-edit" name="chk_edit[]" value="yes" data-off-color="danger" data-on-text="Yes" data-off-text="No" class="switch">
                        </label>
                    </div>
        					</div>
        				</div>
                <div class="form-group" id="div-price-edit">
                  <label class="control-label col-lg-3">Price <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" name="price_edit" class="form-control" value="{{ old('price_edit') }}" placeholder="10000000">
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
    /* START OF SAVE DATA */
    $('#div-price-edit').hide();
		$('#quiz-type-edit').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
						'type': 'post',
						'url' : "{{ url('admin/quiztype') }}"+"/"+$('input[name=id_edit]').val(),
						'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                $('#modal-edit').modal('hide');
								toastr.success('Successfully updated data!', 'Success', {timeOut: 5000});
								tableQuizType.ajax.reload();
              }else{
                for(var count = 0; count < data.errors.length; count++){
	              	toastr.error(data.errors[count], 'Error', {timeOut: 5000});
                }
              }
            },

        });
    });

    $('#quiz_category_edit').select2({
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

    $('#chk-edit').on('switchChange.bootstrapSwitch', function (event, state) {
      if ($("#chk-edit").prop('checked') == true){
        $('#div-price-edit').slideDown();
      } else {
        $('#div-price-edit').slideUp();
      }
    });
});

</script>
@endpush
