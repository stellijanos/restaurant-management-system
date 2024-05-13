

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="list-group">
                <a href="/management/category" class="list-group-item list-group-item-action"><i class="fa-solid fa-bars"></i> Category</a>
                <a href="" class="list-group-item list-group-item-action"><i class="fa-solid fa-burger"></i> Menu</a>
                <a href="" class="list-group-item list-group-item-action"><i class="fa-solid fa-chair"></i> Chair</a>
                <a href="" class="list-group-item list-group-item-action"><i class="fa-solid fa-users-gear"></i> User</a>
            </div>
        </div>
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
        </div>
    </div>
</div>

@endsection
