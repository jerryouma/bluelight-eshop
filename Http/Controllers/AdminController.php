<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\products;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function cpanel(){
        return view('cpanel.index');
    }


    public function category(){
        $data= category:: all();
        return view('cpanel.category.index',compact('data'));
    }
    public function add_category(Request $request) {
        $data= new category();
        $data->Name=$request->Name;
        $data->save();
        toastr()->success('Category added succesfully');
        return redirect()->back();
    }

    public function delete_category($id)
    {

    $data = category::find($id);
    $data->delete();
    toastr()->addsuccess('category delated succeefuly');

    return redirect()->back();

    }

    public function view_products(){
        $data= category::all();
        $products=products::paginate(8);
        return view('cpanel.products.index',compact('data','products'));
    }


    public function add_products(Request $request){
        $data= new products();
        $data->name=$request->name;
        $data->discription=$request->description;
        $data->price=$request->price;
        $data->category=$request->category;
        $image=$request->file('image');

        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
            $data->image=$imagename;
        }
        $data->save();
        toastr()->addsuccess('Product added succeefuly');

        return redirect()->back();
    }

    public function delete_product($id){
        $data= products::find($id);
        $image_path= public_path('products/'.$data->image);
        if(file_exists($image_path)){
            unlink($image_path);
        }
        $data->delete();
        toastr()->addsuccess('Product deleted succeefuly');

        return redirect()->back();

    }


    public function edit_product($id){
        $item= products::find($id);
        $data= category::all();
        return view('cpanel.products.editProducts',compact('item','data'));
    }





    public function product_update(Request $request, $id){
        $data=products::find($id);
        $data->name=$request->name;
        $data->discription=$request->description;
        $data->price=$request->price;
        $data->category=$request->category;

        $image=$request->image;
        if($image){
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('products',$imagename);
            $data->image=$imagename;
        }
       
        $data->save();
    toastr()->addsuccess('Product updated successfully');
    return redirect()->route('view_products');
    }







    public function product_search(Request $request){
        $data= category::all();
        $search=$request->search;
        $products=products::where('name','LIKE','%'.$search.'%')->
        orwhere('category','LIKE','%'.$search.'%')->paginate(5);
        return view('cpanel.products.index',compact('products','data'));
    }
}
