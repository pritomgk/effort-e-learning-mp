@extends('admin_view.layout.app') 
@section('title') 
Admin - Inactive Members
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
                <table id="filterTableMember" class="table table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Whatsapp</th>
                            <th>User Code</th>
                            {{-- <th>Director</th> --}}
                            <th>SEO</th>
                            <th>EO</th>
                            <th>Executive</th>
                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                            <th>CP</th>
                            <th>Presenter</th>
                            @endif
                            <th>Balance</th>
                            <th>Added By</th>
                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                <th>Status</th>
                            @endif
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($inactive_members as $inactive_member)
                            @if ($inactive_member->email != 'pritomguha62@gmail.com')
                                @if ($inactive_member->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('inactive_members_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $inactive_member->name }}</td>
                                            <td><a href="tel:{{ $inactive_member->phone }}">{{ $inactive_member->phone }}</a></td>
                                            <td><a href="mailto:{{ $inactive_member->email }}">{{ $inactive_member->email }}</a></td>
                                            <td><a href="https://wa.me/{{ $inactive_member->whatsapp }}">{{ $inactive_member->whatsapp }}</a></td>
                                            <td>{{ $inactive_member->user_code }}</td>
                                            {{-- <td>
                                                <select name="director_id">
                                                    @foreach ($all_directors as $director)
                                                        @if ($inactive_member->director_id == $director->admin_id)
                                                            <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_directors as $director)
                                                        <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </td> --}}
                                            <td>
                                                <select name="seo_id">
                                                    @foreach ($all_seos as $seo)
                                                    @if ($inactive_member->seo_id == $seo->admin_id)
                                                        <option value="{{ $seo->admin_id }}">{{ $seo->name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($all_seos as $seo)
                                                        <option value="{{ $seo->admin_id }}">{{ $seo->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="eo_id">
                                                    @foreach ($all_eos as $eo)
                                                    @if ($inactive_member->eo_id == $eo->admin_id)
                                                        <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($all_eos as $eo)
                                                        <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="executive_id">
                                                    @foreach ($all_executives as $executive)
                                                    @if ($inactive_member->executive_id == $executive->admin_id)
                                                        <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($all_executives as $executive)
                                                        <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                            <td>
                                                <select name="cp_id">
                                                    @foreach ($all_cps as $cp)
                                                    @if ($inactive_member->cp_id == $cp->admin_id)
                                                        <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($all_cps as $cp)
                                                        <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="presenter_id">
                                                    @foreach ($all_presenters as $presenter)
                                                    @if ($inactive_member->presenter_id == $presenter->admin_id)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endif
                                                    @endforeach
                                                    @foreach ($all_presenters as $presenter)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            @endif
                                            

                                            <td>{{ $inactive_member->balance }}</td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($inactive_member->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($inactive_member->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                                <td>
                                                    <select name="status">
                                                        @if ($inactive_member->status == 1)
                                                            <option value="1">Active</option>
                                                        @else
                                                        <option value="0">Inactive</option>
                                                        @endif
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </td>
                                            @endif
                                            <td>
                                                {{-- @php
                                                    $create_date_time = explode(' ', $inactive_member->created_at);
                                                @endphp
                                                <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                                <input type="time" value="{{ $create_date_time[1] }}" disabled> --}}
                                                {{ $inactive_member->created_at }}
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $inactive_member->member_id }}">
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

{{-- 
<script>
    $(document).ready(function() {
        $('#inactive_members').DataTable();
    });
</script> --}}

@endsection


