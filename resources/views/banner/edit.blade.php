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
        		<form class="form-horizontal" id="banner-edit" method="post" enctype="multipart/form-data" files=true>
							@method('PUT')
              @csrf
              <fieldset class="content-group">
                <legend class="text-bold">Edit Banner</legend>
                <div class="form-group">
                  <label class="control-label col-lg-3">Description <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="hidden" name="id_edit" class="form-control" value="" placeholder="">
                    <textarea type="text" name="description_edit" rows="3" class="form-control"  placeholder=""></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Link To <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="link_to_edit" class="form-control" value="" placeholder="">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label class="control-label col-lg-3">Is Viewed<span class="text-danger">*</span></label>
									<div class="col-lg-9">
                    <label class="radio-inline col-md-3">
                      <input type="radio" id="view" name="isViewEdit" value="1" class="styled">
                      View
                    </label>
                    <label class="radio-inline col-md-3">
                      <input type="radio" id="notView" name="isViewEdit" value="0" class="styled">
                      Not View
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Is Viewed Web<span class="text-danger">*</span></label>
									<div class="col-lg-9">
                    <label class="radio-inline col-md-3">
                      <input type="radio" id="viewWeb" name="isViewWebEdit" value="1" class="styled">
                      View
                    </label>
                    <label class="radio-inline col-md-3">
                      <input type="radio" id="notViewWeb" name="isViewWebEdit" value="0" class="styled">
                      Not View
                    </label>
                  </div>
                </div> -->
                <div class="form-group">
        					<label class="control-label col-lg-3">Picture</label>
                  <div id="img-edit" class="col-lg-9"></div>
									<label class="control-label col-lg-3"></label>
									<div class="col-lg-9">
										<input type="file" name="picture_edit" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
										{{-- <input type="file" name="picture_edit" class="form-control"> --}}
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
		$('#banner-edit').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
						'type': 'post',
						'url' : "{{ url('admin/banner') }}"+"/"+$('input[name=id_edit]').val(),
						'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							console.log(data);
							if(data.success){
                $('#modal-edit').modal('hide');
								toastr.success('Successfully updated data!', 'Success', {timeOut: 5000});
								tableBanner.ajax.reload();
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
