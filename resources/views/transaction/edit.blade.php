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
        		<form class="form-horizontal" id="transaction-edit" method="post" enctype="multipart/form-data" files=true>
							@method('PUT')
              @csrf
              <fieldset class="content-group">
        				<legend class="text-bold">Package</legend>
                <div class="form-group">
                  <label class="control-label col-lg-12 text-center" id="package"></label>
                </div>
        				<legend class="text-bold">Payment</legend>
                <div class="form-group">
                  <label class="control-label col-lg-3">Collager Name </label>
                  <label class="control-label col-lg-9" id="collager">:</label>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Amount Paid </label>
                  <label class="control-label col-lg-9" id="amount">: </label>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Payment Method <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <select class="select-search" data-placeholder="Choose Payment Method" name="payment_method" id="payment_method" require>
                        @foreach(\App\Component::where('code_group','PAYMENT_METHOD')->get() as $value => $key)
                            <option value=""></option>
                            <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Payment Status <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <select class="select-search" data-placeholder="Choose Status" name="status" id="status" require>
                        @foreach(\App\Component::where('code_group','TRANS')->get()->sortBy('code_value') as $value => $key)
                            <option value=""></option>
                            <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-lg-3">Date Valid <span class="text-danger">*</span></label>
                  <div class="col-lg-9">
                    <input type="hidden" name="transaction_id" class="form-control" value="" placeholder="Start">
                    <input type="datetime-local" name="start_date" class="form-control" value="" placeholder="Start">
                    <input type="datetime-local" name="expired_date" class="form-control" value="" placeholder="Expired">
                  </div>
                </div>
                <!-- <div class="form-group">
        					<label class="control-label col-lg-3">Picture</label>
                  <div id="img-edit" class="col-lg-9"></div>
									<label class="control-label col-lg-3"></label>
									<div class="col-lg-9">
										<input type="file" name="picture_edit" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
									</div>
        				</div> -->
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
		$('#transaction-edit').on('submit', function (e) {
      e.preventDefault();
        $.ajax({
						'type': 'post',
						'url' : "{{ url('admin/transaction') }}"+"/"+$('input[name=transaction_id]').val(),
						'data': new FormData(this),
            'processData': false,
            'contentType': false,
            'dataType': 'JSON',
            'success': function(data){
							if(data.success){
                $('#modal-edit').modal('hide');
								toastr.success('Successfully updated data!', 'Success', {timeOut: 5000});
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
