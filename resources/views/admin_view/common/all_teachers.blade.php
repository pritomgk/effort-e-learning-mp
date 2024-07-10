@extends('admin_view.layout.app') 
@section('title') 
Admin - All Teacher
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
                <table id="filterTableAdmin" class="table table-hover">
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
                            <th>Status</th>
                            <th>Joined At</th>
                            <th>...</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($all_teachers as $all_teacher)
                        @if ($all_teacher->email != 'pritomguha62@gmail.com')
                            @if ($all_teacher->email != 'holy.it01@gmail.com')
                                    <form action="" method="POST">
                                        @csrf
                                        <tr>
                                            <td>{{ $sl }}</td>
                                            <td>{{ $all_teacher->name }}</td>
                                            <td><a href="tel:{{ $all_teacher->phone }}">{{ $all_teacher->phone }}</a></td>
                                            <td><a href="mailto:{{ $all_teacher->email }}">{{ $all_teacher->email }}</a></td>
                                            <td><a href="{{ $all_teacher->whatsapp }}">{{ $all_teacher->whatsapp }}</a></td>
                                            <td>{{ $all_teacher->user_code }}</td>
                                            <td>
                                                @if ($all_teacher->gender == 'm')
                                                    Male
                                                @elseif ($all_teacher->gender == 'f')
                                                    Female
                                                    @else
                                                    Other
                                                @endif
                                            </td>
                                            <td>{{ $all_teacher->home_town }}</td>
                                            <td>{{ $all_teacher->city }}</td>
                                            <td>{{ $all_teacher->country }}</td>
                                            <td>
                                                @if ($all_teacher->status == 1)
                                                    Active
                                                    @else
                                                    Inactive
                                                @endif
                                            </td>
                                            <td>{{ $all_teacher->created_at }}</td>
                                            <td>...</td>
                                            {{-- <td>
                                                <input type="hidden" hidden name="admin_id" value="{{ $all_teacher->admin_id }}">
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


{{--                 
<script>
    $(document).ready(function() {
        $('#filterButton').click(function() {
            var startTimestamp = $('#startTimestamp').val();
            var endTimestamp = $('#endTimestamp').val();

            $('#filterTableAdmin tbody tr').each(function() {
                var rowTimestamp = $(this).find('td:nth-last-child(2)').text();

                if (isWithinRange(rowTimestamp, startTimestamp, endTimestamp)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        function isWithinRange(timestamp, start, end) {
            var timestampDate = new Date(timestamp);
            var startDate = new Date(start);
            var endDate = new Date(end);

            return (timestampDate >= startDate && timestampDate <= endDate);
        }
        
    });
    
    $(document).ready(function() {
        $('#filterButton').click(function() {
            var startTimestamp = $('#startTimestamp').val();
            var endTimestamp = $('#endTimestamp').val();

            $('#filterTableMember tbody tr').each(function() {
                var rowTimestamp = $(this).find('td:nth-last-child(2)').text();

                if (isWithinRange(rowTimestamp, startTimestamp, endTimestamp)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        function isWithinRange(timestamp, start, end) {
            var timestampDate = new Date(timestamp);
            var startDate = new Date(start);
            var endDate = new Date(end);

            return (timestampDate >= startDate && timestampDate <= endDate);
        }
    })
</script> --}}



@endsection


