@extends('admin_view.layout.app') 
@section('title') 
Admin - Profile
@endsection 

@section('content')

<div class="col-md-10 mx-auto">
    <form class="form-sample" action="#" method="POST" enctype="multipart/form-data">

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
                        <input type="text" name="name" placeholder="Holy IT" class="form-control" required value="{{ $admin_profile->name }}" />
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
                        <input type="text" name="phone" class="form-control" placeholder="+880" value="+880" required value="{{ $admin_profile->phone }}" />
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
                        <input type="email" name="email" class="form-control" placeholder="hello@example.com" required value="{{ $admin_profile->email }}" />
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
                        <input type="text" name="whatsapp" class="form-control" placeholder="+880" value="+880" required value="{{ $admin_profile->whatsapp }}" />
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
                            <option selected value="{{ $admin_profile->gender }}">
                                @if ($admin_profile->gender == 'm')
                                    Male
                                @elseif ($admin_profile->gender == 'f')
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
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Join Refer Code</label>
                    <div class="col-sm-9">
                        <input type="text" name="parent_user_code" class="form-control" placeholder="240001" readonly  value="{{ $admin_profile->parent_user_code }}" />
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
                        <input type="text" name="home_town" placeholder="Dhaka" class="form-control" required value="{{ $admin_profile->home_town }}" />
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
                        <input type="text" name="city" class="form-control" placeholder="Dhaka" required value="{{ $admin_profile->city }}" />
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
                        <input type="text" name="country" placeholder="Bangladesh" class="form-control" required value="{{ $admin_profile->country }}" />
                        @error('country')
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
                            @foreach ($roles as $role)
                            @if ($role->role_id == $admin_profile->role_id)
                                <option value="{{ $admin_profile->role_id }}">{{ $role->role_title }}</option>
                            @else
                                <option value="{{ $role->role_id }}">{{ $role->role_title }}</option>
                            @endif
                            
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
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Refer Code</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control" id="user_code" value="{{ $admin_profile->user_code }}">
                        <button type="button" class="btn btn-warning" value="copy" onclick="copyClipboardFunction()">Copy!</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Share</label>
                    <div class="col-sm-9">
                        <a class="btn btn-warning" href="whatsapp://send?text={{ route('admin_register').'?refer='.$admin_profile->user_code }}" data-action="share/whatsapp/share">Admin Share <i class="mdi mdi-share"></i></a>
                        <a class="btn btn-warning" href="whatsapp://send?text={{ route('member.register').'?refer='.$admin_profile->user_code }}" data-action="share/whatsapp/share">Member Share <i class="mdi mdi-share"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-sm-9 mx-auto text-center">
                        <input type="submit" value="Update" class="btn btn-primary" />
                    </div>
                </div>
            </div>
        </div>
    </form>
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


