@extends('admin_view.layout.app') 
@section('title') 
Admin - My Members
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
                <table class="table table-hover table-bordered table-striped">
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
                            @if (session()->get('role_id') <= 7)
                                <th>CP</th>
                            @endif
                            @if (session()->get('role_id') <= 8)
                                <th>Presenter</th>
                            @endif
                            @if (session()->get('role_id') <= 9)
                                <th>Head Teacher</th>
                            @endif
                            {{-- @if (session()->get('role_id') <= 10)
                                <th>Teacher</th>
                            @endif --}}
                            <th>Balance</th>
                            <th>Added By</th>
                            <th>Status</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($my_members as $my_member)
                        @if ($my_member->email != 'pritomguha62@gmail.com')
                            @if ($my_member->email != 'holy.it01@gmail.com')
                                <form action="#" method="POST">
                                    @csrf
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ $my_member->name }}</td>
                                        <td><a href="tel:{{ $my_member->phone }}">{{ $my_member->phone }}</a></td>
                                        <td><a href="mailto:{{ $my_member->email }}">{{ $my_member->email }}</a></td>
                                        <td><a href="https://wa.me/{{ $my_member->whatsapp }}">{{ $my_member->whatsapp }}</a></td>
                                        <td>{{ $my_member->user_code }}</td>
                                        {{-- <td>
                                            <select name="director_id" id="" class="form-control">
                                                @foreach ($all_directors as $director)
                                                    @if ($my_member->director_id == $director->admin_id)
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
                                                @if ($my_member->seo_id == $seo->admin_id)
                                                    {{ $seo->name }}
                                                @endif
                                                @endforeach
                                        </td>
                                        @endif
                                        @if (session()->get('role_id') <= 5)
                                            <td>
                                                @foreach ($all_eos as $eo)
                                                @if ($my_member->eo_id == $eo->admin_id)
                                                    {{ $eo->name }}
                                                @endif
                                                @endforeach
                                        </td>
                                        @endif
                                        @if (session()->get('role_id') <= 6)
                                            <td>
                                                @foreach ($all_executives as $executive)
                                                    @if ($my_member->executive_id == $executive->admin_id)
                                                        {{ $executive->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endif
                                        @if (session()->get('role_id') <= 7)
                                            <td>
                                                @foreach ($all_cps as $cp)
                                                    @if ($my_member->cp_id == $cp->admin_id)
                                                        {{ $cp->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endif
                                        @if (session()->get('role_id') <= 8)
                                            <td>
                                                @foreach ($all_presenters as $presenter)
                                                    @if ($my_member->presenter_id == $presenter->admin_id)
                                                        {{ $presenter->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endif
                                        @if (session()->get('role_id') <= 9)
                                            <td>
                                                @foreach ($all_head_teachers as $head_teacher)
                                                    @if ($my_member->head_teacher_id == $head_teacher->admin_id)
                                                        {{ $head_teacher->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        @endif
                                        
                                        <td>{{ $my_member->balance }}</td>
                                        <td>
                                            @foreach ($all_admins as $all_admin)
                                                @if ($my_member->parent_user_code == $all_admin->user_code)
                                                    {{ $all_admin->name }}
                                                @endif
                                            @endforeach
                                            @foreach ($all_members as $all_member)
                                                @if ($my_member->parent_user_code == $all_member->user_code)
                                                    {{ $all_member->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                            <td>
                                                    @if ($my_member->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                            </td>
                                        {{-- <td>
                                            <input type="hidden" hidden name="member_id" value="{{ $my_member->member_id }}">
                                            <input type="submit" class="btn btn-success" value="Update">
                                        </td> --}}
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


