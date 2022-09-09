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
                        <form class="form-horizontal" id="uji-kemampuan-edit" method="put" enctype="multipart/form-data"
                            files="true">
                            @method('PUT') @csrf
                            <fieldset class="content-group">
                                <legend class="text-bold">
                                    Edit Uji Kemampuan
                                </legend>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Name
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="hidden" name="id_edit" class="form-control" value=""
                                            placeholder="" />
                                        <input type="text" name="name_edit" class="form-control" value=""
                                            placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Min Score
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="number" min="0" name="min_score_edit" class="form-control" value=""
                                            placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Max Score
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <input type="number" min="0" name="max_score_edit" class="form-control" value=""
                                            placeholder="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3">Description</label>
                                    <div class="col-lg-9">
                                        <textarea type="text" name="description_edit" rows="3" class="form-control"
                                            placeholder=""></textarea>
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
                                    <button type="submit" id="btn-save-konsul" class="btn btn-primary">
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
        $("#uji-kemampuan-edit").on("submit", function (e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "{{ url('admin/uji-kemampuan') }}" +
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
                            "Success", {
                                timeOut: 5000
                            }
                        );
                        $(".file-input").addClass("file-input-new");
                        tableUjiKemampuan.ajax.reload();
                    } else {
                        for (
                            var count = 0; count < data.errors.length; count++
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
