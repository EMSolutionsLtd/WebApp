@extends('admin.layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Page / Edit</h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content  h-100"">
        <div class="container-fluid  h-100"">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">

                    <form action="" method="post" name="editPage" id="editPage">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('pageList') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $page->name }}">
                                    <p class="error name-error"></p>
                                </div>

                                <div class="form-group">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="summernote">{{ $page->content }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="image_id" id="image_id" value="">
                                        <label for="image">Image</label>
                                        <div id="image" class="dropzone dz-clickable">
                                            <div class="dz-message needsclick">
                                                <br>Drop files here or click to upload.
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 pt-3">
                                        @if (!empty($page->image))
                                            <img src="{{ asset('uploads/pages/thumb/large/'.$page->image) }}" width="150">
                                            <button type="button" class="btn btn-danger" onclick="deleteImage({{ $page->id }});">Delete</button>
                                        @else
                                            <img src="{{ asset('uploads/placeholder.png') }}" alt="" width="50">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $page->status == 1? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $page->status == 0? 'selected' : '' }}>Block</option>
                                    </select>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection


@section('extraJs')

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url:  "{{ route('tempUpload') }}",
        maxFiles: 1,
        paramName: 'file',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }, success: function(file, response){
            $("#image_id").val(response.id);
        }
    });

    function deleteImage(id) {
        if(confirm('Are you sure you want to delete image?')) {
            $.ajax({
                url: '{{ route("page.deleteImage") }}',
                type: 'post',
                dataType: 'json',
                data: {id: id},
                success: function(response) {
                    window.location.href = "{{ route('page.edit', $page->id) }}";
                }
            })
        }
    }

    $("#editPage").submit(function(event) {
        event.preventDefault();
        $("button[type='submit']").prop('disabled', true);

        $.ajax({
            url: '{{ route("page.update", $page->id) }}',
            type: 'POST',
            dataType: 'json',
            data: $("#editPage").serializeArray(),
            success: function(response) {
                $("button[type='submit']").prop('disabled', false);

                if(response.status == 200) {
                    window.location.href = "{{ route('pageList') }}";
                } else {
                    $('.name-error').html(response.errors.name);
                }
            }
        })
    })
</script>

@endsection
