@extends('admin_view.layout.app')

@section('title')
    Create Class
@endsection

@section('content')
<div class="col-md-6 grid-margin stretch-card mx-auto">
    <div class="card">
        <div class="card-body">
            <div class="text-center mx-auto">
                <h4 class="card-title">Create Class</h4>
                <p class="card-description">
                    Class information.
                </p>
            </div>
            <form class="forms-sample" action="{{ route('add_class_info') }}" method="POST" enctype="multipart/form-data">

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
                        <input type="text" name="title" class="form-control" id="exampleInputTitle" placeholder="Title" required />
                        @error('title')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputclass_date" class="col-sm-3 col-form-label">Class Date</label>
                    <div class="col-sm-9">
                        <input type="date" name="class_date" class="form-control" id="exampleInputclass_date" required />
                        @error('class_date')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputclass_start_time" class="col-sm-3 col-form-label">Class Start</label>
                    <div class="col-sm-3">
                        <input type="time" name="class_start_time" class="form-control" id="exampleInputclass_start_time" required />
                        @error('class_start_time')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <label for="exampleInputclass_end_time" class="col-sm-3 col-form-label">Class End</label>
                    <div class="col-sm-3">
                        <input type="time" name="class_end_time" class="form-control" id="exampleInputclass_end_time" required />
                        @error('class_end_time')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputClassLink" class="col-sm-3 col-form-label">Class Link</label>
                    <div class="col-sm-9">
                        <input type="text" name="class_link" class="form-control" id="exampleInputClassLink" required />
                        @error('class_link')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleInputClassLink" class="col-sm-3 col-form-label">Course</label>
                    <div class="col-sm-9">
                        <select type="text" name="course_id" class="form-control" id="exampleInputClassLink">
                            <option value="">Choose..</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
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


