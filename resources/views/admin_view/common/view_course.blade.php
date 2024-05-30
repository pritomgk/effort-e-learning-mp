@extends('admin_view.layout.app') 
@section('title') 
Admin - View Courses
@endsection 

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Hoverable Table</h4>
            <p class="card-description">Add class <code>.table-hover</code></p>

            @if (session()->has('error'))
              <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
            @endif
            @if (session()->has('success'))
              <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            {{-- <th>Added By</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($courses as $course)
                        
                        <form action="{{ route('update_course_info') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <tr>
                                <td><input class="form-control" type="text" name="title" value="{{ $course->title }}"></td>
                                <td><input class="form-control" type="text" name="description" value="{{ $course->description }}"></td>
                                <td><input class="form-control" type="file" name="image"></td>
                                <td>
                                
                                    {{-- <select class="form-control" name="" id=""> --}}
                                                {{-- <option value="">{{ $admin_user->name }}</option> --}}
                                        {{-- @foreach ($admin_users as $admin_user)
                                            @if ($course->admin_id === $admin_user->admin_id)
                                                <input type="text" class="form-control" value="{{ $admin_user->name }}">
                                            @endif
                                        @endforeach --}}
                                    </select>
                                    
                                        
                                </td>
                                
                                <td>
                                    <input class="form-control" type="hidden" hidden name="course_id" value="{{ $course->course_id }}">
                                    <input type="submit" class="btn btn-success" value="Update">
                                </td>
                                {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                <td><label class="badge badge-danger">Pending</label></td> --}}
                            </tr>
                        </form>

                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


