@extends('layouts.app')
@section('content')
<!-- Page header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-title">
            <h4><i class=""></i> <span class="text-semibold">Quiz</span></h4>
        </div>
    </div>

    <div class="breadcrumb-line breadcrumb-line-component">
        <ul class="breadcrumb">
            <li><a href="{{url('admin/dashboard')}}"><i class="icon-home2 position-left"></i> Home</a></li>
            <li><a href="">Master Data</a></li>
            <li><a href="{{route('quiz.index')}}">Quiz</a></li>
            <li class="active">Create Question</li>
        </ul>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <div class="panel panel-white">
        <div class="panel-heading">
            <h6 class="panel-title "><i class="icon-cog3 position-left"></i> QUIZ INFO</h6>
        </div>
        <div class="panel-body">
            <div class="col-md-6">
                <label class="text-bold col-md-4">Quis Type</label>
                <label class="col-md-8">: {{$quiz->quizType['name']}}</label>

                <label class="text-bold col-md-4">Title</label>
                <label class="col-md-8">: {{$quiz->title}}</label>

                <label class="text-bold col-md-4">Total Question</label>
                <label class="col-md-8">: {{$quiz->sum_question}}</label>

                <label class="text-bold col-md-4">Description</label>
                <label class="col-md-8">: {{$quiz->description}}</label>
            </div>
            <div class="col-md-6">
                @if($quiz->pic_url == 'blank.jpg')
                <img class="img-responsive" src="{{asset('img/blank.jpg')}}" alt="Quiz Type"
                    title="Change the quiz type picture" width="100" height="50">
                @else
                <img class="img-responsive" src="{{route('quiz.picture',$quiz->id)}}" alt="Quiz Type"
                    title="Change the quiz type picture" width="100" height="50">
                @endif
                <br>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <!-- State saving -->
    <div class="panel panel-flat">
        <div class="panel-body">
            <form id="form-question" class="stepy-clickable form-validate-jquery" action="{{route('question.store')}}"
                method="post" enctype="multipart/form-data" files=true>
                @csrf
                @for ($i=0; $i < $total; $i++) <fieldset>
                    <legend class="text-semibold"></legend>
                    <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label><strong>Question:<span class="text-danger">*</span></strong></label>
                                <textarea type="text" name="question[]" rows="3" class="form-control"
                                    placeholder="">{{ old('question.'.$i) }}</textarea>
                                @if ($errors->has('question.'.$i))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i> {{ $errors->first('question.'.$i)
                                        }}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3">Picture</label>
                                <input type="file" name="picture[{{$i}}]" class="file-input-custom"
                                    data-show-caption="true" data-show-upload="false" accept="image/*">
                                @if ($errors->has('picture.'.$i))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i>
                                        {{$errors->first('picture.'.$i)}}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label col-lg-3">Audio</label>
                                <input type="file" name="audio[{{$i}}]" class="file-input"
                                    data-show-caption="true" data-show-upload="false" accept=".mp3">
                                @if ($errors->has('audio.'.$i))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i>
                                        {{$errors->first('audio.'.$i)}}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" id="choice{{$i}}">
                                @for($j=0; $j<=3; $j++) <div class="" id="choice_{{$j+1}}">
                                    @switch($j+1)
                                    @case(1)
                                    <label><strong>First Multiple Choice:<span class="text-danger">*</span></strong></label>
                                    @break
                                    @case(2)
                                    <label><strong>Second Multiple Choice:<span class="text-danger">*</span></strong></label>
                                    @break
                                    @case(3)
                                    <label><strong>Third Multiple Choice:<span class="text-danger">*</span></strong></label>
                                    @break
                                    @case(4)
                                    <label><strong>Fourth Multiple Choice:<span class="text-danger">*</span></strong></label>
                                    @break
                                    @default
                                    <label><strong>Error Multiple Choice:<span class="text-danger">*</span></strong></label>
                                    @endswitch
                                    <input type="text" name="choice[{{$i}}][{{$j}}]" class="form-control"
                                        value="{{ old('choice.'.$i.''.$j) }}" placeholder="">
                                    <input type="file" name="picture_choice[{{$i}}][{{$j}}]" class="form-control">

                                    @if ($errors->has('choice.'.$i.'.'.$j))
                                    <label style="padding-top:7px;color:#F44336;">
                                        <strong><i class="fa fa-times-circle"></i>
                                            {{$errors->first('choice.'.$i.'.'.$j)}}</strong>
                                    </label>
                                    @endif
                                    @if ($errors->has('picture_choice.'.$i.''.$j))
                                    <label style="padding-top:7px;color:#F44336;">
                                        <strong><i class="fa fa-times-circle"></i>
                                            {{$errors->first('picture_choice.'.$i.'.'.$j)}}</strong>
                                    </label>
                                    @endif
                            </div>
                            <br>
                            @endfor
                            <div class="btn-group" id="btn-4">
                                <button type='button' value={{$i}} class='btn btn-default addButton'><i
                                        class='fa fa-plus'></i></button>
                            </div>
                            <div id="choice_5" class="hide">
                                @if ($choice5[$i] = $errors->has('choice.'.$i.'.4'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i>
                                        {{$errors->first('choice.'.$i.'.4')}}</strong>
                                </label>
                                @endif
                                @if ($errors->has('picture_choice.'.$i.'.4'))
                                <label style="padding-top:7px;color:#F44336;">
                                    <strong><i class="fa fa-times-circle"></i>
                                        {{$errors->first('picture_choice.'.$i.'.4')}}</strong>
                                </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" id="option{{$i}}">
                            <label class="display-block">True Answer:<span class="text-danger">*</span></label>
                            <div id="first_{{$i}}" class="">
                                <label class="radio-inline col-md-1">
                                    <input checked type="radio" name="true_answer[{{$i}}]" {{
                                        collect(old('true_answer.'.$i))->contains(1) ? 'checked' : '' }} value="1"
                                    class="styled">
                                    First
                                </label>
                            </div>
                            <div id="second_{{$i}}" class="show">
                                <label class="radio-inline col-md-1">
                                    <input type="radio" name="true_answer[{{$i}}]" {{
                                        collect(old('true_answer.'.$i))->contains(2) ? 'checked' : '' }} value="2"
                                    class="styled">
                                    Second
                                </label>
                            </div>
                            <div id="third_{{$i}}" class="show">
                                <label class="radio-inline col-md-1">
                                    <input type="radio" name="true_answer[{{$i}}]" {{
                                        collect(old('true_answer.'.$i))->contains(3) ? 'checked' : '' }} value="3"
                                    class="styled">
                                    Third
                                </label>
                            </div>
                            <div id="fourth_{{$i}}" class="show">
                                <label class="radio-inline col-md-1">
                                    <input type="radio" name="true_answer[{{$i}}]" {{
                                        collect(old('true_answer.'.$i))->contains(4) ? 'checked' : '' }} value="4"
                                    class="styled">
                                    Fourth
                                </label>
                            </div>
                            <div id="fifth_{{$i}}" class="hide">
                                <label class="radio-inline col-md-1">
                                    <input type="radio" name="true_answer[{{$i}}]" {{
                                        collect(old('true_answer.'.$i))->contains(5) ? 'checked' : '' }} value="5"
                                    class="styled">
                                    Fifth
                                </label>
                            </div>
                        </div>
                    </div>
        </div>
        </fieldset>
        @endfor
        <button type="submit" class="btn btn-primary stepy-finish">Submit <i
                class="icon-check position-right"></i></button>
        </form>
        <!-- /clickable title -->
    </div>
    <!-- /state saving -->
</div>
</div>
<!-- /content area -->
@endsection
@push('after_script')
<script>
    $(document).ready(function () {

        $(document).on('click', '.addButton', function () {

            var id = $(this).val();
            var counter = $('#choice' + id + ' div:not(.hide)').children('input[type=text]').length;

            if (counter == 4) {
                var $template = $('#choice' + id + ' #choice_5');
                var choice = temp_choice5(id);
                var $template2 = $('#fifth_' + id);
                $('#btn-4').hide();
            }

            $template.removeClass('hide');
            $template.append(choice);
            $template2.removeClass('hide');
        });

        $(document).on('click', '.removeButton', function () {

            var id = $(this).val();
            var counter = $('#choice' + id + ' div:not(.hide)').children('input[type=text]').length;

            if (counter == 5) {
                var $template = $('#choice' + id + ' #choice_5');
                $('#btn-4').show();
                var $template2 = $('#fifth_' + id);
            }
            $template2.addClass('hide');
            $template.addClass('hide');
            $template.children().remove();

        });

        function temp_choice5($i) {
            return "<label><strong>Fifth Multiple Choice:</strong></label>" +
                "<input type='text' name='choice[" + $i + "][4]' class='form-control' value='' placeholder=''>" +
                "<input type='file' name='picture_choice[" + $i + "][4]' class='form-control'>" +
                "<div class='btn-group' role='group'>" +
                "<button type='button' value='" + $i + "' class='btn btn-default removeButton'><i class='fa fa-minus'></i></button>" +
                "</div>"
        };

        @for ($i = 0; $i < $total; $i++)
            @if ($choice5[$i] == 1)
            $('#choice' + '{{$i}}' + ' #choice_5').prepend(temp_choice5('{{$i}}')).removeClass('hide');
        $('#choice' + '{{$i}}' + ' #choice_4').find('.btn-group').addClass('hide');
        $('#fifth_' + '{{$i}}').removeClass('hide');
        @elseif($temp = old('choice.'.$i.'.4'))
        $('#choice' + '{{$i}}' + ' #choice_5').prepend(temp_choice5('{{$i}}')).removeClass('hide');
        $('#choice' + '{{$i}}' + ' #choice_5').find('input[name="choice[' + "{{$i}}" + '][4]"]').val("{{$temp}}");
        $('#choice' + '{{$i}}' + ' #choice_4').find('.btn-group').addClass('hide');
        $('#fifth_' + '{{$i}}').removeClass('hide');
        @endif
        @endfor
    });
</script>
@endpush
