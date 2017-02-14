@extends('layouts.app')

@section('breadcrumb')
    <li class="active">Categories</li>
@stop

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1>
                Categories
                <a href="{{ route('categories.create') }}" class="btn btn-default pull-right">Create</a>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>User</th>
                    <th width="100px">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            @can ('update', $category)
                                <a href="{{ route('categories.edit', $category->id) }}">{{ $category->name }}</a>
                            @else
                                {{ $category->name }}
                            @endcan
                        </td>
                        <td>{{ $category->user->name }}</td>
                        <td>
                            @can ('delete', $category)
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
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

            {{ $categories->render() }}
        </div>
    </div>
@endsection