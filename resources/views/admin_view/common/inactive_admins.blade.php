@extends('admin_view.layout.app') 
@section('title') 
Admin - Inactive Admins 
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>Gender</th>
                            <th>Home Town</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Balance</th>
                            <th>Withdraws</th>
                            <th>Added By</th>
                            <th>Post</th>
                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                <th>Status</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inactive_admins as $inactive_admin)
                        <form action="{{ route('update_admin') }}" method="POST">
                            @csrf
                            <tr>
                                <td>{{ $inactive_admin->name }}</td>
                                <td><a href="tel:{{ $inactive_admin->phone }}">{{ $inactive_admin->phone }}</a></td>
                                <td><a href="mailto:{{ $inactive_admin->email }}">{{ $inactive_admin->email }}</a></td>
                                <td><a href="https://wa.me/{{ $inactive_admin->whatsapp }}">{{ $inactive_admin->whatsapp }}</a></td>
                                <td>
                                    @if ($inactive_admin->gender == 'm')
                                        Male
                                    @elseif ($inactive_admin->gender == 'f')
                                        Female
                                        @else
                                        Other
                                    @endif
                                </td>
                                <td>{{ $inactive_admin->home_town }}</td>
                                <td>{{ $inactive_admin->city }}</td>
                                <td>{{ $inactive_admin->country }}</td>
                                <td>{{ $inactive_admin->balance }}</td>
                                <td>{{ $inactive_admin->withdraws }}</td>
                                <td>
                                    @foreach ($all_admins as $all_admin)
                                        @if ($inactive_admin->parent_id == $all_admin->admin_id)
                                            {{ $all_admin->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($roles as $role)
                                        @if ($inactive_admin->role_id == $role->role_id)
                                            {{ $role->role_title }}
                                        @endif
                                    @endforeach
                                </td>
                                @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                    <td>
                                        @if ($inactive_admin->role_id != 1)
                                            @if ($inactive_admin->role_id != session()->get('role_id'))
                                                <select name="status" id="" class="form-control">
                                                    @if ($inactive_admin->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            @endif
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <input type="hidden" hidden name="admin_id" value="{{ $inactive_admin->admin_id }}">
                                    <input type="submit" class="btn btn-success" value="Update">
                                </td>
                                {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                <td><label class="badge badge-danger">Pending</label></td> --}}
                            </tr>
                        </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


