@extends('admin_view.layout.app') 
@section('title') 
Admin - Executve Approvals 
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
                            <th>CP</th>
                            <th>Presenter</th>
                            <th>Balance</th>
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($executive_approvals as $executive_approval)
                        <form action="{{ route('executive_approval_update') }}" method="POST">
                            @csrf
                            <tr>
                                <td>{{ $executive_approval->name }}</td>
                                <td><a href="tel:{{ $executive_approval->phone }}">{{ $executive_approval->phone }}</a></td>
                                <td><a href="mailto:{{ $executive_approval->email }}">{{ $executive_approval->email }}</a></td>
                                <td><a href="{{ $executive_approval->whatsapp }}">{{ $executive_approval->whatsapp }}</a></td>
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
                                <td>{{ $executive_approval->balance }}</td>
                                <td>
                                    @foreach ($all_admins as $all_admin)
                                        @if ($executive_approval->parent_user_code == $all_admin->user_code)
                                            {{ $all_admin->name }}
                                        @endif
                                    @endforeach
                                    @foreach ($all_members as $all_member)
                                        @if ($executive_approval->parent_user_code == $all_member->user_code)
                                            {{ $all_member->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <select name="status">
                                        @if ($executive_approval->status == 1)
                                            <option value="1">Active</option>
                                        @else
                                        <option value="0">Inactive</option>
                                        @endif
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" hidden name="member_id" value="{{ $executive_approval->member_id }}">
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


