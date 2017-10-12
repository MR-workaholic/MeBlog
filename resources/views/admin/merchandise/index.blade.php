@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="row page-title-row">
            <div class="col-md-6">
                <h3>商品 <small>» Listing</small></h3>
            </div>
            <div class="col-md-6 text-right">
                <a href="{{ url('admin/merchandises/create') }}" class="btn btn-success btn-md">
                    <i class="fa fa-plus-circle"></i> New Merchandise
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
                            <th class="hidden-sm">Src</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Tags</th>
                            <th>Describtion</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                     </thead>
                    <tbody>
                    @foreach ($merchandises as $merchandise)
                        <tr>
                          <td class="hidden-sm">
                            <button type="button" class="btn btn-xs btn-success" onclick="preview_image('{{ $merchandise->webpath }}', '{{ $merchandise->content }}')">
                              <i class="fa fa-eye fa-lg"></i>
                              {{ $merchandise->src }}
                            </button>
                          </td>
                          <td>{{ $merchandise->alt }}</td>
                          <td>{{ $merchandise->price }}</td>
                          <td>
                              @foreach ($merchandise->tags as $tag)
                                <a href="{{ url("admin/merchandisetag/$tag->id/edit") }}">{{ $tag->tag }}</a>
                              @endforeach
                          </td>
                          <td>{{ $merchandise->content }}</td>
                                
                            <td>
                                <a href="{{ url('admin/merchandises/'.$merchandise->id.'/edit') }}" class="btn btn-xs btn-info">
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

    {{-- 浏览图片 --}}
    <div class="modal fade" id="modal-image-view">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              ×
            </button>
            <h4 class="modal-title">Image Preview</h4>
          </div>
          <div class="modal-body">
            <img id="preview-image" src="x" class="img-responsive">
            <div><span id="preview-content"></span></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              Cancel
            </button>
          </div>
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
   // 预览图片
   function preview_image(path, content) {
     $("#preview-image").attr("src", path);
     $("#preview-content").html(content);
     $("#modal-image-view").modal("show");
   }

  </script>
@stop
