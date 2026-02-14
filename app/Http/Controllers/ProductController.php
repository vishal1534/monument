<?php


namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $product;

    public function __construct()
    {
        $this->product= new Product();
    }

    public function getAll(){

        return response()->json($this->product->listAllProducts());
    }

    public function show(Request $request){

        return response()->json($this->product->getProduct($request->id));
    }


}