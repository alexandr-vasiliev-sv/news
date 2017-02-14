@extends('layouts.app')

@section('breadcrumb')
    <li class="active">News</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                News
                <a href="{{ route('news.create') }}" class="btn btn-default pull-right">Create</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <select id="searchByTag" class="form-control">
                <option value="">All</option>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ (int)request('tag') == $tag->id ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Text</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($newsCollection as $news)
                    <tr>
                        <td>
                            <a href="{{ route('news.show', $news->id) }}">{{ $news->title }}</a>
                        </td>
                        <td>{{ str_limit($news->text, 50) }}</td>
                        <td>{{ $news->user->name }}</td>
                        <td>{{ $news->category->name }}</td>
                        <td>
                            <ol>
                                @foreach($news->tags as $tag)
                                    <li>
                                        <a href="{{ route('news.index', ['tag' => $tag->id]) }}">
                                            #{{ $tag->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        </td>
                        <td>
                            @can('delete', $news)
                                <form action="{{ route('news.destroy', $news->id) }}" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $newsCollection->render() }}
        </div>
    </div>
@stop

@push('scripts')
<script>
    $('#searchByTag').select2();
    $('#searchByTag').change(function () {
        var id = $(this).val();
        var url = '{{ route('news.index') }}';
        if (id > 0) {
            url += '?tag=' + id;
        }
        location.replace(url);
    });
</script>
@endpush