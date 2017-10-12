<div class="form-group">
  <label for="tag" class="col-md-3 control-label">*Tag</label>
  <div class="col-md-3">
    <input type="text" class="form-control" name="tag" id="tag" @if($method == 'create') placeholder="{{ $tag }}" @else value="{{ $tag }}"  @endif autofocus>
  </div>
</div>

<div class="form-group">
    <label for="title" class="col-md-3 control-label">
        *Title
    </label>
    <div class="col-md-8">
        <input type="text" class="form-control" name="title" id="title" @if($method == 'create') placeholder="{{ $title }}" @else value="{{ $title }}" @endif>
    </div>
</div>
