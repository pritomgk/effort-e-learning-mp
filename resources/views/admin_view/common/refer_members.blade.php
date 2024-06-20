@extends('admin_view.layout.app') 
@section('title') 
Admin - Refered Members
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
                            <th>User Code</th>
                            <th>Gender</th>
                            <th>Home Town</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($refer_members as $refer_member)
                        @if ($refer_member->email != 'pritomguha62@gmail.com')
                            @if ($refer_member->email != 'holy.it01@gmail.com')
                                    <form action="" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $refer_member->name }}</td>
                                            <td><a href="tel:{{ $refer_member->phone }}">{{ $refer_member->phone }}</a></td>
                                            <td><a href="mailto:{{ $refer_member->email }}">{{ $refer_member->email }}</a></td>
                                            <td><a href="{{ $refer_member->whatsapp }}">{{ $refer_member->whatsapp }}</a></td>
                                            <td>{{ $refer_member->user_code }}</td>
                                            <td>
                                                @if ($refer_member->gender == 'm')
                                                    Male
                                                @elseif ($refer_member->gender == 'f')
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </td>
                                            <td>{{ $refer_member->home_town }}</td>
                                            <td>{{ $refer_member->city }}</td>
                                            <td>{{ $refer_member->country }}</td>
                                            <td>
                                                @if ($refer_member->status == 1)
                                                    Active
                                                    @else
                                                    Inactive
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <input type="hidden" hidden name="admin_id" value="{{ $refer_member->admin_id }}">
                                                <input type="submit" class="btn btn-success" value="Update">
                                            </td> --}}
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


