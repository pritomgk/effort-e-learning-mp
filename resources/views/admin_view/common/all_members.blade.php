@extends('admin_view.layout.app') 
@section('title') 
Admin - All Members
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
                            <th>Status</th>
                            <th>Joined At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($all_members as $all_member)
                        @if ($all_member->email != 'pritomguha62@gmail.com')
                            @if ($all_member->email != 'holy.it01@gmail.com')
                                <form action="{{ route('update_all_members') }}" method="POST">
                                    @csrf
                                    <tr>
                                        <td>{{ $sl }}</td>
                                        <td>
                                            <input type="text" name="name" value="{{ $all_member->name }}">
                                            <input type="hidden" hidden name="member_id" value="{{ $all_member->member_id }}">
                                        </td>
                                        <td>
                                            {{-- <a href="tel:{{ $all_member->phone }}">{{ $all_member->phone }}</a> --}}
                                            <input type="text" name="phone" value="{{ $all_member->phone }}">
                                        </td>
                                        <td>
                                            {{-- <a href="mailto:{{ $all_member->email }}">{{ $all_member->email }}</a> --}}
                                            <input type="email" name="email" value="{{ $all_member->email }}">
                                        </td>
                                        <td>
                                            {{-- <a href="https://wa.me/{{ $all_member->whatsapp }}">{{ $all_member->whatsapp }}</a> --}}
                                            <input type="text" name="whatsapp" value="{{ $all_member->whatsapp }}">
                                        </td>
                                        <td>{{ $all_member->user_code }}</td>
                                        {{-- <td>
                                            <select name="director_id">
                                                @foreach ($all_directors as $director)
                                                    @if ($all_member->director_id == $director->admin_id)
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
                                                    @if ($all_member->seo_id == $seo->admin_id)
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
                                                    @if ($all_member->eo_id == $eo->admin_id)
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
                                                    @if ($all_member->executive_id == $executive->admin_id)
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
                                                    @if ($all_member->cp_id == $cp->admin_id)
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
                                                    @if ($all_member->presenter_id == $presenter->admin_id)
                                                        <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                    @endif
                                                @endforeach
                                                @foreach ($all_presenters as $presenter)
                                                    <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="balance" disabled value="{{ $all_member->balance }}">
                                            <input type="text" name="add_balance" placeholder="Add Balance">
                                            <input type="text" name="deduct_balance" placeholder="Deduct Balance">
                                        </td>
                                        <td>
                                            @foreach ($all_admins as $all_admin)
                                                @if ($all_member->parent_user_code == $all_admin->user_code)
                                                    {{ $all_admin->name }}
                                                @endif
                                            @endforeach
                                            @foreach ($all_members as $all_member)
                                                @if ($all_member->parent_user_code == $all_member->user_code)
                                                    {{ $all_member->name }}
                                                @endif
                                            @endforeach
                                        </td>
                                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                                <td>
                                                    <select name="status">
                                                        <option value="">Choose..</option>
                                                        {{-- @if ($all_member->status == '0')
                                                            <option value="0">Inactive</option>
                                                        @elseif ($all_member->status == '1')
                                                            <option value="1">Active</option>
                                                        @endif --}}
                                                        {{-- {{ $all_member->status }} --}}
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </td>
                                            @endif
                                        <td>
                                            @php
                                                $create_date_time = explode(' ', $all_member->created_at);
                                            @endphp
                                            <input type="date" value="{{ $create_date_time[0] }}" disabled>
                                            <input type="time" value="{{ $create_date_time[1] }}" disabled>
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
            
        </div>
    </div>
</div>

@endsection


