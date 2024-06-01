@extends('member_view.layout.app')

@section('title')
    Classes
@endsection

@section('content')

<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Classes</h3>
                </div>
                        
                <div class="row">
                    <div class="col-12">

                        <div class="owl-slide-3 owl-carousel row justify-content-center">

                            @foreach ($course_classes as $class)
                                <div class="course-1-item col-md-3 text-center card-body bg-light mx-4 my-4">
                                    {{-- <figure class="thumnail">
                                        <a href=""><img width="340px" src="{{ asset('storage/uploads/image/'.$class->image) }}" alt="Image" class="img-fluid" /></a>
                                        <div class="price">{{ $class->price }}</div>
                                    </figure> --}}
                                    <div class="class-1-content pb-4">
                                        <h2>{{ $class->title }}</h2>
                                        <h4>{{ $class->class_date }}</h4>
                                        <div class="rating text-center mb-3">
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                        </div>
                                        <p class="desc mb-4 text-center"><input type="time" name="class_start_time" class="form-control" readonly id="" value="{{ $class->class_start_time }}"> to <input type="time" name="class_end_time" class="form-control" readonly id="" value="{{ $class->class_end_time }}"></p>
                                        <p><a href="{{ $class->class_link }}" target="_blank" class="btn btn-primary rounded-0 px-4">Join Class</a></p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection


