
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Register - Member
  </title>
  <!-- Favicon -->
  <link href="{{ asset('member_assets/img/brand/favicon.ico') }}" rel="icon" type="image/ico">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{ asset('member_assets/js/plugins/nucleo/css/nucleo.css') }}" rel="stylesheet" />
  <link href="{{ asset('member_assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{ asset('member_assets/css/argon-dashboard.css?v=1.1.2') }}" rel="stylesheet" />
</head>

<body class="bg-default">
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
      <div class="container px-4">
        <a class="navbar-brand" href="{{ route('home') }}">
          <img height="70px;" width="70px;" src="{{ asset('member_assets/img/brand/logo-white.png') }}" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
          <!-- Collapse header -->
          <div class="navbar-collapse-header d-md-none">
            <div class="row">
              <div class="col-6 collapse-brand">
                <a href="../index.html">
                  <img src="{{ asset('member_assets/img/brand/logo-white.png') }}">
                </a>
              </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
            </div>
          </div>
          <!-- Navbar items -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="{{ route('member.dashboard') }}">
                <i class="ni ni-planet"></i>
                <span class="nav-link-inner--text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="{{ route('member.register') }}">
                <i class="ni ni-circle-08"></i>
                <span class="nav-link-inner--text">Register</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="{{ route('member.login') }}">
                <i class="ni ni-key-25"></i>
                <span class="nav-link-inner--text">Login</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="{{ route('member_profile') }}">
                <i class="ni ni-single-02"></i>
                <span class="nav-link-inner--text">Profile</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-3">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h2 class="text-white">Welcome!</h2>
              <p class="text-lead text-light">Create new account..</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-3">
              <div class="text-muted text-center mt-2 mb-2"><small>Sign up with</small></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <form method="POST" enctype="multipart/form-data" action="{{ route('member.register_info') }}">

                @if (session()->has('error'))
                  <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
                @endif
                @if (session()->has('success'))
                  <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
                @endif

                @csrf
                
                <h6 class="heading-small text-muted mb-4">User information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-name">Name</label>
                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Holy IT" required>
												@error('name')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-phone">Phone</label>
                        <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative" placeholder="Phone" value="+880" required>
												@error('phone')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-email">Email address</label>
                        <input type="email" name="email" id="input-email" class="form-control form-control-alternative" placeholder="jesse@example.com" required>
												@error('email')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-whatsapp">Whatsapp</label>
                        <input type="text" name="whatsapp" id="input-whatsapp" class="form-control form-control-alternative" placeholder="Whatsapp" value="+880" required>
												@error('whatsapp')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-gender">Gender</label>
                        <Select id="input-gender" name="gender" class="form-control form-control-alternative" required>
                          <option value="">Choose..</option>
                          <option value="m">Male</option>
                          <option value="f">Female</option>
                          <option value="o">Other</option>
                        </Select>
												@error('gender')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-refer">Refer</label>
                        <input type="text" name="parent_user_code" id="input-refer" class="form-control form-control-alternative" placeholder="refer" {{ !empty($_GET['refer']) ? "readonly value=".$_GET['refer'] : "required" }}>
												@error('parent_user_code')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                  </div>
                </div>
                <hr class="my-4" />
                <!-- Address -->
                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                <div class="pl-lg-4">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-home_town">Home Town</label>
                        <input type="text" name="home_town" id="input-home_town" class="form-control form-control-alternative" placeholder="Dhaka" required>
												@error('home_town')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-city">City</label>
                        <input type="text" name="city" id="input-city" class="form-control form-control-alternative" placeholder="Dhaka" required>
												@error('city')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Country</label>
                        <input type="text" name="country" id="input-country" class="form-control form-control-alternative" placeholder="Bangladesh" required>
												@error('country')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    {{-- <div class="col-lg-4">
                      <div class="form-group">
                        <label class="form-control-label" for="input-country">Postal code</label>
                        <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code">
                      </div>
                    </div> --}}
                  </div>
                  
                  
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-password">Password</label>
                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative" placeholder="Password" required>
												@error('password')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label class="form-control-label" for="input-confirm-password">Confirm Password</label>
                        <input type="password" name="confirm_password" id="input-confirm-password" class="form-control form-control-alternative" placeholder="Confirm Password" required>
												@error('confirm_password')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    {{-- <div class="col-lg-6">
                      <div class="form-group">
                        <label for="input-course" class="form-control-label">Course</label>
                        <select name="course_id" id="input-course" class="form-control form-control-alternative">
                          <option value="">Choose..</option>
                          @foreach ($courses as $course)
                          <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div> --}}
                    <div class="col-lg-12">
                      <div class="form-group">
                        <label class="form-control-label" for="input-pro-pic">Profile Picture</label>
                        <input type="file" name="pro_pic" id="input-pro-pic" class="form-control form-control-alternative">
												@error('pro_pic')
												<p class="mb-0 alert alert-danger">{{ $message }}</p>
												@enderror
                      </div>
                    </div>
                    
                  </div>

                  <div class="row">
                    <div class="col-lg-12">
                      <div class="custom-control custom-control-alternative custom-checkbox">
                        <input class="custom-control-input" name="terms_condition" id="customCheckLogin" type="checkbox">
                          <label class="custom-control-label" for="customCheckLogin">
                          <span class="text-muted">I accept the <a href="{{ route('terms_condition') }}" target="_blank" rel="noopener noreferrer">Terms & Conditions</a></span>
                          @error('terms_condition')
                          <p class="mb-0 alert alert-danger">{{ $message }}</p>
                          @enderror
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-12 my-3">
                      <div class="form-group text-center">
                        <input type="submit" class="btn btn-success" value="Register">
                      </div>
                    </div>
                  </div>

                </div>
                {{-- <hr class="my-4" /> --}}
                <!-- Description -->
                {{-- <h6 class="heading-small text-muted mb-4">About me</h6>
                <div class="pl-lg-4">
                  <div class="form-group">
                    <label>About Me</label>
                    <textarea rows="4" class="form-control form-control-alternative" placeholder="A few words about you ...">A beautiful Dashboard for Bootstrap 4. It is Free and Open Source.</textarea>
                  </div>
                </div> --}}
              </form>
            </div>
            
            @if (!empty(session()->get('country')))
              
              <!-- Modal -->
              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Your account information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Name : {{session()->get('name')}} <br>
                            User Code : {{session()->get('user_code')}} <br>
                            Phone : {{session()->get('phone')}} <br>
                            Email : {{session()->get('email')}} <br>
                            Whatsapp : {{session()->get('whatsapp')}} <br>
                            Country : {{session()->get('country')}} <br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
              </div>
              
            @endif
            

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            © {{ date('Y') }} <a href="{{ route('home') }}" class="font-weight-bold ml-1" target="_blank">Effort E-learning MP</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="{{ route('home') }}" class="nav-link" target="_blank">Effort E-learning MP</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('home') }}#about" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="{{ route('home') }}#contact" class="nav-link" target="_blank">Contact Us</a>
            </li>
            {{-- <li class="nav-item">
              <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
            </li> --}}
          </ul>
        </div>
      </div>
    </div>
  </footer>
  </div>
  <!--   Core   -->
  <script src="{{ asset('member_assets/js/plugins/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('member_assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <!--   Optional JS   -->
  <script src="{{ asset('member_assets/js/plugins/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('member_assets/js/plugins/chart.js/dist/Chart.extension.js') }}"></script>
  <!--   Argon JS   -->
  <script src="{{ asset('member_assets/js/argon-dashboard.min.js?v=1.1.2') }}"></script>
  <script src="{{ asset('member_assets/js/t.js') }}"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>
    
  <!-- JavaScript to auto show modal on page load -->
  <script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
  </script>

</body>

</html>


