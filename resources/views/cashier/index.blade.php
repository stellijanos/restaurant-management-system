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

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#btn-show-tables').click(function() {
            $.get("/cashier/get-tables", function(data) {
                console.log(data);
                $("#table-detail").html(data);
            })
        });
    });
</script>
@endsection
