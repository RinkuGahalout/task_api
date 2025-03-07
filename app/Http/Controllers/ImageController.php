<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

     public function store(Request $request)
     {
         $request->validate([
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
         ]);
 
         if ($request->hasFile('image')) {
             $imageName = time() . '.' . $request->image->extension();
             $imagePath = $request->file('image')->move(public_path('images'), $imageName); 
 
             $image = Image::create([
                 'image_path' => 'images/' . $imageName,  
             ]);
 
             return response()->json(['image' => $image]);
         }
 
         return response()->json(['error' => 'Image upload failed']);
     }
 
     public function index()
     {
         $images = Image::all();
 
         $images = $images->map(function ($image) {
             $image->image_url = asset($image->image_path); 
             return $image;
         });
 
         return response()->json($images);
     }  
}
