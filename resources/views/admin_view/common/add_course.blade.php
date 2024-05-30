@extends('admin_view.layout.app')

@section('title')
    Add Course
@endsection

@section('content')
<div class="col-md-6 grid-margin stretch-card mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="text-center mx-auto">
                <h4 class="card-title">Add Course</h4>
                <p class="card-description">
                    Course information.
                </p>
            </div>
            <form class="forms-sample" action="{{ route('add_course_info') }}" method="POST" enctype="multipart/form-data">

                @if (session()->has('error'))
                  <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
                @endif
                @if (session()->has('success'))
                  <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
                @endif

                @csrf
                <div class="form-group row">
                    <label for="exampleInputTitle" class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Title" />
                        @error('title')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputDescription" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description" class="form-control" id="exampleInputDescription" placeholder="Description" /></textarea>
                        @error('description')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputImage" class="col-sm-3 col-form-label">Image</label>
                    <div class="col-sm-9">
                        <input type="file" name="image" class="form-control" id="exampleInputImage" />
                        @error('image')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="text-center mx-auto">
                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    {{-- <button class="btn btn-light">Cancel</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


