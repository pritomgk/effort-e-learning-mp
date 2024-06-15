@extends('admin_view.layout.app') 
@section('title') 
Admin - Credit Passbooks
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
                {{-- <input class="form-control" id="myInput" type="text" placeholder="Search..">
                    <br> --}}
                <table class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>User Code</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($credit_passbooks as $credit_passbook)
                            <form action="" method="POST">
                                @csrf
                                <tr>
                                    <td>{{ $sl }}</td>
                                    <td>{{ $credit_passbook->sender_name }}</td>
                                    <td>{{ $credit_passbook->amount }}</td>
                                    <td>{{ $credit_passbook->sender_user_code }}</td>
                                    <td>{{ $credit_passbook->created_at }}</td>
                                </tr>
                            </form>
                            @php
                                $sl++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


