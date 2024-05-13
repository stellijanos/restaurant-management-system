

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-burger"></i> Create a Menu
            <hr>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form class="mt-3" action="/management/menu" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="form-group mb-3">
                    <label for="menu-name">Menu name</label>
                    <input type="text" name="name" class="form-control" id="menu-name" placeholder="Menu...">
                </div>

                <label for="price">Price</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" name="price" class="form-control" id="price" aria-label="Amount (to the nearest dollar)">
                    <div class="input-group-append">
                        <span class="input-group-text">.00</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Image</label>
                    <input class="form-control" type="file" id="file" name="image">
                </div>

                <div class="form-group mb-3">
                    <label for="description">Description</label>
                    <textarea type="text" name="description" class="form-control" id="description" placeholder="Description..." style="height:100px;"></textarea>
                </div>

                <div class="form-group mb-5">
                    <label for="category">Category</label>
                    <select name="category_id" id="category" class="form-select">
                        <option value="0" disabled selected>Select a category</option>
                        @foreach ($categories as $category )
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

@endsection
