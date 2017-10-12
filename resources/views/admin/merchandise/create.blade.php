@extends('layouts.layout')

@section('styles')
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">
    <div class="row page-title-row">
        <div class="col-md-12">
            <h3> <a href="{{ url('admin/merchandises') }}">商品 </a><small>» Create New Merchandise</small></h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Merchandise Form</h3>
                </div>
                <div class="panel-body">

                    @include('layouts.partials.errors')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/merchandises') }}">
                        	{{ csrf_field() }}


                            @include('admin.merchandise._form')

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        Add New Merchandise
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
 /* $(function() {
  *     $("#belog_to").selectize({
  *         create: false,
  *         allowEmptyOption: true,
  *     });
  * });*/
 $(function() {
   $("#tags").selectize({
     create: false
   });
 });
</script>
@stop
