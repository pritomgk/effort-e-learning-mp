@extends('admin_view.layout.app') 
@section('title') 
Admin - CP Approvals 
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
                            <th>Presenter</th>
                            <th>Added By</th>
                            <th>Approval</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($cp_approvals as $cp_approval)
                        @if ($cp_approval->email != 'pritomguha62@gmail.com')
                            @if ($cp_approval->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('cp_approval_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $cp_approval->name }}</td>
                                            <td><a href="tel:{{ $cp_approval->phone }}">{{ $cp_approval->phone }}</a></td>
                                            <td><a href="mailto:{{ $cp_approval->email }}">{{ $cp_approval->email }}</a></td>
                                            <td><a href="{{ $cp_approval->whatsapp }}">{{ $cp_approval->whatsapp }}</a></td>
                                            <td>
                                                <select name="presenter_id" id="" class="form-control">
                                                    @foreach ($all_presenters as $presenter)
                                                        @if ($cp_approval->presenter_id == $presenter->admin_id)
                                                            <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                            @else
                                                            <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($cp_approval->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($cp_approval->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <select class="form-control" name="cp_approval" id="">
                                                    <option value="">Choose..</option>
                                                    <option value="1">Approve</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $cp_approval->member_id }}">
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


