@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row" id="table-detail">

    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 d-grid gap-2">
            <button class="btn btn-primary" id="btn-show-tables">View All tables</button>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach ($categories as $category )
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{$category->name}}</a>
                        </li>
                    @endforeach
                </div>
            </nav>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // make table detail hidden by default
        $('#table-detail').hide();

        // show all tables when a client clicks on the button
        $('#btn-show-tables').click(function() {

            if($('#table-detail').is(':hidden')) {
                $.get("/cashier/get-tables", function(data) {
                    $("#table-detail").html(data);
                    $("#table-detail").slideDown('smooth');
                    $('#btn-show-tables')
                    .html('Hide Tables')
                    .removeClass('btn-primary')
                    .addClass('btn-danger');
                });
            } else {
                $("#table-detail").slideUp('fast');
                $('#btn-show-tables')
                    .html('View Tables')
                    .removeClass('btn-danger')
                    .addClass('btn-primary');
            }

           
        });
    });
</script>
@endsection
