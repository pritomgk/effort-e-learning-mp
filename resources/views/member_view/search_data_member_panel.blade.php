@extends('member_view.layout.app') 
@section('title') 
Member - Search 
@endsection 
@section('content')

<div class="container-fluid mt--7">
    <!-- Table -->

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0 text-center">
                    <h3 class="mb-0">Search</h3>
                </div>
                {{-- <div class="card-header border-0 mb-2 mt-2">
                    <button type="button" class="btn btn-primary">Total : {{ $search_data_memberences->count() }}</button>
                    <button type="button" class="btn btn-success">Active : {{ $member_active_references->count() }}</button>
                    <button type="button" class="btn btn-warning">Inactive : {{ $member_inactive_references->count() }}</button>
                </div> --}}
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Whatsapp</th>
                                <th scope="col">User Code</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($search_data_members as $search_data_member)
                                @if ($search_data_member->email != 'pritomguha62@gmail.com')
                                    @if ($search_data_member->email != 'holy.it01@gmail.com')
                                        <tr>
                                            <td>
                                                <span class="mb-0 text-sm">{{ $sl }}</span>
                                            </td>
                                            <th scope="row">
                                                <div class="media align-items-center">
                                                    {{-- <a href="#" class="avatar rounded-circle mr-3">
                                                        <img alt="Image placeholder" src="{{ asset('storage/uploads/pro_pic/'.$search_data_member->pro_pic) }}" />
                                                    </a> --}}
                                                    <div class="media-body">
                                                        <span class="mb-0 text-sm">{{ $search_data_member->name }}</span>
                                                    </div>
                                                </div>
                                            </th>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->phone }}</span>
                                            </td>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->emai }}</span>
                                            </td>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->whatsapp }}</span>
                                            </td>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->user_code }}</span>
                                            </td>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->balance }}</span>
                                            </td>
                                            
                                            <td>
                                                <span class="mb-0 text-sm">{{ $search_data_member->created_at }}</span>
                                            </td>
                                        </tr>
                                        @php
                                            $sl++;
                                        @endphp
                                    @endif
                                @endif
                                
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{-- <nav aria-label="...">
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">
                                    <i class="fas fa-angle-left"></i>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <li class="page-item active">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="fas fa-angle-right"></i>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


