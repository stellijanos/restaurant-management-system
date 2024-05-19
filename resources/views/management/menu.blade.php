

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-burger"></i> Menu
            <a href="/management/menu/create" class="btn btn-success btn-sm float-end text-white"><i class="fa-solid fa-plus"></i> Create menu</a>
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
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Description</th>
                        <th scope="col">Category</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu )
                        <tr>
                            <td>{{$menu->id}}</td>
                            <td>{{$menu->name}}</td>
                            <td>{{$menu->price}}</td>
                            <td><img src="{{asset('menu-images/'.$menu->image)}}" alt="{{$menu->name}}" width="120px" height="120px" class="img-thumbnail"></td>
                            <td>{{$menu->description}}</td>
                            <td>{{$menu->category->name}}</td>
                            
                            <td><a href="/management/menu/{{$menu->id}}/edit" class="btn btn-warning">Edit</a></td>
                            <td><a href="" class="btn btn-danger">Delete</a></td>    
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="justify-content-center">
                
            </div>
        </div>
    </div>
</div>

@endsection
