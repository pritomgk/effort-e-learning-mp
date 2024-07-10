@extends('admin_view.layout.app') 
@section('title') 
Admin - Todays Leads
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
                <table id="filterTableActiveMember" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>User Code</th>
                            <th>Parent Name</th>
                            <th>Parent User Code</th>
                            <th>Executive</th>
                            <th>Joined At</th>
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($todays_leads as $todays_lead)
                        @if ($todays_lead->email != 'pritomguha62@gmail.com')
                            @if ($todays_lead->email != 'holy.it01@gmail.com')
                                <form action="{{ route('active_members_update') }}" method="POST">
                                    @csrf
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ $todays_lead->name }}</td>
                                        <td><a href="tel:{{ $todays_lead->phone }}">{{ $todays_lead->phone }}</a></td>
                                        <td><a href="mailto:{{ $todays_lead->email }}">{{ $todays_lead->email }}</a></td>
                                        <td><a href="https://wa.me/{{ $todays_lead->whatsapp }}">{{ $todays_lead->whatsapp }}</a></td>
                                        <td>{{ $todays_lead->user_code }}</td>
                                        
                                        <td>
                                            @foreach ($all_admins as $all_admin)
                                                @if ($todays_lead->parent_user_code == $all_admin->user_code)
                                                    {{ $all_admin->name }}
                                                @endif
                                            @endforeach
                                            @foreach ($all_members as $all_member)
                                                @if ($todays_lead->parent_user_code == $all_member->user_code)
                                                    {{ $all_member->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $todays_lead->parent_user_code }}</td>
                                        <td>
                                            Error! can't found
                                        </td>
                                        <td>{{ $todays_lead->created_at }}</td>
                                        <td>
                                            <input type="hidden" hidden name="member_id" value="{{ $todays_lead->member_id }}">
                                            {{-- <input type="submit" class="btn btn-success" value="Update"> --}}
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


