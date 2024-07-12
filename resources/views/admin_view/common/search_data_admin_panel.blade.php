@extends('admin_view.layout.app') 
@section('title') 
Admin - Search
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
            
            @if (!empty($search_data_admins))
                
                @if (session()->get('role_id') <= 3)

                
                <h4 class="mt-3 text-center mx-auto col-12 col-md-12 col-lg-12">Admin</h4>

                <div class="table-responsive mt-3">
                    {{-- <input class="form-control" id="myInput" type="text" placeholder="Search..">
                        <br> --}}
                    <table id="filterTableAdmin" class="table table-hover table-bordered table-striped">
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
                                <th>Balance</th>
                                <th>Withdraws</th>
                                {{-- <th>Added By</th> --}}
                                <th>Post</th>
                                <th>Status</th>
                                <th>Joined At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($search_data_admins as $search_data_admin)
                                @if ($search_data_admin->email != 'pritomguha62@gmail.com')
                                    @if ($search_data_admin->email != 'holy.it01@gmail.com')
                                        <form action="{{ route('update_all_admin') }}" method="POST">
                                            @csrf
                                            <tr>
                                                <td>
                                                    {{ $sl }}
                                                    <input type="hidden" hidden name="admin_id" value="{{ $search_data_admin->admin_id }}">
                                                    <input type="hidden" hidden name="search_type_admin" value="1">
                                                </td>
                                                <td><input type="text" name="name" value="{{ $search_data_admin->name }}"></td>
                                                <td>
                                                    {{-- <a href="tel:{{ $search_data_admin->phone }}">{{ $search_data_admin->phone }}</a> --}}
                                                    <input type="text" name="phone" value="{{ $search_data_admin->phone }}">
                                                </td>
                                                <td>
                                                    {{-- <a href="mailto:{{ $search_data_admin->email }}">{{ $search_data_admin->email }}</a> --}}
                                                    <input type="email" name="email" value="{{ $search_data_admin->email }}">
                                                </td>
                                                <td>
                                                    {{-- <a href="https://wa.me/{{ $search_data_admin->whatsapp }}">{{ $search_data_admin->whatsapp }}</a> --}}
                                                    <input type="text" name="whatsapp" value="{{ $search_data_admin->whatsapp }}">
                                                </td>
                                                <td>
                                                    {{-- <a href="https://wa.me/{{ $search_data_admin->whatsapp }}">{{ $search_data_admin->whatsapp }}</a> --}}
                                                    {{ $search_data_admin->user_code }}
                                                </td>
                                                <td>
                                                    @if ($search_data_admin->gender == 'm')
                                                        Male
                                                    @elseif ($search_data_admin->gender == 'f')
                                                        Female
                                                        @else
                                                        Other
                                                    @endif
                                                </td>
                                                <td><input type="text" name="home_town" value="{{ $search_data_admin->home_town }}"></td>
                                                <td><input type="text" name="city" value="{{ $search_data_admin->city }}"></td>
                                                <td><input type="text" name="country" value="{{ $search_data_admin->country }}"></td>
                                                <td><input type="text" disabled name="balance" value="{{ $search_data_admin->balance }}">

                                                    @if ($search_data_admin->email != 'priyaakter01749@gmail.com')
                                                        <input type="text" name="add_balance" placeholder="Add Balance">
                                                        <input type="text" name="deduct_balance" placeholder="Deduct Balance">
                                                    @endif
                                                    
                                                </td>
                                                <td>{{ $search_data_admin->withdraws }}</td>
                                                {{-- <td>
                                                    @foreach ($search_data_admins as $search_data_admin)
                                                        @if ($search_data_admin->parent_id == $search_data_admin->admin_id)
                                                            {{ $search_data_admin->name }}
                                                        @endif
                                                    @endforeach
                                                </td> --}}
                                                <td>
                                                    <select name="role_id">
                                                        @foreach ($roles as $role)
                                                            @if ($search_data_admin->role_id == $role->role_id)
                                                                <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($roles as $role)
                                                                <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                                                        @endforeach
                                                        <option value="">Choose..</option>
                                                    </select>
                                                    
                                                </td>
                                                <td>
                                                    @if ($search_data_admin->email != 'pritomguha62@gmail.com' or $search_data_admin->email != 'holy.it01@gmail.com')
                                                            <select name="status">
                                                                {{-- @if ($search_data_admin->status == 1)
                                                                    <option value="1">Active</option>
                                                                @else
                                                                    <option value="0">Inactive</option>
                                                                @endif --}}
                                                                <option value="">Choose..</option>
                                                                <option value="0">Inactive</option>
                                                                <option value="1">Active</option>
                                                            </select>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{-- @php
                                                        $create_date_time = explode(' ', $search_data_admin->created_at);
                                                    @endphp --}}
                                                    {{-- <input type="date" value="" disabled> --}}
                                                    {{ $search_data_admin->created_at }}
                                                    {{-- <input type="time" value="{{ $create_date_time[1] }}" disabled> --}}
                                                </td>
                                                <td>
                                                    {{-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#allActive{{ $search_data_admin->admin_id }}">Update</button> --}}
                                                    @if (session()->get('email') == 'mukaddasluvan@gmail.com')
                                                        @if ($search_data_admin->email != 'priyaakter01749@gmail.com')
                                                            @if ($search_data_admin->email != 'mahdimir4455@gmail.com')
                                                                @if ($search_data_admin->email != 'mukaddasluvan@gmail.com')
                                                                    <input class="btn btn-success" type="submit" value="Update">
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @else
                                                        <input class="btn btn-success" type="submit" value="Update">
                                                    @endif
                                                </td>
                                                {{-- <td class="text-danger">28.76% <i class="mdi mdi-arrow-down"></i></td>
                                                <td><label class="badge badge-danger">Pending</label></td> --}}
                                                
                                                    <!-- Modal -->
                                                    {{-- <div class="modal fade" id="allActive{{ $search_data_admin->admin_id }}" tabindex="-1" role="dialog" aria-labelledby="allActive{{ $search_data_admin->admin_id }}Label" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="allActive{{ $search_data_admin->admin_id }}Label">Alert</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure to update user information?
                                                                    {{ $search_data_admin->admin_id }}
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
                
                
                @endif

                @if (session()->get('role_id') >= 3)

                <h4 class="mt-3 text-center mx-auto col-12 col-md-12 col-lg-12">Admin</h4>

                <div class="table-responsive mt-3">
                    <table id="filterTableAdmin" class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Whatsapp</th>
                                <th>User Code</th>
                                <th>Home Town</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Balance</th>
                                <th>Withdraws</th>
                                <th>Added By</th>
                                <th>Post</th>
                                <th>Status</th>
                                <th>Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($search_data_admins as $search_data_admin)
                            @if ($search_data_admin->email != 'pritomguha62@gmail.com')
                                @if ($search_data_admin->email != 'holy.it01@gmail.com')
                                    <form action="#" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $search_data_admin->name }}</td>
                                            <td><a href="tel:{{ $search_data_admin->phone }}">{{ $search_data_admin->phone }}</a></td>
                                            <td><a href="mailto:{{ $search_data_admin->email }}">{{ $search_data_admin->email }}</a></td>
                                            <td><a href="https://wa.me/{{ $search_data_admin->whatsapp }}">{{ $search_data_admin->whatsapp }}</a></td>
                                            <td>{{ $search_data_admin->user_code }}</td>
                                            <td>{{ $search_data_admin->home_town }}</td>
                                            <td>{{ $search_data_admin->city }}</td>
                                            <td>{{ $search_data_admin->country }}</td>
                                            <td>{{ $search_data_admin->balance }}</td>
                                            <td>{{ $search_data_admin->withdraws }}</td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($search_data_admin->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($search_data_admin->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($roles as $role)
                                                    @if ($search_data_admin->role_id == $role->role_id)
                                                        {{ $role->role_title }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                    @if ($search_data_admin->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                            </td>
                                            <td>
                                                {{-- @php
                                                    $create_date_time = explode(' ', $search_data_admin->created_at);
                                                @endphp
                                                <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                                <input type="time" value="{{ $create_date_time[1] }}" disabled> --}}
                                                {{ $search_data_admin->created_at }}
                                            </td>
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
                
                @endif

            @endif

            <br>
            <hr>
            <br>

            @if (!empty($search_data_members))

                @if (session()->get('role_id') <= 3)

                <h4 class="mt-3 text-center mx-auto col-12 col-md-12 col-lg-12">Member</h4>

                <div class="table-responsive mt-3">
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
                                <th>CP</th>
                                <th>Presenter</th>
                                <th>Balance</th>
                                <th>Added By</th>
                                <th>Status</th>
                                <th>Joined At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($search_data_members as $search_data_member)
                            @if ($search_data_member->email != 'pritomguha62@gmail.com')
                                @if ($search_data_member->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('update_all_members') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>
                                                <input type="text" name="name" value="{{ $search_data_member->name }}">
                                                <input type="hidden" hidden name="member_id" value="{{ $search_data_member->member_id }}">
                                                <input type="hidden" hidden name="search_type_member" value="1">
                                            </td>
                                            <td>
                                                {{-- <a href="tel:{{ $search_data_member->phone }}">{{ $search_data_member->phone }}</a> --}}
                                                <input type="text" name="phone" value="{{ $search_data_member->phone }}">
                                            </td>
                                            <td>
                                                {{-- <a href="mailto:{{ $search_data_member->email }}">{{ $search_data_member->email }}</a> --}}
                                                <input type="email" name="email" value="{{ $search_data_member->email }}">
                                            </td>
                                            <td>
                                                {{-- <a href="https://wa.me/{{ $search_data_member->whatsapp }}">{{ $search_data_member->whatsapp }}</a> --}}
                                                <input type="text" name="whatsapp" value="{{ $search_data_member->whatsapp }}">
                                            </td>
                                            <td>{{ $search_data_member->user_code }}</td>
                                            <td>
                                                <select name="seo_id">
                                                    @foreach ($all_seos as $seo)
                                                        @if ($search_data_member->seo_id == $seo->admin_id)
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
                                                        @if ($search_data_member->eo_id == $eo->admin_id)
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
                                                        @if ($search_data_member->executive_id == $executive->admin_id)
                                                            <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_executives as $executive)
                                                        <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="cp_id">
                                                    @foreach ($all_cps as $cp)
                                                        @if ($search_data_member->cp_id == $cp->admin_id)
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
                                                        @if ($search_data_member->presenter_id == $presenter->admin_id)
                                                            <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_presenters as $presenter)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="balance" disabled value="{{ $search_data_member->balance }}">
                                                <input type="text" name="add_balance" placeholder="Add Balance">
                                                <input type="text" name="deduct_balance" placeholder="Deduct Balance">
                                            </td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($search_data_member->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($search_data_member->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                                @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                                    <td>
                                                        <select name="status">
                                                            <option value="">Choose..</option>
                                                            {{-- @if ($search_data_member->status == '0')
                                                                <option value="0">Inactive</option>
                                                            @elseif ($search_data_member->status == '1')
                                                                <option value="1">Active</option>
                                                            @endif --}}
                                                            {{-- {{ $search_data_member->status }} --}}
                                                            <option value="0">Inactive</option>
                                                            <option value="1">Active</option>
                                                        </select>
                                                    </td>
                                                @endif
                                            <td>
                                                {{-- @php
                                                    $create_date_time = explode(' ', $search_data_member->created_at);
                                                @endphp
                                                <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                                <input type="time" value="{{ $create_date_time[1] }}" disabled> --}}
                                                {{ $search_data_member->created_at }}
                                            </td>
                                            <td>
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
                
                @endif

                @if (session()->get('role_id') >= 3)

                <h4 class="mt-3 text-center mx-auto col-12 col-md-12 col-lg-12">Member</h4>

                <div class="table-responsive mt-3">
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
                                @if (session()->get('role_id') <= 4)
                                    <th>SEO</th>
                                @endif
                                @if (session()->get('role_id') <= 5)
                                    <th>EO</th>
                                @endif
                                @if (session()->get('role_id') <= 6)
                                    <th>Executive</th>
                                @endif
                                <th>Balance</th>
                                <th>Added By</th>
                                <th>Status</th>
                                <th>Joined At</th>
                                <th>...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($search_data_members as $search_data_member)
                            @if ($search_data_member->email != 'pritomguha62@gmail.com')
                                @if ($search_data_member->email != 'holy.it01@gmail.com')
                                    <form action="#" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $search_data_member->name }}</td>
                                            <td><a href="tel:{{ $search_data_member->phone }}">{{ $search_data_member->phone }}</a></td>
                                            <td><a href="mailto:{{ $search_data_member->email }}">{{ $search_data_member->email }}</a></td>
                                            <td><a href="https://wa.me/{{ $search_data_member->whatsapp }}">{{ $search_data_member->whatsapp }}</a></td>
                                            <td>{{ $search_data_member->user_code }}</td>
                                            {{-- <td>
                                                <select name="director_id" id="" class="form-control">
                                                    @foreach ($all_directors as $director)
                                                        @if ($search_data_member->director_id == $director->admin_id)
                                                            <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                        @endif
                                                    @endforeach
                                                    @foreach ($all_directors as $director)
                                                        <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </td> --}}
                                            @if (session()->get('role_id') <= 4)
                                                <td>
                                                    @foreach ($all_seos as $seo)
                                                    @if ($search_data_member->seo_id == $seo->admin_id)
                                                        {{ $seo->name }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                            @endif
                                            @if (session()->get('role_id') <= 5)
                                                <td>
                                                    @foreach ($all_eos as $eo)
                                                    @if ($search_data_member->eo_id == $eo->admin_id)
                                                        {{ $eo->name }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                            @endif
                                            @if (session()->get('role_id') <= 6)
                                                <td>
                                                    @foreach ($all_executives as $executive)
                                                        @if ($search_data_member->executive_id == $executive->admin_id)
                                                            {{ $executive->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            @endif
                                            
                                            <td>{{ $search_data_member->balance }}</td>
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($search_data_member->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($search_data_member->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                    @if ($search_data_member->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                            </td>
                                            <td>
                                                {{-- @php
                                                    $create_date_time = explode(' ', $search_data_member->created_at);
                                                @endphp
                                                <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                                <input type="time" value="{{ $create_date_time[1] }}" disabled> --}}
                                                {{ $search_data_member->created_at }}
                                            </td>
                                            <td>
                                                {{-- <input type="hidden" hidden name="member_id" value="{{ $search_data_member->member_id }}">
                                                <input type="submit" class="btn btn-success" value="Update"> --}}
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
                
                @endif

            @endif



        </div>
    </div>
</div>



@endsection


