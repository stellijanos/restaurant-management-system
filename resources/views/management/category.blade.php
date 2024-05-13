

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-bars"></i> Category
            <a href="/management/category/create" class="btn btn-success btn-sm float-end text-white"><i class="fa-solid fa-plus"></i> Create category</a>
            <hr>
            @if(session()->has('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('status')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Category</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category )
                        <tr>
                            <th scope="row">{{$category->id}}</th>
                            <th scope="row">{{$category->name}}</th>
                            <th scope="row">
                                <a href="/management/category/{{$category->id}}/edit" class="btn btn-warning">Edit</a>
                            </th>
                            <th scope="row">
                                <form action="/management/category/{{$category->id}}" method="post">
                                    @csrf 
                                    @method("DELETE")
                                    <input type="submit" value="Delete" class="btn btn-danger">
                                </form>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="justify-content-center">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
