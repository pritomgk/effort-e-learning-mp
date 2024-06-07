@extends('member_view.layout.app')

@section('title')
Member - Withdrawal
@endsection

@section('content')
  
<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">

                <div class="card-header border-0 text-center">
                    <h2 class="mb-2">Welcome To <span>Effort E-learning MP</span></h2>
                </div>
                
                <div class="card-header border-0">
                    <h3 class="mb-0">Payment Methods</h3>
                </div>

                <div class="row">
                    <div class="col-12 bg-light">

                        <div class="owl-slide-3 owl-carousel row justify-content-center">

                            @foreach ($member_payment_methods as $pay_method)
                                <div class="course-1-item col-md-4 text-left mx-4 my-4 card-body">
                                    {{-- <figure class="thumnail">
                                        <a href=""><img width="340px" src="{{ asset('storage/uploads/image/'.$class->image) }}" alt="Image" class="img-fluid" /></a>
                                        <div class="price">{{ $class->price }}</div>
                                    </figure> --}}
                                    <div class="class-1-content card pb-4 px-2 py-2 row">
                                        <h2><img width="60px;" height="60px;" style="border: 1px solid black; border-radius: 50%;" src="{{ asset('storage/uploads/site_elements/bkash.png') }}" alt="">{{ $pay_method->name }}</h2>
                                        <p>Account Number : {{ $pay_method->account_num }}</p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>

                
                <div class="card-header border-0">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#paymethodModalCenter">
                        Add Payment Method
                    </button>
                </div>
                
                
                <!-- Modal -->
                <div class="modal fade" id="paymethodModalCenter" tabindex="-1" role="dialog" aria-labelledby="paymethodModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymethodModalLongTitle">Add Payment Method</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="" method="post">
                                <div class="modal-body">
                                    @csrf
                                    <select name="name" class="form-control" type="text">
                                        <option value="">Choose..</option>
                                        <option value="Bkash"><span><img height="20px;" width="20px;" src="{{ asset('storage/uploads/site_elements/bkash.png') }}" alt=""></span> Bkash</option>
                                        <option value="Nagad">Nagad</option>
                                        <option value="Rocket">Rocket</option>
                                    </select>
                                    @error('name')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                    <input name="account_num" class="form-control" placeholder="Account Number" type="number" value="+880" max="16">
                                    @error('account_num')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-header border-0">
                    <h3 class="mb-0">Courses</h3>
                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="owl-slide-3 owl-carousel row justify-content-center">

                            @foreach ($courses as $course)
                                <div class="course-1-item col-md-3 text-center card-body bg-light mx-4 my-4">
                                    <figure class="thumnail">
                                        <a href=""><img width="340px" src="{{ asset('storage/uploads/image/'.$course->image) }}" alt="Image" class="img-fluid" /></a>
                                        <div class="price">{{ $course->price }}</div>
                                    </figure>
                                    <div class="course-1-content pb-4">
                                        <h2>{{ $course->title }}</h2>
                                        <div class="rating text-center mb-3">
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                            <span class="icon-star2 text-warning"></span>
                                        </div>
                                        <p><a href="{{ route('member_online_class', $course->course_id) }}" class="btn btn-primary rounded-0 px-4">See Classes</a></p>
                                    </div>
                                </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div> --}}

            </div>
        </div>
    </div>
</div>

@endsection


