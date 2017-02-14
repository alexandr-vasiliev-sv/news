@extends('layouts.app')

@section('breadcrumb')
    <li><a href="{{ route('categories.index') }}">Categories</a></li>
    <li class="active">Update <small>{{ $category->name }}</small></li>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>
            Update category
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @include('category._form', [
            'model' => $category,
        ])
    </div>
</div>
@endsection