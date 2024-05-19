@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row" id="table-detail">

    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="d-grid">
                <button class="btn btn-primary" id="btn-show-tables">View All tables</button>
                <div id="selected-table">

                </div>
            </div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach ($categories as $category )
                        <li class="nav-item">
                            <a class="nav-link" data-id="{{$category->id}}" href="#">{{$category->name}}</a>
                        </li>
                    @endforeach
                </div>
            </nav>

            <div id="list-menu" class="row mt-2">

            </div>
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
                $("#table-detail").slideUp('smooth');
                $('#btn-show-tables')
                    .html('View Tables')
                    .removeClass('btn-danger')
                    .addClass('btn-primary');
            }
        });


        // load menus by category

        $(".nav-link").click(function() {
            $.get("/cashier/get-menu-by-category/"+$(this).data("id"), function(data) {
                $("#list-menu").hide();
                $("#list-menu").html(data);
                $("#list-menu").fadeIn('fast');
            });
        });

        // detect button on click to show table data
        $('#table-detail').on("click", ".btn-table", function() {
            let selectedTableId = $(this).data("id");
            let selectedTableName = $(this).data("name");

            $("#selected-table").html('<br><h3>Table: ' + selectedTableName + ' </h3><hr>')

            console.log(selectedTableId, selectedTableName);
        });

    });
</script>
@endsection
