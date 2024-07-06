@extends('member_view.layout.app') 
@section('title') 
Member - Passbook 
@endsection 
@section('content')

<div class="container-fluid mt--7">
    <!-- Table -->

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0 text-center">
                    <h3 class="mb-0">Passbook</h3>
                </div>
                {{-- <div class="card-header border-0 mb-2 mt-2">
                    <button type="button" class="btn btn-primary">Total : {{ $member_passbookences->count() }}</button>
                    <button type="button" class="btn btn-success">Active : {{ $member_active_references->count() }}</button>
                    <button type="button" class="btn btn-warning">Inactive : {{ $member_inactive_references->count() }}</button>
                </div> --}}
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Method</th>
                                <th scope="col">Number</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">User_code</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($member_debit_passbooks as $member_passbook)
                                <tr>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $sl }}</span>
                                    </td>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            {{-- <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="{{ asset('storage/uploads/pro_pic/'.$member_passbook->pro_pic) }}" />
                                            </a> --}}
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{ $member_passbook->payment_method }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    
                                    <td>
                                        <a href="tel:{{ $member_passbook->account_num }}"><span class="mb-0 text-sm">{{ $member_passbook->account_num }}</span></a>
                                    </td>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_passbook->amount }}</span>
                                    </td>
                                    <td>
                                        @if ($member_passbook->status == 1)
                                            <span class="badge badge-dot mr-4"> <i class="bg-success"></i> Approved </span>
                                            @elseif ($member_passbook->status == 0)
                                            <span class="badge badge-dot mr-4"> <i class="bg-warning"></i> Pending </span>
                                            @else
                                            <span class="badge badge-dot mr-4"> <i class="bg-warning"></i> Rejected </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_passbook->user_code }}</span>
                                    </td>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_passbook->created_at }}</span>
                                    </td>
                                </tr>
                                @php
                                    $sl++;
                                @endphp
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


