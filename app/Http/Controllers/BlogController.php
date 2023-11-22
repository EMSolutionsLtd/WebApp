<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;
use App\Models\Comment;

class BlogController extends Controller
{
    public function index(){
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'DESC')->get();
        $data['blogs'] = $blogs;

        return view('blog', $data);
    }

    public function detail($id) {
        $blog = Blog::where('id', $id)->first();
        if($blog == null) {
            return redirect()->route('blog.front');
        }

        $comments = Comment::where('status', 1)->where('blog_id', $blog->id)->orderBy('created_at', 'ASC')->get();

        $data['blog'] = $blog;
        $data['comments'] = $comments;

        return view('blog-detail', $data);
    }

    public function saveComment(Request $request) {
        // print_r($request->all());

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'comment' => 'required'
        ]);

        if($validator->passes()) {
            $comment = new Comment;
            $comment->name = $request->name;
            $comment->comment = $request->comment;
            $comment->blog_id = $request->blog_id;
            $comment->status = 1;
            $comment->save();

            return response()->json([
                'status' => 1,
                'name' => $comment->name,
                'comment' => $comment->comment,
                'created_at' => date('d/m/Y h:i a', strtotime($comment->created_at)),
            ]);

        } else {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()
            ]);
        }
    }
}
