<div class="form-group">
  <label for="src" class="col-md-3 control-label">*Src</label>
  <div class="col-md-3">
    <input type="text" class="form-control" name="src" id="src" @if($method == 'create') placeholder @else value @endif ="{{ $src }}" autofocus>
  </div>
</div>

<div class="form-group">
  <label for="alt" class="col-md-3 control-label">
    *Merchandise
  </label>
  <div class="col-md-8">
    <input type="text" class="form-control" name="alt" id="alt" @if($method == 'create') placeholder @else value @endif ="{{ $alt }}">
  </div>
</div>

<div class="form-group">
  <label for="price" class="col-md-3 control-label">
    *Price
  </label>
  <div class="col-md-8">
    <input type="text" class="form-control" name="price" id="price" @if($method == 'create') placeholder @else value @endif ="{{ $price }}">
  </div>
</div>

<div class="form-group">
  <label for="content" class="col-md-3 control-label">
    Describtion
  </label>
  <div class="col-md-8">
    <input type="text" class="form-control" name="content" id="content" @if($method == 'create') placeholder @else value @endif ="{{ $content }}">
  </div>
</div>

<div class="form-group">
  <label for="tags" class="col-md-3 control-label">
    *Tags
  </label>
  <div class="col-md-8">
    <select name="tags[]" id="tags" class="form-control" multiple>
      @foreach ($allTags as $tag)
        <option @if (in_array($tag, $tags)) selected @endif value="{{ $tag }}">
                        {{ $tag }}
        </option>
      @endforeach
    </select>
  </div>
</div>
