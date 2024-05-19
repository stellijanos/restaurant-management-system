<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
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
                    <br>
                    <span class="badge text-bg-success">'.$table->name.'</span>
                </button>
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
                <a class="btn btn-outline-secondary" data-id="'.$menu->id.'">
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
}
