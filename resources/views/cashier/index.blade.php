@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row" id="table-detail">

    </div>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="d-grid">
                <button class="btn btn-primary" id="btn-show-tables">View All tables</button>
                <div id="selected-table"></div>
                <div id="order-detail"></div>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Payment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h3 id="total-amount"></h3>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input type="number" name="recieved-amount" class="form-control" id="recieved-amount">
        </div>
        <h3 class="change-amount"></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn-save-payment" disabled>Save Payment</button>
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

        let SELECTED_TABLE_ID = "";
        let SELECTED_TABLE_NAME = "";

        // detect button on click to show table data
        $('#table-detail').on("click", ".btn-table", function() {
            SELECTED_TABLE_ID = $(this).data("id");
            SELECTED_TABLE_NAME = $(this).data("name");

            $("#selected-table").html('<br><h3>Table: ' + SELECTED_TABLE_NAME + ' </h3><hr>')
            $.get("/cashier/get-sale-details-by-table/" + SELECTED_TABLE_ID, function(data) {
                $("#order-detail").html(data);
            });
        });

        $("#list-menu").on("click", ".btn-menu", function() {
            if (SELECTED_TABLE_ID == "") {
                alert('You need to select a table for the customer first!');
            } else {
                let menu_id = $(this).data("id");
                
                $.ajax({
                    type:"POST",
                    url: "/cashier/order-food",
                    data : {
                        "_token" : $('meta[name="csrf-token"]').attr('content'),
                        "menu_id": menu_id,
                        "table_id":SELECTED_TABLE_ID,
                        "table_name":SELECTED_TABLE_NAME,
                        "quantity": 1
                    },
                    
                    success: function(data) {
                        $("#order-detail").html(data);
                    },
                    error: function(data) {
                        alert(data);
                   }
                });
            }
        });


        $("#order-detail").on('click', '.btn-confirm-order', function() {
            let SALE_ID = $(this).data('id');

            $.ajax({
                type:'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "sale_id": SALE_ID
                },
                url: "/cashier/confirm-order-status",
                success: function(data) {
                    $('#order-detail').html(data);
                },
                error: function(data) {

                }
            });
        });


        // delete sale-detail

        $('#order-detail').on('click', '.btn-delete-sale-detail', function() {
            let SALE_DETAIL_ID = $(this).data("id");

            $.ajax({
                type: 'POST',
                data: {
                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                    "sale_detail_id": SALE_DETAIL_ID
                },
                url: '/cashier/delete-sale-detail',
                success: function(data) {
                    $('#order-detail').html(data);
                },
                error: function(data) {

                }
            });
        });

        

        // when a user clicks on the payment button 
        $('#order-detail').on('click', '.btn-payment', function() {
            let totalAmount = $(this).data('total-amount');
            $("#total-amount").html("Total amount: $" + Number(totalAmount).toFixed(2));
            $('#recieved-amount').val('');
            $(".change-amount").html('');
        });


        // calculate change
        $("#recieved-amount").keyup(function() {
            let totalAmount = $(".btn-payment").attr('data-total-amount');
            let recievedAmount = $(this).val();
            let changeAmnount = recievedAmount - totalAmount;
            $(".change-amount").html("Total change: $" + Number(changeAmnount).toFixed(2));

            // check if cashier entered the right amount, then enable or disable the save payment button
            $("#btn-save-payment").prop('disabled', changeAmnount < 0);
            
        });

    });
</script>
@endsection
