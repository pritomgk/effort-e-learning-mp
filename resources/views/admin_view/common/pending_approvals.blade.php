@extends('admin_view.layout.app') 
@section('title') 
Admin - Pending Approvals 
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
                <table id="filterTableMember" class="table table-hover">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>CP</th>
                            <th>Presenter</th>
                            <th>Presenter Approval</th>
                            <th>Added By</th>
                            <th>Approval</th>
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($pending_approvals as $pending_approval)
                        @if ($pending_approval->email != 'pritomguha62@gmail.com')
                            @if ($pending_approval->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('pending_approval_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $pending_approval->name }}</td>
                                            <td><a href="tel:{{ $pending_approval->phone }}">{{ $pending_approval->phone }}</a></td>
                                            <td><a href="mailto:{{ $pending_approval->email }}">{{ $pending_approval->email }}</a></td>
                                            <td><a href="{{ $pending_approval->whatsapp }}">{{ $pending_approval->whatsapp }}</a></td>
                                            <td>
                                                <select name="cp_id">
                                                    @foreach ($all_cps as $cp)
                                                        @if ($pending_approval->cp_id == $cp->admin_id)
                                                            <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_cps as $cp)
                                                        <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                    @endforeach
                                                    <option value="">Choose..</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="presenter_id">
                                                    {{-- <option value="">Choose..</option> --}}
                                                    @foreach ($all_presenters as $presenter)
                                                        @if ($pending_approval->presenter_id == $presenter->admin_id)
                                                            <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_presenters as $presenter)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endforeach
                                                    <option value="">Choose..</option>
                                                </select>
                                            </td>
                                            <td>
                                                    
                                                @if ($pending_approval->presenter_approval == 1)
                                                    Approved
                                                    @elseif ($pending_approval->presenter_approval == 0)
                                                    Pending
                                                @endif

                                            </td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($pending_approval->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($pending_approval->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <select name="cp_approval" id="">
                                                    <option value="">Choose..</option>
                                                    <option value="1">Approve</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </td>
                                            <td>
                                                {{ $pending_approval->created_at }}
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $pending_approval->member_id }}">
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


