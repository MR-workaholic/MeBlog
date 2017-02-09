@extends('layouts.layout')

@section('styles')
    <link href="/assets/pickadate/themes/default.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.date.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.time.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('heads')
	@include('UEditor::head');
@stop

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3><a href="{{ url('admin/post') }}">Posts </a><small>» Add New Post</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Post Form</h3>
                </div>
                <div class="panel-body">

                    @include('layouts.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.post.store') }}">
                        {{ csrf_field() }}

                        @include('admin.post._form')

                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-disk-o"></i>
                                        Save New Post
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
<script src="/assets/pickadate/picker.js"></script>
<script src="/assets/pickadate/picker.date.js"></script>
<script src="/assets/pickadate/picker.time.js"></script>
<script src="/assets/selectize/selectize.min.js"></script>
<script>
    $(function() {
        $("#publish_date").pickadate({
            format: "mmm-d-yyyy"
        });
        $("#publish_time").pickatime({
            format: "h:i A"
        });
        $("#tags").selectize({
            create: true
        });
    });
</script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
        ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.    
    });
</script>
@stop