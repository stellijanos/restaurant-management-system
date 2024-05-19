

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        @include('management.inc.sidebar')
        <div class="col-md-8 mt-3">
            <i class="fa-solid fa-chair"></i> Table
            <a href="/management/table/create" class="btn btn-success btn-sm float-end text-white"><i class="fa-solid fa-plus"></i> Create a table</a>
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
                        <th scope="col">Table</th>
                        <th scope="col">Status</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tables as $table )
                        <tr>
                            <td>{{$table->id}}</td>
                            <td>{{$table->name}}</td>
                            <td>{{$table->status}}</td>
                            <td>
                                <a href="/management/table/{{$table->id}}/edit" class="btn btn-warning">Edit</a>
                            </td>
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
