@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>商品标签 <small>» Listing</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('admin/merchandisetag/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> New Tag
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">

                @include('layouts.partials.errors')
                @include('layouts.partials.success')

                <table id="tags-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Title</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($merchandisetags as $merchandisetag)
                        <tr>
                            <td>{{ $merchandisetag->tag }}</td>
                            <td>{{ $merchandisetag->title }}</td>
                            <td>
                                <a href="{{ url('admin/merchandisetag/'.$merchandisetag->id.'/edit') }}" class="btn btn-xs btn-info">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
    //	可以尝试去除下面的匿名函数看看网站会变成如何
        $(function() {
            $("#tags-table").DataTable({
            });
        });
    </script>
@stop
