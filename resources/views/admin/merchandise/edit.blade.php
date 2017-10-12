@extends('layouts.layout')

@section('styles')
  <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
  <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
  <div class="container-fluid">
    <div class="row page-title-row">
      <div class="col-md-12">
        <h3><a href="{{ url('admin/merchandises') }}">商品 </a><small>» Edit Merchandise</small></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Tag Edit Form</h3>
          </div>
          <div class="panel-body">

            @include('layouts.partials.errors')
            @include('layouts.partials.success')

            <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/merchandises/'.$id) }}">
              {{ csrf_field() }}
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="id" value="{{ $id }}">

              @include('admin.merchandise._form')

              <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                  <button type="submit" class="btn btn-primary btn-md">
                    <i class="fa fa-save"></i>
                    Save Changes
                  </button>
                  <button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#modal-delete">
                    <i class="fa fa-times-circle"></i>
                    Delete
                  </button>

                </div>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- 确认删除 --}}
  <div class="modal fade" id="modal-delete" tabIndex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            ×
          </button>
          <h4 class="modal-title">Please Confirm</h4>
        </div>
        <div class="modal-body">
          <p class="lead">
            <i class="fa fa-question-circle fa-lg"></i>
            Are you sure you want to delete this tag?
          </p>
        </div>
        <div class="modal-footer">
          <form method="POST" action="{{ url('admin/merchandises/'.$id) }}">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">
              <i class="fa fa-times-circle"></i> Yes
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

@stop

@section('scripts')
  <script src="/assets/selectize/selectize.min.js"></script>
  <script>
   /* $(function() {
    *   $("#belog_to").selectize({
    *     create: false,
    *     allowEmptyOption: true,
    *   });
    * });*/
   $(function() {
     $("#tags").selectize({
       create: false
     });
   });
  </script>
@stop
