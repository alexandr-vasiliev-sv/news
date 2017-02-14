<form action="{{ ($model->exists) ? route('categories.update', $model->id) : route('categories.store')}}"
      class="form-horizontal" method="POST">
    @if ($model->exists)
        <input type="hidden" name="_method" value="PUT">
    @endif
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                   value="{{ old('name') ?? $model->name }}">
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">{{ ($model->exists) ? 'Update' : 'Create' }}</button>
        </div>
    </div>

</form>