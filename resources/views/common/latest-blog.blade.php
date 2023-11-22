<section class="section-3 py-5">
    <div class="container">
        <div class="divider mb-3"></div>
        <h2 class="title-color mb-4 h1">Blog & News</h2>
        <div class="cards">
            <div class="services-slider">

                @if (!empty(getLatestBlog()))
                    @foreach (getLatestBlog() as $blog)
                        <div class="card border-0 ">
                            @if (!empty($blog->image))
                                <img src="{{ asset('uploads/blogs/thumb/small/'.$blog->image) }}" class="card-img-top" alt="">
                            @else
                                <img src="{{ asset('uploads/placeholder.png') }}" class="card-img-top" alt="">
                            @endif

                            <div class="card-body p-3">
                                <h1 class="card-title mt-2"><a href="{{ route('blog-detail', $blog->id) }}">{{ $blog->name }}</a></h1>
                                <div class="content pt-2">
                                    <p class="card-text">{{ $blog->short_desc }}</p>
                                </div>
                                <a href="{{ route('blog-detail', $blog->id) }}" class="btn btn-primary mt-4">Details <i class="fa-solid fa-angle-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>
