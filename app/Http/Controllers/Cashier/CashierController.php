<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    /**
     * First page of Cashier
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

       
        return view('cashier.index',[
            'categories' => Category::all()
        ]);
    }

    public function getTables() {
        $tables = Table::all();
        $html = '';

        foreach($tables as $table) {
            $html .= 
            '<div class="col-md-2 mb-4">
                <button class="btn btn-primary btn-table" data-id="'.$table->id.'" data-name="'.$table->name.'">
                    <img class="img-fluid" src="'.url('/images/table.png').'" width="120px">
                    <br>';
                    if ($table->status === "available") {
                        $html .= '<span class="badge text-bg-success">'.$table->name.'</span>';
                    } else { // a table is not available (unavailable)
                        $html .= '<span class="badge text-bg-danger">'.$table->name.'</span>';
                    }
            $html .= '</button>
            </div>';
        }

        return $html;
    }

    public function getMenuByCategory($category_id) {
        $menus = Menu::where('category_id', $category_id)->get();

        if (count($menus) === 0) {
            return '<p class="text-center fs-3">No items were found.</p>';
        }
        $html = '';

        foreach($menus as $menu) {
            $html .= 
            '<div class="col-md-3 text-center mb-3">
                <a class="btn btn-outline-secondary btn-menu" data-id="'.$menu->id.'">
                    <img class="img img-fluid" src="'.url('/menu-images/'.$menu->image).'" style="width:120px; height:120px !important">
                    <br> 
                    '.$menu->name.'
                    <br>
                    $'.number_format($menu->price,2).'
                </a>
            </div>';
        }

        return $html;

    }


    public function orderFood(Request $request) {
        $menu = Menu::find($request->menu_id);
        $table_id = $request->table_id;
        $table_name = $request->table_name;

        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();

        // if there is no sale for the selected table, create a new sale record
        if (!$sale) {

            $user = Auth::user();

            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_id = $user->id;
            $sale->user_name = $user->name;
            $sale->save();

            $sale_id = $sale->id;
            // update table status 
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        } else { // if there is a sale on the selected table
            $sale_id = $sale->id;
        } 

        // add ordered menu to the sale_details table 
        $saleDetail = new SaleDetail();
        $saleDetail->sale_id = $sale_id;
        $saleDetail->menu_id = $menu->id;
        $saleDetail->menu_name = $menu->name;
        $saleDetail->menu_price = $menu->price;
        $saleDetail->quantity = $request->quantity;
        $saleDetail->save();

        // update total price in the sales table 
        $sale->total_price = $sale->total_price + ($request->quantity * $menu->price);
        $sale->save(); 


        $html = $this->getSaleDetails($sale_id);

        return $html;
    }

    private function getSaleDetails($sale_id) {
        // list all saledetails

        $html = '<p>Sale ID: '.$sale_id.'</p>';
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->get();
        $html .= '
        <div class="table-responsive" style="overflow-y:scroll; height: 400px; border:1px solid #343A40">
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <td scope="col">ID</td>
                        <td scope="col">Menu</td>
                        <td scope="col">Quantity</td>
                        <td scope="col">Price</td>
                        <td scope="col">Total</td>
                        <td scope="col">Status</td>
                    <tr>
                </thead>
                <tbody>';

            $showBtnPayment = true;

            foreach($saleDetails as $saleDetail) {
                
                $html .= '
                <tr>
                    <td>'.$saleDetail->menu_id.'</td>
                    <td>'.$saleDetail->menu_name.'</td>
                    <td>'.$saleDetail->quantity.'</td>
                    <td>'.$saleDetail->menu_price.'</td>
                    <td>'.($saleDetail->menu_price * $saleDetail->quantity).'</td>
                    <td>';

                    if ($saleDetail->status == "no-confirm") {
                        $showBtnPayment = false;

                        $html .= '
                        <a data-id="'.$saleDetail->id.'" class="btn btn-danger btn-delete-sale-detail">
                            <i class="far fa-trash-alt"></i>
                        </a>';
                    } else { // status == "confirm"
                        $html .= '<i class="fas fa-check-circle"></i>';
                    }
                $html .='</td></tr>';
            }


        $html .='</tbody>
            </table>
        </div>';

        $sale = Sale::find($sale_id);

        $html .= '<hr><h3>Total Amount: $'.number_format($sale->total_price, 2).'</h3>';

        if ($showBtnPayment) {
            $html .= 
            '<div class="d-grid">
                <button data-id="'.$sale_id.'" data-total-amount="'.$sale->total_price.'" class="btn btn-success btn-payment" data-bs-toggle="modal" data-bs-target="#exampleModal">Payment</button>
            </div>';
        } else {
            $html .= 
            '<div class="d-grid">
                <button data-id="'.$sale_id.'" class="btn btn-warning btn-confirm-order">Confirm Order</button>
            </div>';
        }

       

        return $html;
    }


    public function getSaleDetailsByTable($table_id) {
        $sale = Sale::where('table_id', $table_id)->where('sale_status', 'unpaid')->first();
    
        $html = '';

        if ($sale) {
            $sale_id = $sale->id;
            $html .= $this->getSaleDetails($sale_id);
        } else {
            $html .= "No sale details were found for the selected table";
        }

        return $html;
    }


    public function confirmOrderStatus(Request $request) {
        $sale_id = $request->sale_id;
        $saleDetails = SaleDetail::where('sale_id', $sale_id)->update(['status' => 'confirm']);

        $html = $this->getSaleDetails($sale_id);
        return $html;
    }


    public function deleteSaleDetail(Request $request) {
        $saleDetailId = $request->sale_detail_id;
        $saleDetail = SaleDetail::find($saleDetailId);
        $sale_id = $saleDetail->sale_id;

        $menu_price = $saleDetail->menu_price * $saleDetail->quantity;
        $saleDetail->delete();

        // update total price
        $sale = Sale::find($sale_id);
        $sale->total_price = $sale->total_price - $menu_price;
        $sale->save();

        // check if there is any sale detail having the sale id
        $saleDetail = SaleDetail::where('sale_id', $sale_id)->first();
        if ($saleDetail) {
            $html = $this->getSaleDetails($sale_id);
        } else {
            $html = "No sale details were found for the selected table";
        }

        return $html;

    }


    public function savePayment(Request $request) {
        $saleId = $request->sale_id;
        $recievedAmount = $request->recieved_amount;
        $paymentType = $request->payment_type;

        // update sale information in the sales table by using sale model

        $sale = Sale::find($saleId);

        $sale->total_recieved = $recievedAmount;
        $sale->change = $recievedAmount - $sale->total_price;
        $sale->payment_type = $paymentType;
        $sale->sale_status = "paid";
        $sale->save();

        // update table to be available
        $table = Table::find($sale->table_id);
        $table->status = "available";
        $table->save();

        return "/cashier";

    }
}
