<!-- Content area -->
<div id="modal-edit" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <form class="form-horizontal" id="schedule-detail-edit" method="post" enctype="multipart/form-data">
                            @method('PUT') @csrf
                            <fieldset class="content-group">
                                <legend class="text-bold">
                                    Edit Schedule Detail
                                </legend>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Instructor
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="hidden" name="id_edit" id="id_edit" class="form-control" value=""
                                            placeholder="" />
                                            <select class="select-search" data-placeholder="Choose Instructor" name="instructor_edit" id="instructor_edit" required>
                                                @foreach(\App\Instructor::get() as $value => $key)
                                                    <option value=""></option>
                                                    <option value="{{$key->id}}">{{$key->name}}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Date & Time
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="datetime-local" name="datetime_edit" id="datetime_edit" class="form-control" value="" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Duration
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="number" name="duration_edit" id="duration_edit" min="0" class="form-control" value="" placeholder="in minutes" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Duration
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="url" name="urlmeet_edit" id="urlmeet_edit" class="form-control" value="" placeholder="https://......." required>
                                    </div>
                                </div>
                            </fieldset>
                            <div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        <i class="icon-arrow-left13"></i> Close
                                    </button>
                                </div>
                                <div class="col-md-8 text-right">
                                    <button type="reset" class="btn btn-default" id="reset">
                                        Reset
                                        <i class="icon-reload-alt position-right"></i>
                                    </button>
                                    <button type="submit" id="btn-save-modal-edit" class="btn btn-primary">
                                        Simpan
                                    </button>
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
    $(document).ready(function () {
        /* START OF SAVE DATA */
        $("#schedule-detail-edit").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url:
                    "{{ url('admin/schedule-detail') }}" +
                    "/" +
                    $("input[name=id_edit]").val(),
                data: new FormData(this),
                processData: false,
                contentType: false,
                dataType: "JSON",
                success: function (data) {
                    if (data.success) {
                        $("#modal-edit").modal("hide");
                        toastr.success(
                            "Successfully updated data!",
                            "Success",
                            {
                                timeOut: 5000,
                            }
                        );
                        tableData.ajax.reload();
                    } else {
                        for (
                            var count = 0;
                            count < data.errors.length;
                            count++
                        ) {
                            toastr.error(data.errors[count], "Error", {
                                timeOut: 5000,
                            });
                        }
                    }
                },
            });
        });
    });
</script>
@endpush
