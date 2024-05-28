@extends('admin_view.layout.app') 
@section('title') 
Admin - SEO Approvals 
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
                            <th>EO</th>
                            <th>Executive</th>
                            <th>CP</th>
                            <th>Presenter</th>
                            <th>Balance</th>
                            <th>Added By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($seo_approvals as $seo_approval)
                        <form action="{{ route('seo_approval_update') }}" method="POST">
                            @csrf
                            <tr>
                                <td>{{ $seo_approval->name }}</td>
                                <td><a href="tel:{{ $seo_approval->phone }}">{{ $seo_approval->phone }}</a></td>
                                <td><a href="mailto:{{ $seo_approval->email }}">{{ $seo_approval->email }}</a></td>
                                <td><a href="{{ $seo_approval->whatsapp }}">{{ $seo_approval->whatsapp }}</a></td>
                                <td>
                                    <select name="eo_id" id="" class="form-control">
                                        <option value="">Choose..</option>
                                        @foreach ($all_eos as $eo)
                                            <option value="{{ $eo->admin_id }}">{{ $eo->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="executive_id" id="" class="form-control">
                                        <option value="">Choose..</option>
                                        @foreach ($all_executives as $executive)
                                            <option value="{{ $executive->admin_id }}">{{ $executive->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="cp_id" id="" class="form-control">
                                        <option value="">Choose..</option>
                                        @foreach ($all_cps as $cp)
                                            <option value="{{ $cp->admin_id }}">{{ $cp->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="presenter_id" id="" class="form-control">
                                        <option value="">Choose..</option>
                                        @foreach ($all_presenters as $presenter)
                                            <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{ $seo_approval->balance }}</td>
                                <td>
                                    @foreach ($all_admins as $all_admin)
                                        @if ($seo_approval->parent_user_code == $all_admin->user_code)
                                            {{ $all_admin->name }}
                                        @endif
                                    @endforeach
                                    @foreach ($all_members as $all_member)
                                        @if ($seo_approval->parent_user_code == $all_member->user_code)
                                            {{ $all_member->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <select name="status" id="" class="form-control">
                                        @if ($seo_approval->status == 1)
                                            <option value="1">Active</option>
                                        @else
                                        <option value="1">Inactive</option>
                                        @endif
                                        <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" hidden name="member_id" value="{{ $seo_approval->member_id }}">
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


