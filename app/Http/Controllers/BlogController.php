<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        return Blog::all();
    }

    public function store(Request $request)
    {
        $rule = array(
            'title' => 'required|string',
            'content' => 'required|string',
         );

         $validation = Validator::make($request->all(), $rule);
         if ($validation->fails()) {
            return $validation->errors();
        } else {
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->content = $request->content;
            if ($blog->save()) {
                return ["result" => "blog added successfully"];
            } else {
                return ["result" => "operation failed"];
            }
        }
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        return response()->json($blog, 200);
    }

    public function update(Request $request, $id)
    {
        $rule = array(
            'title' => 'required|string',
            'content' => 'required|string',
         );
         $validation = Validator::make($request->all(), $rule);
         if ($validation->fails()) {
            return $validation->errors();
        } else {
            $blog = Blog::findOrFail($id);
            $blog->title = $request->title;
            $blog->content = $request->content;
            if ($blog->save()) {
                return ["result" => "blog added successfully"];
            } else {
                return ["result" => "operation failed"];
            }
        }
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }
        
        $blog->delete();
        return response()->json(['message' => 'Blog deleted'], 200);
    }
}
