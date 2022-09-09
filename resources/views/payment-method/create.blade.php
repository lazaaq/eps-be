<div id="modal-create" class="modal fade">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
      <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
      	<div class="panel panel-flat">
          <div class="panel-body">
        		<form class="form-horizontal" id="instructor-store" method="post" enctype="multipart/form-data" files=true>
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Create Payment Method</legend>
                <div class="form-group">
                  <label class="control-label col-lg-3">Account <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="account_name" class="form-control" value="{{ old('account_name') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Owner <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="owner" class="form-control" value="{{ old('owner') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">ID Number <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="text" name="id_number" class="form-control" value="{{ old('id_number') }}" placeholder="">
                  </div>
                </div>
                <div class="form-group">
        					<label class="control-label col-lg-3">Logo</label>
        					<div class="col-lg-9">
										<input type="file" name="logo" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
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
    $('#instructor-store').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
            'type': 'POST',
            'url' : "{{ route('payment-method.store') }}",
            'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							if(data.success){
                $('#modal-create').modal('hide');
								toastr.success('Successfully added data!', 'Success', {timeOut: 5000});
								tableData.ajax.reload();
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
