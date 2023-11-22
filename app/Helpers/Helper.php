

<?php

use App\Models\Setting;
use App\Models\FeaturedService;
use App\Models\Service;
use App\Models\Blog;


function getSettings() {
    return Setting::first();
}

function getServices(){
    $services = FeaturedService::leftJoin('services', 'services.id', 'featured_services.service_id')
                    ->orderBy('sort_order', 'ASC')
                    ->get();

    return $services;
}

function getLatestBlog() {
    $blogs = Blog::where('status', 1)->orderBy('created_at', 'DESC')->take(6)->get();

    return $blogs;
}

?>
