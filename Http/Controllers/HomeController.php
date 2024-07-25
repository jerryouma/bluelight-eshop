<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){

        $data=products::paginate(16);
        $count = 0;
        if (Auth::check()) {
        $user=Auth::user();
        $userid=$user->id;
        $count= cart::where('user_id',$userid)->count();
        }
        
        return view('home.index',compact('data','count'));
    }

    public function about(){
        return view('home.about');
    }

    public function contact(){
        return view('home.contact');
    }

    public function products_view($id){
        $data=products::find($id);
        return view('home.products.products_view',compact('data'));
    }




    public function Mega_search(Request $request){
        $search=$request->search;
        $data=products::where('name','LIKE','%'.$search.'%')-> 
        orwhere('discription','LIKE','%'.$search.'%')->paginate(8);
        return view('home.index',compact('data'));
    }





    public function dashboard(){
    return redirect()->route('home');
    }

 public function add_cart($id){
    $product_id=$id;
    $user= Auth::user();
    $user_id=$user->id;
    $data=new cart();
    $data->user_id=$user_id;
    $data->product_id=$product_id;
    $data->save();
    toastr()->addsuccess('Product added to cart successfully');
    return redirect()->back();


 }

}
