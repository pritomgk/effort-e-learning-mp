<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Admin - Register</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('admin_assets/vendors/mdi/css/materialdesignicons.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('admin_assets/vendors/css/vendor.bundle.base.css') }}" />
        <!-- endinject -->
        <!-- plugin css for this page -->
        <link rel="stylesheet" href="{{ asset('admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}" />
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}" />
        <!-- endinject -->
        <link rel="shortcut icon" href="{{ asset('admin_assets/images/favicon.ico') }}" />
        <style>
            input{
                border: 1px solid rgb(0, 0, 0)!important;
            }

            select{
                border: 1px solid rgb(0, 0, 0)!important;
            }
            select option{
                color: rgba(0, 0, 0, 0.958);
            }
        </style>
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-8 mx-auto">
                            <div class="auth-form-light text-center py-5 px-4 px-sm-5">
                                <div class="brand-logo mx-auto">
                                    <div class="mx-auto" style="width: 70px; height: 70px;">
                                        <img style="width: 70px; height: 70px;" src="{{ asset('admin_assets/images/logo-white.png') }}" alt="logo" />
                                    </div>
                                </div>
                                <h4>New here?</h4>
                                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                                <form class="form-sample" action="{{ route('admin_register_info') }}" method="POST" enctype="multipart/form-data">

                                    @if (session()->has('error'))
                                      <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
                                    @endif
                                    @if (session()->has('success'))
                                      <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
                                    @endif
                    
                                    @csrf
                                    
                                    <p class="card-description">
                                        Personal info
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="name" placeholder="Holy IT" class="form-control" required />
                                                    @error('name')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Phone</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="phone" class="form-control" placeholder="+880" value="+880" required />
                                                    @error('phone')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="email" name="email" class="form-control" placeholder="hello@example.com" required />
                                                    @error('email')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Whatsapp</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="whatsapp" class="form-control" placeholder="+880" value="+880" required />
                                                    @error('whatsapp')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Gender</label>
                                                <div class="col-sm-9">
                                                    <select name="gender" class="form-select" required>
                                                        <option value="m">Male</option>
                                                        <option value="f">Female</option>
                                                        <option value="o">Other</option>
                                                    </select>
                                                    @error('gender')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Refer Code</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="parent_user_code" class="form-control" placeholder="240001" {{ !empty($_GET['refer']) ? "readonly value=".$_GET['refer'] : "required" }} />
                                                    @error('parent_user_code')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="card-description">
                                        Address
                                    </p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Home Town</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="home_town" placeholder="Dhaka" class="form-control" required />
                                                    @error('home_town')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">City</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="city" class="form-control" placeholder="Dhaka" required />
                                                    @error('city')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Country</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="country" placeholder="Bangladesh" class="form-control" required />
                                                    @error('country')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="password" class="form-control" placeholder="**********" required />
                                                    @error('password')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Confirm Password</label>
                                                <div class="col-sm-9">
                                                    <input type="password" name="confirm_password" class="form-control" placeholder="**********" required />
                                                    @error('confirm_password')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Job</label>
                                                <div class="col-sm-9">
                                                    <select name="role_id" id="" class="form-select" required>
                                                        <option value="">Choose..</option>
                                                        @foreach ($roles as $role)
                                                        <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role_id')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Profile Picture</label>
                                                <div class="col-sm-9">
                                                    <input type="file" class="form-control" name="pro_pic" id="pro_pic" />
                                                    @error('pro_pic')
                                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-sm-9 ml-auto">
                                                    <input class="custom-control-input" name="terms_condition" id="customCheckLogin" type="checkbox" required>
                                                    <label class="custom-control-label" for="customCheckLogin">
                                                        <span class="text-muted">I accept the <a href="{{ route('terms_condition') }}" target="_blank" rel="noopener noreferrer">Terms & Conditions</a></span>
                                                        @error('terms_condition')
                                                        <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                                        @enderror
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-sm-9 mx-auto">
                                                    <input type="submit" value="Register" class="btn btn-primary" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Already have an account? <a href="{{ route('admin_login') }}">Log in..!</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ asset('admin_assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- Plugin js for this page-->
        <script src="{{ asset('admin_assets/vendors/chart.js/chart.umd.js') }}"></script>
        <script src="{{ asset('admin_assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('admin_assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
        <!-- End plugin js for this page-->
        <!-- inject:js -->
        <script src="{{ asset('admin_assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('admin_assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('admin_assets/js/template.js') }}"></script>
        <script src="{{ asset('admin_assets/js/settings.js') }}"></script>
        <script src="{{ asset('admin_assets/js/todolist.js') }}"></script>
        <!-- endinject -->
        <!-- Custom js for this page-->
        <script src="{{ asset('admin_assets/js/dashboard.js') }}"></script>
        <script src="{{ asset('admin_assets/js/proBanner.js') }}"></script>

        <!-- End custom js for this page-->
        <script src="{{ asset('admin_assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
        <!-- endinject -->
    </body>
</html>


