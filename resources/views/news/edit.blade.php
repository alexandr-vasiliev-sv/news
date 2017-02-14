@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('news.index') }}">News</a></li>
    <li class="active">Edit</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                News
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('news._form', [
                'model' => $news,
            ])
        </div>
    </div>
@stop