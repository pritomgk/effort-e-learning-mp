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
                                        {{-- <td>
                                            <select name="director_id">
                                                @foreach ($all_directors as $director)
                                                    @if ($todays_lead->director_id == $director->admin_id)
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
                                                @if ($todays_lead->seo_id == $seo->admin_id)
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
                                                @if ($todays_lead->eo_id == $eo->admin_id)
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
                                                @if ($todays_lead->executive_id == $executive->admin_id)
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
                                                @if ($todays_lead->cp_id == $cp->admin_id)
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
                                                @if ($todays_lead->presenter_id == $presenter->admin_id)
                                                    <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                @endif
                                                @endforeach
                                                @foreach ($all_presenters as $presenter)
                                                    <option value="{{ $presenter->admin_id }}">{{ $presenter->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        @endif
                                        

                                        <td>{{ $todays_lead->balance }}</td>
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
                                            @if (session()->get('role_id') == 1 or session()->get('role_id') == 2)
                                                <td>
                                                    <select name="status">
                                                        @if ($todays_lead->status == 1)
                                                            <option value="1">Active</option>
                                                        @else
                                                        <option value="0">Inactive</option>
                                                        @endif
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </td>
                                            @endif
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


                
<script>
    
    // $(document).ready(function() {
    //     $('#filterButton').click(function() {
    //         var startTimestamp = $('#startTimestamp').val();
    //         var endTimestamp = $('#endTimestamp').val();

    //         $('#filterTableActiveMember tbody tr').each(function() {
    //             var rowTimestamp = $(this).find('td:nth-last-child(2)').text();

    //             if (isWithinRange(rowTimestamp, startTimestamp, endTimestamp)) {
    //                 $(this).show();
    //             } else {
    //                 $(this).hide();
    //             }
    //         });
    //     });

    //     function isWithinRange(timestamp, start, end) {
    //         var timestampDate = new Date(timestamp);
    //         var startDate = new Date(start);
    //         var endDate = new Date(end);

    //         return (timestampDate >= startDate && timestampDate <= endDate);
    //     }
    // });

</script>



@endsection


