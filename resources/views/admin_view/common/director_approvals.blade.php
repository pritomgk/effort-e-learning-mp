@extends('admin_view.layout.app') 
@section('title') 
Admin - Director Approvals 
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
                            <th>SEO</th>
                            <th>EO</th>
                            <th>Executive</th>
                            {{-- <th>CP</th>
                            <th>Presenter</th> --}}
                            {{-- <th>Balance</th> --}}
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($director_approvals as $director_approval)
                        
                            @if ($director_approval->email != 'pritomguha62@gmail.com')
                                @if ($director_approval->email != 'holy.it01@gmail.com')
                                    <form action="{{ route('director_approval_update') }}" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $director_approval->name }}</td>
                                            <td><a href="tel:{{ $director_approval->phone }}">{{ $director_approval->phone }}</a></td>
                                            <td><a href="mailto:{{ $director_approval->email }}">{{ $director_approval->email }}</a></td>
                                            <td><a href="https://wa.me/{{ $director_approval->whatsapp }}">{{ $director_approval->whatsapp }}</a></td>
                                            <td>
                                                <select name="seo_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($all_seos as $seo)
                                                        <option value="{{ $seo->admin_id }}">{{ $seo->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="eo_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($all_eos as $eo)
                                                        <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select name="executive_id">
                                                    <option value="">Choose..</option>
                                                    @foreach ($all_executives as $executive)
                                                        <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            {{-- <td>
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
                                            </td> --}}
                                            {{-- <td>{{ $director_approval->balance }}</td> --}}
                                            <td>
                                                @foreach ($all_admins as $all_admin)
                                                    @if ($director_approval->parent_user_code == $all_admin->user_code)
                                                        {{ $all_admin->name }}
                                                    @endif
                                                @endforeach
                                                @foreach ($all_members as $all_member)
                                                    @if ($director_approval->parent_user_code == $all_member->user_code)
                                                        {{ $all_member->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <select name="status">
                                                    @if ($director_approval->status == 1)
                                                        <option value="1">Active</option>
                                                    @else
                                                    <option value="0">Inactive</option>
                                                    @endif
                                                    <option value="0">Inactive</option>
                                                    <option value="1">Active</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="hidden" hidden name="member_id" value="{{ $director_approval->member_id }}">
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


