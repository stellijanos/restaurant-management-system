

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
                    <li class="breadcrumb-item"><a href="/report">Report</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Result</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
       
        <div class="col-md-12">
            @if($sales->count() > 0) 
                <div class="alert alert-success" role="alert">
                    <p>The total amount of sale from {{$start_date}} to {{$end_date}} is {{number_format($totalSale, 2)}}.</p>
                    <p>Total Result: {{$sales->total()}}</p>
                </div>

                <table class="table">
                    <thead>
                        <tr class="bg-primary text-light">
                            <th scope="col">#</th>
                            <th scope="col">Receipt ID</th>
                            <th scope="col">Date Time</th>
                            <th scope="col">Table</th>
                            <th scope="col">Staff</th>
                            <th scope="col">Total Amound</th>
                        </tr> 
                    </thead>
                    <tbody>

                        @php 
                            $countSale = ($sales->currentPage()-1) * $sales->perPage() + 1;
                        @endphp
                        @foreach ($sales as $sale )
                            <tr cextss="bg-primary text-light">las
                                <td>{{$countSale++}}</td>
                                <td>{{$sale->id}}</td>
                                <td>{{date('d.m.Y H:i:s',strtotime($sale->updated_at))}}</td>
                                <td>{{$sale->table_name}}</na>
                                <td>{{$sale->user_name}}</ne>
                                <td>{{$sale->total_price}}</td>
                            </tr>
                            <tr>
                                <th></th>
                                <th>Menu ID</th>
                                <th>Menu</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total price</th>
                            </tr>
                            @foreach ($sale->saleDetails() as $saleDetail )
                                <tr>
                                    <td></td>
                                    <td>{{$saleDetail->menu_id}}</td>
                                    <td>{{$saleDetail->menu_name}}</td>
                                    <td>{{$saleDetail->quantity}}</td>
                                    <td>{{$saleDetail->menu_price}}</td>
                                    <td>{{$saleDetail->menu_price * $saleDetail->quantity}}</td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                </table>

                {{$sales->appends($_GET)->links()}}

            @else

                <div class="alert alert-danger" role="alert">
                    There is no sale report!
                </div>

            @endif
        </div>
    </div>

</div>

@endsection
