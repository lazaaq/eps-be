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
        		<form class="form-horizontal" id="lpk-edit" method="put" enctype="multipart/form-data" files=true>
							@method('PUT')
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Edit Quiz Category</legend>
                <div class="form-group">
                  <label class="control-label col-lg-3">LPK Name <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="hidden" name="id_edit" class="form-control" value="{{ old('id_edit') }}" placeholder="">
                    <input type="text" name="name_edit" class="form-control" value="{{ old('name_edit') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Address <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <textarea type="text" name="address_edit" rows="3" class="form-control"  placeholder="">{{ old('address_edit') }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Phone Number <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="number" name="phone_number_edit" class="form-control" value="{{ old('phone_number_edit') }}" placeholder="">
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
		$('#lpk-edit').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
						'type': 'post',
						'url' : "{{ url('admin/lpk') }}"+"/"+$('input[name=id_edit]').val(),
						'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							if(data.success){
                $('#modal-edit').modal('hide');
								toastr.success('Successfully updated data!', 'Success', {timeOut: 5000});
                $('.file-input').addClass('file-input-new');
								tableData.ajax.reload();
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
