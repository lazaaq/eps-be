@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">User</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li><a href="">User</a></li>
            <li class="active">Create</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" action="{{route('user.store')}}" method="post" enctype="multipart/form-data" files=true>
            {{ csrf_field() }}
                <fieldset class="content-group">
                <legend class="text-bold">Create User</legend>
                <div class="form-group">
                    <label class="control-label col-lg-3">Name <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="">
                        @if ($errors->has('name'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i> {{ $errors->first('name') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Username <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="">
                        @if ($errors->has('username'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('username') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Email <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="">
                        @if ($errors->has('email'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('email') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Password <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="password" name="password" class="form-control" value="{{ old('password') }}" placeholder="">
                        @if ($errors->has('password'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('password') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Password Confirmation <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="">
                        @if ($errors->has('password_confirmation'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('password_confirmation') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Role <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select name="role" id="role" class="select-search" data-placeholder="Choose Role">
                        <option value=""></option>
                            @foreach($role as $data)
                            <option value="{{$data->id}}" {{ (collect(old('role'))->contains($data->id)) ? 'selected':'' }}>{{$data->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('role') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group" id="div-lpk">
                    <label class="control-label col-lg-3">LPK <span class="text-danger" id="span-lpk"></span></label>
                    <div class="col-lg-9">
                        <select name="lpk" id="lpk" class="select-search" data-placeholder="Choose LPK">
                            <option value="">Umum</option>
                            @foreach(\App\Lpk::all()->sortBy('name') as $value)
                            <option value="{{$value->id}}" {{ (collect(old('lpk'))->contains($value->id)) ? 'selected':'' }}>{{$value->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('lpk'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('lpk') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Picture</label>
                    <div class="col-lg-9">
                        <input type="file" name="picture" class="file-input-custom" data-show-caption="true" data-show-upload="false" accept="image/*">
                        {{-- <input type="file" name="picture" class="form-control"> --}}
                        @if ($errors->has('picture'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('picture') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                </fieldset>
            <div>

            <div class="col-md-4">
                <a href="{{route('user.index')}}"type="reset" class="btn btn-default" id=""> <i class="icon-arrow-left13"></i> Back</a>
            </div>
                <div class="col-md-8 text-right">
                    <button type="reset" class="btn btn-default" id="reset">Reset <i class="icon-reload-alt position-right"></i></button>
                    <button type="submit" class="btn btn-primary bg-primary-800">Submit <i class="icon-arrow-right14 position-right"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
@push('after_script')
<script>
    $(document).ready(function(){
        $('#div-lpk').hide();
        $('#role').change(function(){
            var role = $(this).find(":selected").text();
            if (role == 'Admin LPK' || role == 'user') {
                $('#div-lpk').slideDown();
                if (role == 'Admin LPK') {
                    $('#span-lpk').text('*');
                } else {
                    $('#span-lpk').text('');
                }
            } else {
                $('#div-lpk').slideUp();
            }
        });
    });
</script>
@endpush
