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
            <li class="active">Edit</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-body">
            <form class="form-horizontal form-validate-jquery" action="{{route('user-package.update',$data->id)}}" method="post" enctype="multipart/form-data" files=true>
            @method('PUT')
            @csrf
                <fieldset class="content-group">
                <legend class="text-bold">Edit User</legend>
                <div class="form-group">
                    <label class="control-label col-lg-3">Name <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="name" class="form-control" value="{{ old('name') ? old('name') : $data->name }}" placeholder="">
                        @if ($errors->has('name'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('name') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-3">Username <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text" name="username" class="form-control" value="{{ old('username') ? old('username') : $data->username }}" placeholder="">
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
                        <input type="email" name="email" class="form-control" value="{{ old('email') ? old('email') : $data->email }}" placeholder="">
                        @if ($errors->has('email'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('email') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                <div class="form-group" id="div-lpk">
                    <label class="control-label col-lg-3">LPK <span class="text-danger" id="span-lpk"></span></label>
                    <div class="col-lg-9">
                        <input type="hidden" name="lpk_id" id="lpk_id" value="{{Auth::user()->lpk}}">
                        <select name="lpk" id="lpk" class="select-search" data-placeholder="Choose LPK">
                            <option value=""></option>
                            @foreach(\App\Lpk::all()->sortBy('name') as $value)
                            <option value="{{$value->id}}" {{ (collect(old('lpk'))->contains($value->id)) ? 'selected':'' }} @if($data->lpk == $value->id) selected='selected' @endif>{{$value->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('lpk'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('lpk') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                
                <legend class="text-bold">Change Password</legend>
                <div class="form-group">
                    <label class="control-label col-lg-3">Password <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="password" name="password" class="form-control" value="" placeholder="">
                        @if ($errors->has('password'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('password') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>

                <legend class="text-bold">Paket</legend>
                <div class="form-group">
                    <label class="control-label col-lg-3">Paket yang sudah dimiliki:</label>
                    <div class="col-lg-9">
                        @foreach ($data->collager->transaction as $key => $value)
                            @foreach ($value->transactionDetail as $key2 => $value2) 
                                <span class="label border-left-violet label-striped" style="margin:2px 0px 2px 0px">
                                {{$value2->package->quizType->quizCategory->name}} - {{$value2->package->quizType->name}}
                                </span>
                            @endforeach
                        @endforeach
                    </div>
                </div>
                <div class="form-group" id="div-paket">
                    <label class="control-label col-lg-3">Paket <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <div class="multi-select-full">
                            <select class="multiselect-full-featured" multiple="multiple" name="paket[]">
                                @foreach($package as $value)
                                <option value="{{$value->package->first()->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->has('paket'))
                        <label style="padding-top:7px;color:#F44336;">
                        <strong><i class="fa fa-times-circle"></i>{{ $errors->first('paket') }}</strong>
                        </label>
                        @endif
                    </div>
                </div>
                </fieldset>
            <div>

            <div class="col-md-4">
                <a href="{{route('user-package.index')}}"type="reset" class="btn btn-default" id=""> <i class="icon-arrow-left13"></i> Back</a>
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
    lpk_id = $('#lpk_id').val();
    if (lpk_id) {
        $('#div-lpk').hide();
    }
});
</script>
@endpush
