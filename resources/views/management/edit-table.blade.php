

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-chair"></i> Edit a Table
            <hr>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form class="mt-3" action="/management/table/{{$table->id}}" method="POST">
                @csrf 
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="table-name">Table name</label>
                    <input type="text" name="name" class="form-control" value="{{$table->name}}" id="table-name" placeholder="Table...">
                </div>
                <button class="btn btn-warning" type="submit">Edit</button>
            </form>
        </div>
    </div>
</div>

@endsection