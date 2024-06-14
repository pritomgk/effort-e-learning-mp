@extends('admin_view.layout.app') 
@section('title') 
Admin - Withdraw Approval
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
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Method</th>
                            <th>Number</th>
                            <th>Amount</th>
                            <th>User Code</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($withdraw_approvals as $withdraw_approval)
                        @if ($withdraw_approval->email != 'pritomguha62@gmail.com')
                            @if ($withdraw_approval->email != 'holy.it01@gmail.com')
                                <form action="{{ route('withdraw_approval_update') }}" method="POST">
                                    @csrf
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ $withdraw_approval->name }}</td>
                                        <td>{{ $withdraw_approval->method }}</td>
                                        <td><a href="tel:{{ $withdraw_approval->account_num }}">{{ $withdraw_approval->account_num }}</a></td>
                                        <td>{{ $withdraw_approval->amount }}</td>
                                        <td>{{ $withdraw_approval->user_code }}</td>
                                        
                                        <td>
                                            <select name="status" id="" class="form-control">
                                                <option>Choose..</option>
                                                <option value="0">Reject</option>
                                                <option value="1">Approve</option>
                                            </select>
                                        </td>

                                        <td>
                                            {{ $withdraw_approval->created_at }}
                                        </td>
                                        
                                        <td>
                                            <input type="hidden" hidden name="withdrawal_id" value="{{ $withdraw_approval->withdrawal_id }}">
                                            <input type="submit" class="btn btn-success" value="Approve">
                                        </td>
                                        {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                        <td><label class="badge badge-danger">Pending</label></td> --}}
                                    </tr>
                                </form>
                                @php
                                    $sl++;
                                @endphp
                            @endif
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection


