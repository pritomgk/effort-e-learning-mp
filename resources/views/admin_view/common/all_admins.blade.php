@extends('admin_view.layout.app') 
@section('title') 
Admin - All Admins 
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
                            {{-- <th>Added By</th> --}}
                            <th>Post</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($all_admins as $all_admin)
                            @if ($all_admin->email != 'pritomguha62@gmail.com')
                                @if ($all_admin->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('update_all_admin') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>
                                                {{ $sl }}
                                                <input type="hidden" hidden name="admin_id" value="{{ $all_admin->admin_id }}">
                                            </td>
                                            <td><input type="text" name="name" value="{{ $all_admin->name }}"></td>
                                            <td>
                                                {{-- <a href="tel:{{ $all_admin->phone }}">{{ $all_admin->phone }}</a> --}}
                                                <input type="text" name="phone" value="{{ $all_admin->phone }}">
                                            </td>
                                            <td>
                                                {{-- <a href="mailto:{{ $all_admin->email }}">{{ $all_admin->email }}</a> --}}
                                                <input type="email" name="email" value="{{ $all_admin->email }}">
                                            </td>
                                            <td>
                                                {{-- <a href="https://wa.me/{{ $all_admin->whatsapp }}">{{ $all_admin->whatsapp }}</a> --}}
                                                <input type="text" name="whatsapp" value="{{ $all_admin->whatsapp }}">
                                            </td>
                                            <td>
                                                @if ($all_admin->gender == 'm')
                                                    Male
                                                @elseif ($all_admin->gender == 'f')
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </td>
                                            <td><input type="text" name="home_town" value="{{ $all_admin->home_town }}"></td>
                                            <td><input type="text" name="city" value="{{ $all_admin->city }}"></td>
                                            <td><input type="text" name="country" value="{{ $all_admin->country }}"></td>
                                            <td>{{ $all_admin->balance }}</td>
                                            <td>{{ $all_admin->withdraws }}</td>
                                            {{-- <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($all_admin->parent_id == $all_admin->admin_id)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                            </td> --}}
                                            <td>
                                                <select name="role_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($roles as $role)
                                                        {{-- @if ($all_admin->role_id == $role->role_id)
                                                            <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                                                            @else
                                                        @endif --}}
                                                            <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </td>
                                            <td>
                                                @if ($all_admin->email != 'pritomguha62@gmail.com' or $all_admin->email != 'holy.it01@gmail.com')
                                                        <select name="status">
                                                            @if ($all_admin->status == 1)
                                                                <option value="1">Active</option>
                                                            @else
                                                                <option value="0">Inactive</option>
                                                            @endif
                                                            <option value="0">Inactive</option>
                                                            <option value="1">Active</option>
                                                        </select>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#allActive{{ $all_admin->admin_id }}">Update</button> --}}
                                                <input class="btn btn-success" type="submit" value="Update">
                                            </td>
                                            {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                            <td><label class="badge badge-danger">Pending</label></td> --}}
                                            
                                                <!-- Modal -->
                                                {{-- <div class="modal fade" id="allActive{{ $all_admin->admin_id }}" tabindex="-1" role="dialog" aria-labelledby="allActive{{ $all_admin->admin_id }}Label" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="allActive{{ $all_admin->admin_id }}Label">Alert</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure to update user information?
                                                                {{ $all_admin->admin_id }}
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <input class="btn btn-success" type="submit" value="Update">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

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


