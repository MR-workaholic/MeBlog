@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>Tags <small>» Listing</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('admin/tag/create') }}" class="btn btn-success btn-md">
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
                            <th class="hidden-sm">Subtitle</th>
                            <th class="hidden-md">Level</th>
                            <th class="hidden-md">Belog To</th>
                            <th class="hidden-md">Show Order</th>
                            <th class="hidden-md">Page Image</th>
                            <th class="hidden-md">Icon</th>
                            <th class="hidden-md">Meta Description</th>
                            <th class="hidden-sm">Layout</th>
                            <th class="hidden-sm">Direction</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->tag }}</td>
                            <td>{{ $tag->title }}</td>
                            <td class="hidden-sm">{{ $tag->subtitle }}</td>
                            <td class="hidden-md">{{ $tag->level }}</td>
                            <td class="hidden-md">{{ $tag->belog_to }}</td>
                            <td class="hidden-md">{{ $tag->show_order }}</td>
                            <td class="hidden-md">{{ $tag->page_image }}</td>
                            <td class="hidden-md"><span class="{{ $tag->icon }}"></span></td>
                            <td class="hidden-md">{{ $tag->meta_description }}</td>
                            <td class="hidden-sm">{{ $tag->layout }}</td>
                            <td class="hidden-sm">
                                @if ($tag->reverse_direction)
                                    Reverse
                                @else
                                    Normal
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('admin/tag/'.$tag->id.'/edit') }}" class="btn btn-xs btn-info">
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