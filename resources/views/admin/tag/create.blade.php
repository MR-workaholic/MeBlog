@extends('layouts.layout')

@section('styles')
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3> <a href="{{ url('admin/tag') }}">Tags </a><small>» Create New Tag</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Tag Form</h3>
                </div>
                <div class="panel-body">

                    @include('layouts.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/tag') }}">
                        	{{ csrf_field() }}

                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">*Tag</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="tag" id="tag" value="{{ $tag }}" autofocus>
                                </div>
                            </div>

                            @include('admin.tag._form')

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        Add New Tag
                                    </button>
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
<script src="/assets/selectize/selectize.min.js"></script>
<script>
$(function() {
    $("#belog_to").selectize({
        create: false,
        allowEmptyOption: true,
    });
});
</script>
@stop