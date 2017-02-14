@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('news.index') }}">News</a></li>
    <li class="active">{{ $news->title }}</li>
@stop

@section('content')
    Tags
    @foreach($news->tags as $tag)
        <a href="{{ route('news.index', ['tag' => $tag->id]) }}">
            #{{ $tag->name }}
        </a>
    @endforeach
    <div class="row">
        <div class="col-md-12">
            <h1>
                {{ $news->title }}
                @can ('update', $news)
                    <small><a href="{{ route('news.edit', $news->id) }}">Edit</a></small>
                @endcan
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p>{{ $news->text }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('news.blocks._comments')
        </div>
    </div>
@stop