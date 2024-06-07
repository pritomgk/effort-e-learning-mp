@extends('admin_view.layout.app') 
@section('title') 
Admin - Active Members
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
                            <th>SEO</th>
                            <th>EO</th>
                            <th>Executive</th>
                            <th>CP</th>
                            <th>Presenter</th>
                            <th>Balance</th>
                            <th>Added By</th>
                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                <th>Status</th>
                            @endif
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($active_members as $active_member)
                        @if ($active_member->email != 'pritomguha62@gmail.com')
                            @if ($active_member->email != 'holy.it01@gmail.com')
                                <form action="{{ route('active_members_update') }}" method="POST">
                                    @csrf
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>{{ $active_member->name }}</td>
                                        <td><a href="tel:{{ $active_member->phone }}">{{ $active_member->phone }}</a></td>
                                        <td><a href="mailto:{{ $active_member->email }}">{{ $active_member->email }}</a></td>
                                        <td><a href="https://wa.me/{{ $active_member->whatsapp }}">{{ $active_member->whatsapp }}</a></td>
                                        <td>{{ $active_member->user_code }}</td>
                                        {{-- <td>
                                            <select name="director_id" id="" class="form-control">
                                                @foreach ($all_directors as $director)
                                                    @if ($active_member->director_id == $director->admin_id)
                                                        <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                    @endif
                                                @endforeach
                                                @foreach ($all_directors as $director)
                                                    <option value="{{ $director->admin_id }}">{{ $director->name }}</option>
                                                @endforeach
                                                
                                            </select>
                                        </td> --}}
                                        <td>
                                            <select name="seo_id" id="" class="form-control">
                                                @foreach ($all_seos as $seo)
                                                @if ($active_member->seo_id == $seo->admin_id)
                                                    <option value="{{ $seo->admin_id }}">{{ $seo->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_seos as $seo)
                                                    <option value="{{ $seo->admin_id }}">{{ $seo->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="eo_id" id="" class="form-control">
                                                @foreach ($all_eos as $eo)
                                                @if ($active_member->eo_id == $eo->admin_id)
                                                    <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_eos as $eo)
                                                    <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="executive_id" id="" class="form-control">
                                                @foreach ($all_executives as $executive)
                                                @if ($active_member->executive_id == $executive->admin_id)
                                                    <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_executives as $executive)
                                                    <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="cp_id" id="" class="form-control">
                                                @foreach ($all_cps as $cp)
                                                @if ($active_member->cp_id == $cp->admin_id)
                                                    <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_cps as $cp)
                                                    <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="presenter_id" id="" class="form-control">
                                                @foreach ($all_presenters as $presenter)
                                                @if ($active_member->presenter_id == $presenter->admin_id)
                                                    <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_presenters as $presenter)
                                                    <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{ $active_member->balance }}</td>
                                        <td>
                                            @foreach ($all_admins as $all_admin)
                                                @if ($active_member->parent_user_code == $all_admin->user_code)
                                                    {{ $all_admin->name }}
                                                @endif
                                            @endforeach
                                            @foreach ($all_members as $all_member)
                                                @if ($active_member->parent_user_code == $all_member->user_code)
                                                    {{ $all_member->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                                <td>
                                                    <select name="status" id="" class="form-control">
                                                        @if ($active_member->status == 1)
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
                                            <input type="hidden" hidden name="member_id" value="{{ $active_member->member_id }}">
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


