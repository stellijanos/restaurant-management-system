

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-users-gear"></i> Edit a User
            <hr>
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form class="mt-3" action="/management/user/{{$user->id}}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="{{$user->name}}" class="form-control" id="name" placeholder="Name...">
                </div>

                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{$user->email}}"class="form-control" id="email" placeholder="Email...">
                </div>

                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password...">
                </div>

                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-select">
                        <option value="admin" {{$user->role === "admin" ? 'selected' : ''}}>Admin</option>
                        <option value="cashier" {{$user->role === "cashier" ? 'selected' : ''}}>Cashier</option>
                    </select>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</div>

@endsection
