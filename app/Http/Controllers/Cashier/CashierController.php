<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * First page of Cashier
     * 
     * @return \Illuminate\Contracts\View\View
     */
    public function index() {

        return view('cashier.index');
    }

    public function getTables() {
        $tables = Table::all();
        $html = '';

        foreach($tables as $table) {
            $html .= 
            '<div class="col-md-2 mb-4">
                <button class="btn btn-primary">
                    <img class="img-fluid" src="'.url('/images/table.png').'" width="120px">
                    <br>
                    <span class="badge text-bg-success">'.$table->name.'</span>
                </button>
            </div>';
        }

        return $html;
    }
}
