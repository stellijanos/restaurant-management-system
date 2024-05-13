

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-bars"></i> Create a Category
            <hr>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form class="mt-3" action="/management/category/{{$category->id}}" method="POST">
                @csrf 
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="category-name">Category name</label>
                    <input type="text" name="name" value="{{$category->name}}" class="form-control" id="category-name" placeholder="Category...">
                </div>
                <button class="btn btn-primary" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection