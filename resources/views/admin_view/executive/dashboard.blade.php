@extends('admin_view.layout.app')

@section('title')
    Admin - Dashboard
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-center flex-wrap mx-auto">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 me-xl-5 text-center">
                    <h2>Welcome to <span class="text-primary">Effort E-learning MP</span></h2>
                    {{-- <p class="mb-md-0">Your analytics dashboard template.</p> --}}
                </div>
                {{-- <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Analytics</p>
                </div> --}}
            </div>
            <div class="d-flex justify-content-between align-items-end flex-wrap">
                {{-- <button type="button" class="btn btn-light bg-white btn-icon me-3 d-none d-md-block">
                    <i class="mdi mdi-download text-muted"></i>
                </button>
                <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                </button>
                <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                </button>
                <button class="btn btn-primary mt-2 mt-xl-0">Download report</button> --}}
            </div>
        </div>
        <div class="d-flex justify-content-center flex-wrap mx-auto">
            <div class="d-flex align-items-end flex-wrap">
                <div class="me-md-3 mt-3 me-xl-5 text-center">
                    <h4><span class="text-info">{{ $admin->name }}</span></h4>
                    <p class="mb-md-0">
                        @foreach ($roles as $role)
                            @if ($admin->role_id == $role->role_id)
                                {{ $role->role_title }}
                            @endif
                        @endforeach
                    </p>
                    <p class="mb-md-0 text-success"><marquee behavior="" direction="right">-----------------------------------------------------</marquee></p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-end flex-wrap">
                {{-- <button type="button" class="btn btn-light bg-white btn-icon me-3 d-none d-md-block">
                    <i class="mdi mdi-download text-muted"></i>
                </button>
                <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                </button>
                <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                </button>
                <button class="btn btn-primary mt-2 mt-xl-0">Download report</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap" style="">
            <div style="height: 360px; background-color: #212529; width: 640px; background-position: center center; transition: all 0.7s ease; background-size: cover; margin: auto;" id="slide" class="mx-auto;">

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body dashboard-tabs p-0">
                {{-- <ul class="nav nav-tabs px-4 border-left-0 border-top-0 border-right-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="purchases-tab" data-bs-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
                    </li>
                </ul> --}}
                <div class="tab-content py-0 px-0 border-left-0 border-bottom-0 border-right-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                        <div class="d-flex flex-wrap justify-content-xl-between">
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-cash-multiple"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Revenue</small>
                                    <h5 class="me-2 mb-0">{{ $admin->balance }}</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-checkbox-blank-circle"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Active Members</small>
                                    <h5 class="me-2 mb-0">{{ $active_members->count() }}</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-checkbox-blank-circle-outline"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Inactive Members</small>
                                    <h5 class="me-2 mb-0">{{ $inactive_members->count() }}</h5>
                                </div>
                            </div>
                            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-format-list-checks"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Withdrawals</small>
                                    <h5 class="me-2 mb-0">{{ $admin->withdraws }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                        <div class="d-flex flex-wrap justify-content-xl-between">
                            <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-calendar-heart"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Start date</small>
                                    <div class="dropdown">
                                        <a
                                            class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium"
                                            href="#"
                                            role="button"
                                            id="dropdownMenuLinkB"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkB">
                                            <a class="dropdown-item" href="#">12 Aug 2018</a>
                                            <a class="dropdown-item" href="#">22 Sep 2018</a>
                                            <a class="dropdown-item" href="#">21 Oct 2018</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-currency-usd"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Revenue</small>
                                    <h5 class="me-2 mb-0">$577545</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-eye"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Total views</small>
                                    <h5 class="me-2 mb-0">9833550</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-download"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Downloads</small>
                                    <h5 class="me-2 mb-0">2233783</h5>
                                </div>
                            </div>
                            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-flag"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Flagged</small>
                                    <h5 class="me-2 mb-0">3497843</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="purchases" role="tabpanel" aria-labelledby="purchases-tab">
                        <div class="d-flex flex-wrap justify-content-xl-between">
                            <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-calendar-heart"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Start date</small>
                                    <div class="dropdown">
                                        <a
                                            class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium"
                                            href="#"
                                            role="button"
                                            id="dropdownMenuLinkC"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkC">
                                            <a class="dropdown-item" href="#">12 Aug 2018</a>
                                            <a class="dropdown-item" href="#">22 Sep 2018</a>
                                            <a class="dropdown-item" href="#">21 Oct 2018</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-currency-usd"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Revenue</small>
                                    <h5 class="me-2 mb-0">$577545</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-eye"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Total views</small>
                                    <h5 class="me-2 mb-0">9833550</h5>
                                </div>
                            </div>
                            <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-download"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Downloads</small>
                                    <h5 class="me-2 mb-0">2233783</h5>
                                </div>
                            </div>
                            <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                                <div class="icon-box-secondary me-3">
                                    <i class="mdi mdi-flag"></i>
                                </div>
                                <div class="d-flex flex-column justify-content-around">
                                    <small class="mb-1 text-muted">Flagged</small>
                                    <h5 class="me-2 mb-0">3497843</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



