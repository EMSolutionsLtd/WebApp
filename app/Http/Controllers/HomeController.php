<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Page;

class HomeController extends Controller
{
    public function index(){
        $services = Service::where('status', 1)->orderBy('created_at', 'DESC')->paginate(6);
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'DESC')->get();

        $data['services'] = $services;
        $data['blogs'] = $blogs;

        return view('home', $data);
    }

    public function about(){
        $page = Page::where('id', 1)->first();

        return view('static-page', ['page' => $page]);
    }

    public function terms(){
        $page = Page::where('id', 2)->first();

        return view('static-page', ['page' => $page]);
    }

    public function privacy(){
        $page = Page::where('id', 3)->first();

        return view('static-page', ['page' => $page]);
    }
}
