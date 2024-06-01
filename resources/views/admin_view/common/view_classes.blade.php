@extends('admin_view.layout.app') 
@section('title') 
Admin - View Classes
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
                            <th>Date</th>
                            <th>Time</th>
                            <th>Class Link</th>
                            <th>Course</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($online_classes as $online_class)
                            <form action="" method="POST">
                                @csrf
                                <tr>
                                    <td>{{ $online_class->title }}</td>
                                    <td>{{ $online_class->class_date }}</td>
                                    <td><input type="time" name="class_start_time" id="" class="form-control-sm" value="{{ $online_class->class_start_time }}" readonly> to <input type="time" name="class_end_time" id="" class="form-control-sm" value="{{ $online_class->class_end_time }}" readonly> </td>
                                    <td>{{ $online_class->class_link }}</td>
                                    <td>
                                        @foreach ($courses as $course)
                                            @if ($online_class->course_id == $course->course_id)
                                                {{ $course->title }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="hidden" hidden name="class_id" value="{{ $online_class->class_id }}">
                                        <a href="{{ route('delete_class', ['class_id'=>$online_class->class_id]) }}" class="btn btn-danger">Delete</a>
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


