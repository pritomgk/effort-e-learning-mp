@extends('member_view.layout.app')

@section('title')
Member - Change Password
@endsection

@section('content')
  
<div class="container-fluid mt--7">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card shadow">

                <div class="card-header border-0">
                    <h3 class="mb-0">Change Password</h3>
                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="owl-slide-3 owl-carousel row justify-content-center">

                            
                            <form class="col-md-8 mt-4 mb-4 text-center bg-light" action="{{ route('member_password_change') }}" method="post">

                                @if (session()->has('error'))
                                    <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
                                @endif
                                @if (session()->has('success'))
                                    <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
                                @endif
              
                                @csrf
                                
                                <input name="password" class="form-control mb-3 mt-4" placeholder="Old Password" type="password">
                                @error('password')
                                <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                @enderror
                                <input name="new_password" class="form-control mb-3 mt-2" placeholder="New Password" type="password">
                                @error('new_password')
                                <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                @enderror
                                <input name="confirm_new_password" class="form-control mb-3 mt-2" placeholder="Confirm New Password" type="password">
                                @error('confirm_new_password')
                                <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                @enderror
                                <button type="submit" class="btn btn-warning mb-3 mt-2">Save</button>

                            </form>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection


