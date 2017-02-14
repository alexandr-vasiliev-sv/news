@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="active">Create</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>
                Create category
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('category._form', [
                'model' => new \App\Entities\Category(),
            ])
        </div>
    </div>
@endsection