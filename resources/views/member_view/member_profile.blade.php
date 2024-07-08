@extends('member_view.layout.app') 
@section('title') 
Member - Profile 
@endsection 
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12 col-md-12">
        <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-3">
                {{-- <div class="text-muted text-center mt-2 mb-2"><small>Sign up with</small></div> --}}
            </div>
            <div class="card-body px-lg-5 py-lg-5">
                <form method="POST" enctype="multipart/form-data" action="#">
                    @if (session()->has('error'))
                    <p class="mb-0 alert alert-danger">{{ session()->get('error') }}</p>
                    @endif @if (session()->has('success'))
                    <p class="mb-0 alert alert-success">{{ session()->get('success') }}</p>
                    @endif @csrf

                    <h6 class="heading-small text-muted mb-4">User information</h6>
                    <div class="pl-lg-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">Name</label>
                                    <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Holy IT" required readonly value="{{ $member_profile->name }}" />
                                    @error('name')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-phone">Phone</label>
                                    <input type="text" name="phone" id="input-phone" class="form-control form-control-alternative" placeholder="Phone" required readonly value="{{ $member_profile->phone }}" />
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
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative" placeholder="jesse@example.com" required readonly value="{{ $member_profile->email }}" />
                                    @error('email')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-whatsapp">Whatsapp</label>
                                    <input type="text" name="whatsapp" id="input-whatsapp" class="form-control form-control-alternative" placeholder="Whatsapp" required readonly value="{{ $member_profile->whatsapp }}" />
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
                                    <select id="input-gender" name="gender" class="form-control form-control-alternative" required>
                                        <option selected value="{{ $member_profile->gender }}">
                                            @if ($member_profile->gender == 'm')
                                                Male
                                            @elseif ($member_profile->gender == 'f')
                                                Female
                                            @else
                                                Other
                                            @endif
                                        </option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                        <option value="o">Other</option>
                                    </select>
                                    @error('gender')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-refer">Parent User Code</label>
                                    <input type="text" name="parent_user_code" id="input-refer" class="form-control form-control-alternative" placeholder="refer" required readonly value="{{ $member_profile->parent_user_code }}">
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
                                    <input type="text" name="home_town" id="input-home_town" class="form-control form-control-alternative" placeholder="Dhaka" required readonly value="{{ $member_profile->home_town }}" />
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
                                    <input type="text" name="city" id="input-city" class="form-control form-control-alternative" placeholder="Dhaka" required readonly value="{{ $member_profile->city }}" />
                                    @error('city')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">Country</label>
                                    <input type="text" name="country" id="input-country" class="form-control form-control-alternative" placeholder="Bangladesh" required readonly value="{{ $member_profile->country }}" />
                                    @error('country')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            {{--
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">Postal code</label>
                                    <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code" />
                                </div>
                            </div>
                            --}}
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-city">Refer Code</label>
                                    <input type="text" readonly class="form-control" id="user_code" value="{{ $member_profile->user_code }}">
                                    <button type="button" class="btn btn-warning" value="copy" onclick="copyClipboardFunction()">Copy!</button>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-share">Share</label>
                                    <a class="btn btn-warning" href="whatsapp://send?text={{ route('member.register').'?refer='.$member_profile->user_code }}" data-action="share/whatsapp/share">Member Share <i class="ni ni-curved-next"></i></a>
                                </div>
                            </div>
                            {{--
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-country">Postal code</label>
                                    <input type="number" id="input-postal-code" class="form-control form-control-alternative" placeholder="Postal code" />
                                </div>
                            </div>
                            --}}
                        </div>

                        {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">Password</label>
                                    <input type="password" name="password" id="input-password" class="form-control form-control-alternative" placeholder="Password" required />
                                    @error('password')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-confirm-password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="input-confirm-password" class="form-control form-control-alternative" placeholder="Confirm Password" required />
                                    @error('confirm_password')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            {{--
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="input-course" class="form-control-label">Course</label>
                                    <select name="course_id" id="input-course" class="form-control form-control-alternative">
                                        <option value="">Choose..</option>
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->course_id }}">{{ $course->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-pro-pic">Profile Picture</label>
                                    <input type="file" name="pro_pic" id="input-pro-pic" class="form-control form-control-alternative" />
                                    @error('pro_pic')
                                    <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-lg-12">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" name="terms_condition" id="customCheckLogin" type="checkbox" />
                                    <label class="custom-control-label" for="customCheckLogin">
                                        <span class="text-muted">I accept the <a href="{{ route('terms_condition') }}" target="_blank" rel="noopener noreferrer">Terms & Conditions</a></span>
                                        @error('terms_condition')
                                        <p class="mb-0 alert alert-danger">{{ $message }}</p>
                                        @enderror
                                    </label>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-lg-12 my-3">
                                <div class="form-group text-center">
                                    {{-- <input type="submit" class="btn btn-success" value="Update" /> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    function copyClipboardFunction() {
    // Get the text field
    var copyText = document.getElementById("user_code");

    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    // Alert the copied text
    alert("Copied the text: " + copyText.value);
    }
</script>

@endsection


