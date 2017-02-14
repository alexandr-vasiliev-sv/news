{{ $comments->render() }}

<ul>
    @foreach($comments as $comment)
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>{{ $comment->user->name }}</b>
            </div>
            <div class="panel-body">
                {{ $comment->text }}
            </div>
            <div class="panel-footer">{{ $comment->created_at }}</div>
        </div>
    @endforeach
</ul>

{{ $comments->render() }}

<form action="{{ route('news.addComment', $news->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
        <textarea name="text" id="" rows="5" class="form-control"
                  placeholder="Add comment here">{{ old('text') }}</textarea>
        @if ($errors->has('text'))
            <span class="help-block">
                <strong>{{ $errors->first('text') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <button class="btn btn-primary pull-right">Add</button>
    </div>
</form>