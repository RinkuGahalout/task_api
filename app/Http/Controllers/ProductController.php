<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $rule = array(
           'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        );
        
        $validation = Validator::make($request->all(), $rule);
        if ($validation->fails()) {
            return $validation->errors();
        } else {
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->description = $request->description;
            if ($product->save()) {
                return ["result" => "product added successfully"];
            } else {
                return ["result" => "operation failed"];
            }
        }
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        if ($product->save()) {
            return ["result" => "product updated successfully"];
        } else {
            return ["result" => "operation failed"];
        }
    }

    public function destroy($id)
    {
        $product = Product::destroy($id);
        if ($product) {
            return ["result" => "deleted successfully"];
        } else {
            return ["result" => "operation failed"];
        }
    }


    public function search($name)
    {
        $product = Product::where('name', 'like', "%$name%")->get();
        if ($product) {
            return ["result" => $product];
        } else {
            return ["result" => "product not found"];
        }
    }
}
