@extends('admin_view.layout.app') 
@section('title') 
Admin - Join Requests
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
                <table id="example" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>CP</th>
                            <th>Presenter</th>
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Registered At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($join_requests as $join_request)
                            @if ($join_request->email != 'pritomguha62@gmail.com')
                                @if ($join_request->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('join_request_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $join_request->name }}</td>
                                            <td><a href="tel:{{ $join_request->phone }}">{{ $join_request->phone }}</a></td>
                                            <td><a href="mailto:{{ $join_request->email }}">{{ $join_request->email }}</a></td>
                                            <td><a href="https://wa.me/{{ $join_request->whatsapp }}">{{ $join_request->whatsapp }}</a></td>
                                            <td>
                                                <select name="cp_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($all_cps as $cp)
                                                        <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="presenter_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($all_presenters as $presenter)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($join_request->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($join_request->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <select name="status">
                                                    @if ($join_request->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            </td>
                                            <td>
                                                @php
                                                    $create_date_time = explode(' ', $join_request->created_at);
                                                @endphp
                                                <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                                <input type="time" value="{{ $create_date_time[1] }}" disabled>
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $join_request->member_id }}">
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


