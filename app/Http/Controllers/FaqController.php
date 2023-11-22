<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\Blog;

class FaqController extends Controller
{
    public function index(){
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'DESC')->paginate(6);

        $faq = Faq::orderBy('created_at', 'DESC')->where('status', 1)->get();

        return view('faq', ['faq' => $faq, 'blogs' => $blogs]);
    }
}
