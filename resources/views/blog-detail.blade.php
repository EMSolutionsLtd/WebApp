@extends('layouts.app')

@section('content')
<section class="hero-small">
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('assets/images/banner1.jpg') }}') ;">
                <div class="hero-small-background-overlay"></div>
                <div class="container  h-100">
                    <div class="row align-items-center d-flex h-100">
                        <div class="col-md-12">
                            <div class="block text-center">
                                <span class="text-uppercase text-sm letter-spacing"></span>
                                <h1 class="mb-3 mt-3 text-center">Blog & News</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-3 py-5">
    <div class="container">
        <h2>{{ $blog->name }}</h2>
        <div>
            <small>{{ date('d/m/Y', strtotime($blog->created_at)) }}</small>
        </div>

        @if(!empty($blog->image))
        <div class="mt-2">
            <img src="{{ asset('uploads/blogs/thumb/large/'.$blog->image) }}" alt="" class="w-100">
        </div>
        @endif

        <div class="mt-5">
            {!! $blog->description !!}
        </div>

        <div class="comment-box my-4">
            <h5>Comment Here</h5>
            <form action="" id="commentForm" name="commentForm">
                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="name", id="name" class="form-control" placeholder="Enter Name">
                            <p class="name-error invalid-feedback"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <textarea name="comment" placeholder="Enter your comment here." id="comment" cols="30" rows="10" class="form-control"></textarea>
                            <p class="comment-error invalid-feedback"></p>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>

        <hr>

        <h4>Comments</h4>
        <div id="comment-box">
            @if(!empty($comments))
                @foreach ($comments as $comment)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="h5">{{ $comment->name }}</div>
                                <div>Posted at: {{ date('d/m/Y h:i a', strtotime($comment->created_at)) }}</div>
                            </div>

                            <div class="">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</section>
@endsection


@section('extraJs')
<script type="text/javascript">
    $("#commentForm").submit(function(event) {
        event.preventDefault();
        $("button[type='submit']").prop('disabled', true);

        $.ajax({
            url: '{{ route('save.comment') }}',
            type: 'post',
            data: $(this).serializeArray(),
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);

                if(response['status'] == 0) {
                    if(response['errors']['name']) {
                        $(".name-error").html(response['errors']['name']);
                        $("#name").addClass('is-invalid');
                    } else {
                        $(".name-error").html('');
                        $("#name").removeClass('is-invalid');
                    }

                    if(response['errors']['comment']) {
                        $(".comment-error").html(response['errors']['comment']);
                        $("#comment").addClass('is-invalid');
                    } else {
                        $(".comment-error").html('');
                        $("#comment").removeClass('is-invalid');
                    }
                } else {
                    var html = `<div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="h5">${response['name']}</div>
                                <div>Posted at: ${response['created_at']}</div>
                            </div>

                            <div class="">
                                ${response['comment']}
                            </div>
                        </div>
                    </div>`;

                    $("#comment-box").append(html);
                    $("#name").val('');
                    $("#comment").val('');

                    $(".name-error").html('');
                    $("#name").removeClass('is-invalid');

                    $(".comment-error").html('');
                    $("#comment").removeClass('is-invalid');
                }
            }, error: function() {

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
    })
</script>
@endsection
