@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Non Interactive</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li>Master Data</li>
            <li><a href="{{url('admin/noninteractive')}}">Non Interactive</a></li>
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <!-- State saving -->
    <div class="panel panel-white">
        <div class="panel-body">
            <fieldset class="content-group">
                <legend class="text-bold">Edit Schedule</legend>
                <form class="form-horizontal" action="{{route('package.update',$data->id)}}" method="post"
                    enctype="multipart/form-data" files=true>
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="control-label col-lg-3">Quiz Category - Type<span
                                class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <select id="type" class="select-search" data-placeholder="Choose Quiz Type"
                                name="quiz_type">
                                <option value=""></option>
                                @foreach($quiztype->where('name','Non Interactive')->sortBy('quiz_category_id') as $value1 => $key1)
                                <option value="{{$key1->id}}" {{ collect(old('quiz_type'))->contains($key1->id) ?
                                    'selected': (($key1->id == $data->quiz_type_id) ? 'selected' : '')}}
                                    class="{{$key1->quiz_category_id}}">{{$key1->quizCategory->root.' -
                                    '.$key1->quizCategory->name.' - '.$key1->name}}</option>
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
                        <label class="control-label col-lg-3">Price <span class="text-danger">*</span></label>
                        <div class="col-lg-9">
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price') ? old('price') : $data->price }}" placeholder="">
                            @if ($errors->has('price'))
                            <label style="padding-top:7px;color:#F44336;">
                                <strong><i class="fa fa-times-circle"></i> {{ $errors->first('price') }}</strong>
                            </label>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="col-md-4">
                            <a href="{{route('noninteractive.index')}}" type="button" class="btn btn-default"><i
                                    class="icon-arrow-left13"></i> Close</a>
                        </div>
                        <div class="col-md-8 text-right" style="margin-bottom:30px">
                            <button type="submit" id="btn-submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
                <legend class="text-bold">Details</legend>
                <div class="col-lg-12 row">
                    <form class="form-horizontal" id="non-interactive-store" method="post"
                        enctype="multipart/form-data" files=true>
                        @csrf
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Type File<span class="text-danger">*</span></label>
                                <input type="hidden" name="package_id" id="package_id" class="form-control"
                                    value="{{$data->id}}" placeholder="" require>
                                <select class="select-search" data-placeholder="Choose Type File" name="typefile"
                                    id="typefile" require>
                                    @foreach(comGroup('TYPE_FILE') as $value => $key)
                                    <option value=""></option>
                                    <option value="{{$key->com_cd}}">{{$key->code_nm}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('typefile'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('typefile') }}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                    placeholder="" require>
                                @if ($errors->has('name'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('name') }}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Description<span class="text-danger">*</span></label>
                                <input type="text" name="description" id="description" class="form-control"
                                    value="{{ old('description') }}" placeholder=" " require>
                                @if ($errors->has('description'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('description')
                                        }}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">File Url<span class="text-danger">*</span></label>
                                <input type="url" name="fileurl" id="fileurl" class="form-control"
                                    value="{{ old('fileurl') }}" placeholder="https://......." require>
                                @if ($errors->has('fileurl'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('fileurl') }}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" id="btn-submit" class="btn bg-indigo add-row">Update Details</button>
                        </div>
                    </form>
                    <div class="col-md-12 text-right">
                        <table class="table" id="table-detail">
                            <thead>
                                <tr>
                                    <th class="">ID</th>
                                    <th class="col-md-3">Type File</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-1">Description</th>
                                    <th class="col-md-3">File Url</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                            </thead>
                            <tbody style="text-align:left">
                            </tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
    <!-- /state saving -->
</div>
<!-- /content area -->
@endsection
@push('after_script')
<script type="text/javascript">
    $(document).ready(function () {
        let package_id = "{{$data->id}}";
        /* START OF DATATABLE */
        tableData = $('#table-detail').DataTable({
            bFilter: false, bInfo: false,
            processing: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records"
            },
            // dom 		: "<fl<t>ip>",
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{url('table/data-noninteractive/')}}" + "/" + package_id,
                type: "GET",
            },
            columns: [
                { data: 'id', name: 'id', visible: false },
                { data: 'type', name: 'type', visible: true },
                { data: 'name', name: 'name', visible: true },
                { data: 'description', name: 'description', visible: true },
                { data: 'file_url', name: 'file_url', visible: true },
                { data: 'action', name: 'action', visible: true },
            ],
        });
        /* END  OF DATATABLE */

        /* START OF CREATE DETAIL*/
        $('#non-interactive-store').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                'type': 'POST',
                'url': "{{ route('noninteractive.store') }}",
                'data': new FormData(this),
                'processData': false,
                'contentType': false,
                'dataType': 'JSON',
                'success': function (data) {
                    console.log(data);
                    if (data.success) {
                        tableData.ajax.reload();
                        toastr.success('Successfully added data!', 'Success', { timeOut: 5000 });
                        $("#non_interactive_id").val('');
                        $("#typefile").val('');
                        $("#name").val('');
                        $("#description").val('');
                        $("#fileurl").val('');
                    } else {
                        for (var count = 0; count < data.errors.length; count++) {
                            toastr.error(data.errors[count], 'Error', { timeOut: 5000 });
                        }
                    }
                },

            });
        });
        /* END OF CREATE DETAIL*/

        /*START OF EDIT DETAIL*/
        $('#table-detail tbody').on('click', '#edit', function () {
            var data = tableData.row($(this).parents('tr')).data();
            console.log(data);
            $("#non_interactive_id").val(data.id);
            $("typefile").val(data.type)
            $("#name").val(data.name);
            $("#description").val(data.description);
            $("#fileurl").val(data.file_url);
        });
        /*END OF EDIT DETAIL*/

        /*START OF DELETE DETAIL*/
        $('#table-detail tbody').on('click', '#delete', function () {
            var data = tableData.row($(this).parents('tr')).data();
            swal({
                text: "Are you sure to delete data?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{ url('admin/schedule-detail/delete') }}" + "/" + data['id'],
                            method: 'get',
                            success: function (result) {
                                console.log('HALO');
                                if (result.status === 'failed') {
                                    toastr.error(result.message, 'Error', { timeOut: 5000 });
                                }
                                else {
                                    tableData.ajax.reload();
                                    toastr.success('Successfully deleted data!', 'Success Alert', { timeOut: 5000 });
                                }
                            }
                        });
                    }
                });
        });
        /*END OF DELETE DATA*/
    });
</script>
@endpush
