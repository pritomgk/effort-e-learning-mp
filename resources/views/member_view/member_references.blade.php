@extends('member_view.layout.app') 
@section('title') 
Member - References 
@endsection 
@section('content')

<div class="container-fluid mt--7">
    <!-- Table -->

    <!-- Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header border-0 text-center">
                    <h3 class="mb-0">Reference History</h3>
                </div>
                <div class="card-header border-0 mb-2 mt-2">
                    <button type="button" class="btn btn-primary">Total : {{ $member_references->count() }}</button>
                    <button type="button" class="btn btn-success">Active : {{ $member_active_references->count() }}</button>
                    <button type="button" class="btn btn-warning">Inactive : {{ $member_inactive_references->count() }}</button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">User Code</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Whatsapp</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($member_references as $member_refer)
                                <tr>
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="{{ asset('storage/uploads/pro_pic/'.$member_refer->pro_pic) }}" />
                                            </a>
                                            <div class="media-body">
                                                <span class="mb-0 text-sm">{{ $member_refer->name }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    {{-- <td>
                                        <div class="avatar-group">
                                            <a href="#" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Ryan Tompson">
                                                <img alt="Image placeholder" src="../assets/img/theme/team-1-800x800.jpg" class="rounded-circle" />
                                            </a>
                                            <a href="#" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Romina Hadid">
                                                <img alt="Image placeholder" src="../assets/img/theme/team-2-800x800.jpg" class="rounded-circle" />
                                            </a>
                                            <a href="#" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Alexander Smith">
                                                <img alt="Image placeholder" src="../assets/img/theme/team-3-800x800.jpg" class="rounded-circle" />
                                            </a>
                                            <a href="#" class="avatar avatar-sm" data-toggle="tooltip" data-original-title="Jessica Doe">
                                                <img alt="Image placeholder" src="../assets/img/theme/team-4-800x800.jpg" class="rounded-circle" />
                                            </a>
                                        </div>
                                    </td> --}}
                                    
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_refer->user_code }}</span>
                                    </td>
                                    <td>
                                        <a href="tel:{{ $member_refer->phone }}"><span class="mb-0 text-sm">{{ $member_refer->phone }}</span></a>
                                    </td>
                                    <td>
                                        <a href="https://wa.me/{{ $member_refer->whatsapp }}"><span class="mb-0 text-sm">{{ $member_refer->whatsapp }}</span></a>
                                    </td>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_refer->parent_user_code }}</span>
                                    </td>
                                    {{-- <td>
                                        <div class="d-flex align-items-center">
                                            <span class="mr-2">60%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td> --}}
                                    {{-- <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </td> --}}
                                    <td>
                                        @if ($member_refer->status == 1)
                                            <span class="badge badge-dot mr-4"> <i class="bg-success"></i> Active </span>
                                            @else
                                            <span class="badge badge-dot mr-4"> <i class="bg-warning"></i> Inactive </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="mb-0 text-sm">{{ $member_refer->created_at }}</span>
                                    </td>
                                </tr>
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
