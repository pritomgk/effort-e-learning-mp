@extends('admin_view.layout.app') 
@section('title') 
Admin - Withdrawals 
@endsection 

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        
        <div class="card shadow bg-light">

            <div class="card-header border-0 text-center">
                
            @if (session()->has('error'))
                <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
            @endif
            @if (session()->has('success'))
                <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
            @endif

            </div>
            
            <div class="card-header border-0">
                <h3 class="mb-0">Payment Methods</h3>
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="owl-slide-3 owl-carousel row justify-content-center">

                        @foreach ($admin_payment_methods as $pay_method)
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="course-1-item text-left mx-4 my-4 card-body">
                                    {{-- <figure class="thumnail">
                                        <a href=""><img width="340px" src="{{ asset('storage/uploads/image/'.$class->image) }}" alt="Image" class="img-fluid" /></a>
                                        <div class="price">{{ $class->price }}</div>
                                    </figure> --}}
                                    <div class="class-1-content card pb-4 px-2 py-2 row">
                                        <h2><img width="60px;" height="60px;" style="border: 1px solid black; border-radius: 50%;" src="{{ asset('storage/uploads/site_elements/'.$pay_method->icon) }}" alt="">{{ $pay_method->name }}</h2>
                                        <p>Account Number : {{ $pay_method->account_num }}</p>
                                    </div>
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
                        <form action="{{ route('add_admin_payment_methods') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                <select name="name" class="form-control" required>
                                    <option value="">Choose..</option>
                                    <option value="Bkash">Bkash</option>
                                    <option value="Nagad">Nagad</option>
                                    <option value="Rocket">Rocket</option>
                                </select>
                                @error('name')
                                <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                @enderror
                                <input name="account_num" class="form-control" placeholder="Account Number" type="text" value="+880" max="16">
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
            <div class="card-header border-0">
                <h3 class="mb-0">Withdraw</h3>
            </div>

            <div class="row">
                <div class="col-12">

                    <div class="owl-slide-3 owl-carousel row justify-content-center">

                        <form class="col-md-8 text-center" action="{{ route('withdraw_request_admin') }}" method="post">
                            @csrf
                            <select name="method_id" class="form-control mb-3 mt-4" required>
                                <option value="">Choose..</option>
                                @foreach ($admin_payment_methods as $pay_method)
                                    <option value="{{ $pay_method->method_id }}">{{ $pay_method->name }} : {{ $pay_method->account_num }}</option>
                                @endforeach
                            </select>
                            @error('method_id')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                            @enderror
                            <input name="amount" class="form-control mb-3 mt-2" placeholder="Amount" type="number" max="{{ $admin->balance }}">
                            @error('amount')
                            <p class="mb-0 alert alert-danger">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-primary mb-3 mt-2">Submit</button>
                        </form>
                        
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


@endsection



