

@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/home">Main Functions</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Report</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <form action="/report/show" method="get">
            <div class="col-md-12" style="width:220px">
                <label for="">Choose date for report</label>
                <div class="form-group mb-3">
                    <div class="input-group date" id="start-date" data-target-input="nearest">
                        <input type="text" name="start_date" class="form-control datetimepicker-input" data-target="#start-date"/>
                        
                        <div data-target="#start-date" data-toggle="datetimepicker" class="input-group-text" style="cursor:pointer"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="input-group date" id="end-date" data-target-input="nearest">
                        <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#end-date"/>
                        <div data-target="#end-date" data-toggle="datetimepicker" class="input-group-text" style="cursor:pointer"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Show report</button>
            </div>
        </form>
    </div>

</div>

@endsection
