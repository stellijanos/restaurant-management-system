<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('management.menu',[
            'menus' => Menu::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('management.create-menu',[
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:menus|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);

       
        $imageName = "noimage.png";

        if ($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:5000'
            ]);
            $imageName = date('Ymdhis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('menu-images'), $imageName);
        }

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;

        $menu->save();
        
        $request->session()->flash('status', $request->name. ' is saved successfully!');
        return redirect('/management/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
     
        return view('management.edit-menu', [
            'menu' => Menu::find($id),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // information validation

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric'
        ]);

        $menu = Menu::find($id);

        // validate if a user uploads image

        if ($request->image) {
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpg,jpeg,png|max:5000'
            ]);

            if ($menu->image != "noimage.png") {
                $imageName = $menu->image;
                unlink(public_path('menu-images').'/'.$imageName);
            }

            $imageName = date('Ymdhis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('menu-images'), $imageName);
        } else {
            $imageName = $menu->image;
        }

        $menu->name = $request->name;
        $menu->price = $request->price;
        $menu->image = $imageName;
        $menu->description = $request->description;
        $menu->category_id = $request->category_id;
        $menu->save();
        
        $request->session()->flash('status', $request->name.' is updated successfully!');
        return redirect('/management/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);

        if ($menu->image != "noimage.png") {
            unlink(public_path('menu-images').'/'.$menu->image);
        }
        $menuName = $menu->name;
        $menu->delete();
        Session()->flash('status', $menuName.' is deleted successfully!');

        return redirect('/management/menu');
    }
}
