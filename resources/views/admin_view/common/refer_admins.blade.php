@extends('admin_view.layout.app') 
@section('title') 
Admin - Refered Admins
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

            <input type="datetime-local" id="startTimestamp">
            <input type="datetime-local" id="endTimestamp">
            <button id="filterButton">Filter</button>
            
            <div class="table-responsive">
                <table id="filterTableAdmin" class="table table-hover">
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
                            <th>Joined At</th>
                            <th>...</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($refer_admins as $refer_admin)
                        @if ($refer_admin->email != 'pritomguha62@gmail.com')
                            @if ($refer_admin->email != 'holy.it01@gmail.com')
                                    <form action="" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $refer_admin->name }}</td>
                                            <td><a href="tel:{{ $refer_admin->phone }}">{{ $refer_admin->phone }}</a></td>
                                            <td><a href="mailto:{{ $refer_admin->email }}">{{ $refer_admin->email }}</a></td>
                                            <td><a href="{{ $refer_admin->whatsapp }}">{{ $refer_admin->whatsapp }}</a></td>
                                            <td>{{ $refer_admin->user_code }}</td>
                                            <td>
                                                @if ($refer_admin->gender == 'm')
                                                    Male
                                                @elseif ($refer_admin->gender == 'f')
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </td>
                                            <td>{{ $refer_admin->home_town }}</td>
                                            <td>{{ $refer_admin->city }}</td>
                                            <td>{{ $refer_admin->country }}</td>
                                            <td>
                                                @if ($refer_admin->status == 1)
                                                    Active
                                                    @else
                                                    Inactive
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <input type="hidden" hidden name="admin_id" value="{{ $refer_admin->admin_id }}">
                                                <input type="submit" class="btn btn-success" value="Update">
                                            </td> --}}
                                            {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                            <td><label class="badge badge-danger">Pending</label></td> --}}
                                            <td>{{ $refer_admin->created_at }}</td>
                                            <td>...</td>
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


