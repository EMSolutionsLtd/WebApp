@extends('layouts.app')

@section('content')
<section class="hero">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset("assets/images/burning-candles-gb39feb6a6_1920.jpg") }}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-7">
                            <div class="block" >
                                <div class="divider mb-3"></div>
                                <span class="text-uppercase text-sm letter-spacing">Bruce Lee
                                </span>
                                <h1 class="mb-3 mt-3">If you love life, don’t waste time, for time is what life is made up of</h1>
                                <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>
                                <div class="btn-container ">
                                    <a href="{{ url('/contact') }}" target="_blank" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item " style="background-image: url('{{ asset('assets/images/wordpress-g6c98302cb_1920.jpg') }}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-7">
                            <div class="block" >
                                <div class="divider mb-3"></div>
                                <span class="text-uppercase text-sm letter-spacing">Leo Tolstoy, War and Peace</span>
                                <h1 class="mb-3 mt-3">The two most powerful warriors are patience and time.</h1>

                                <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>
                                <div class="btn-container ">
                                    <a href="{{ url('/contact') }}" target="_blank" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="carousel-item" style="background-image: url('{{ asset('assets/images/student-gee54e2f66_1920.jpg') }}') ;">
                <div class="hero-background-overlay"></div>
                <div class="container align-items-center d-flex h-100">
                    <div class="container h-100">
                        <div class="row align-items-center d-flex h-100">
                            <div  class="col-md-7">
                                <div class="block" >
                                    <div class="divider mb-3"></div>
                                    <span class="text-uppercase text-sm letter-spacing">Stephen R. Covey</span>
                                    <h1 class="mb-3 mt-3">The key is in not spending time, but in investing it.</h1>

                                    <p class="mb-4 pr-5">A repudiandae ipsam labore ipsa voluptatum quidem quae laudantium quisquam aperiam maiores sunt fugit, deserunt rem suscipit placeat.</p>
                                    <div class="btn-container ">
                                        <a href="{{ url('/contact') }}" target="_blank" class="btn btn-primary">Contact Now <i class="icofont-simple-right ml-2  "></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<section class="section-2  py-5">
    <div class="container py-2">
        <div class="row">
            <div class="col-md-6 align-items-center d-flex">
                <div class="about-block">
                    <h1 class="title-color">Welcome</h1>
                    <div class="mt-2 mb-3 text-muted">Professionals &amp; Creative People</div>
                    <p>This is a great space to write long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.</p>
                    <p>This is a great space to write long text about your company and your services. You can use this space to go into a little more detail about your company. Talk about your team and what services you provide. Tell your visitors the story of how you came up with the idea for your business and what makes you different from your competitors. Make your company stand out and show your visitors who you are.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="image-red-background">
                    <img src="{{ asset('assets/images/about-us.jpg') }}" alt="" class="w-100">
                </div>

            </div>
        </div>
    </div>
</section>

<section class="section-3 py-5">
    <div class="container">
        <div class="divider mb-3"></div>
        <h2 class="title-color mb-4 h1">Services</h2>
        <div class="cards">
            <div class="services-slider">

                @if(!empty($services))
                    @foreach ($services as $service)
                        <div class="card border-0 ">
                            @if (!empty($service->image))
                                <img src="{{ asset('uploads/services/thumb/small/'.$service->image) }}" class="card-img-top" alt="">
                            @else
                                <img src="{{ asset('uploads/placeholder.png') }}" class="card-img-top" alt="">
                            @endif

                            <div class="card-body p-3">
                                <h1 class="card-title mt-2"><a href="{{ url('/services/detail/'.$service->id) }}">{{ $service->name }}</a></h1>
                                <div class="content pt-2">
                                    <p class="card-text">{{ $service->short_desc }}</p>
                                </div>
                                <a href="{{ url('/services/detail/'.$service->id) }}" class="btn btn-primary mt-4">Details <i class="fa-solid fa-angle-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</section>

<section class="section-4 py-5 text-center">
    <div class="hero-background-overlay"></div>
    <div class="container">
       <div class="help-container">
            <h1 class="title">Do you need help?</h1>
            <p class="card-text mt-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi ipsum, odit velit exercitationem praesentium error id iusto dolorem expedita nostrum eius atque? Aliquam ab reprehenderit animi sapiente quasi, voluptate dolorum?</p>
            <a href="{{ url('/contact') }}" class="btn btn-primary mt-3">Call Us Now <i class="fa-solid fa-angle-right"></i></a>
       </div>
    </div>
</section>

@include('common.latest-blog');

@endsection
