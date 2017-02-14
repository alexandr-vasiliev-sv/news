<form class="form-horizontal" action="{{ $model->exists ? route('news.update', $model->id) : route('news.store') }}"
      method="POST">
    @if ($model->exists)
        <input type="hidden" name="_method" value="PUT">
    @endif

    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="title"
                   value="{{ old('title') ?? $model->title }}">
            @if ($errors->has('title'))
                <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <label for="text" class="col-sm-2 control-label">Text</label>
        <div class="col-sm-10">
            <textarea name="text" id="text" cols="30" rows="10" placeholder="Text"
                      class="form-control">{{ old('text') ?? $model->text }}</textarea>
            @if ($errors->has('text'))
                <span class="help-block">
                    <strong>{{ $errors->first('text') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
        <label for="category_id" class="col-sm-2 control-label">Category</label>
        <div class="col-sm-10">
            <select name="category_id" id="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ ($model->category_id !== $category->id) ?: 'selected' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @if ($errors->has('category_id'))
                <span class="help-block">
                <strong>{{ $errors->first('category_id') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="tags" class="col-sm-2 control-label">Tags</label>
        <div class="col-sm-10">
            <select name="tags[]" id="tags" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ isset($newsTags[$tag->id]) ? 'selected': '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="new_tags" class="col-sm-2 control-label">New Tags</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="new_tags" name="new_tags" placeholder="sport;football;ball;"
                   value="{{ old('new_tags')}}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">{{ ($model->exists) ? 'Update' : 'Create' }}</button>
        </div>
    </div>

</form>

@push('scripts')
    <script>
        $('#tags').select2();
    </script>
@endpush