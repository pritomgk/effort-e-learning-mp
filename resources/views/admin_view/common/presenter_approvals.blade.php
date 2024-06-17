@extends('admin_view.layout.app') 
@section('title') 
Admin - Presenter Approval
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
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>Gender</th>
                            <th>Home Town</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Approval</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($presenter_approvals as $presenter_approval)
                        @if ($presenter_approval->email != 'pritomguha62@gmail.com')
                            @if ($presenter_approval->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('presenter_approval_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $presenter_approval->name }}</td>
                                            <td><a href="tel:{{ $presenter_approval->phone }}">{{ $presenter_approval->phone }}</a></td>
                                            <td><a href="mailto:{{ $presenter_approval->email }}">{{ $presenter_approval->email }}</a></td>
                                            <td><a href="{{ $presenter_approval->whatsapp }}">{{ $presenter_approval->whatsapp }}</a></td>
                                            <td>
                                                @if ($presenter_approval->gender == 'm')
                                                    Male
                                                @elseif ($presenter_approval->gender == 'f')
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </td>
                                            <td>{{ $presenter_approval->home_town }}</td>
                                            <td>{{ $presenter_approval->city }}</td>
                                            <td>{{ $presenter_approval->country }}</td>
                                            <td>
                                                <select class="form-control" name="presenter_approval">
                                                    <option value="">Choose..</option>
                                                    <option value="1">Approve</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $presenter_approval->member_id }}">
                                                <input type="submit" class="btn btn-success" value="Update">
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


