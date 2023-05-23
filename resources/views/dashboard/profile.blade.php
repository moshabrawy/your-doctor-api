@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-face-profile"></i>
        </span> Profile
    </h3>
</div>
@auth('admin')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar">
                    @if (auth('admin')->user()->avatar != null)
                    <div class="nav_profile_img">
                        <img class="profile_img_icon" src="{{ asset(auth('admin')->user()->avatar) }}" alt="profile" title="profile">
                        <span class="availability-status online"></span>
                    </div>
                    @else
                    <div class="nav_profile_img">
                        <img class="profile_img_icon" src="{{ asset('assets/images/faces/admin.png') }}" alt="profile" title="profile">
                        <span class="availability-status online"></span>
                    </div>
                    @endif
                </div><br>
                <label class="badge badge-gradient-info">Administraitor</label>
                <h2>{{ auth('admin')->user()->name }}</h2>
                <div class="personal">
                    <p>
                        <i class="mdi mdi-email-outline"></i>
                        {{ auth('admin')->user()->email }}
                    </p>
                    <p>
                        <i class="mdi mdi-cellphone"></i>
                        {{ auth('admin')->user()->phone }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Personal Information</h4><br>
                <form method="POST" action="{{ route('user.update', auth('admin')->user()->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="pat_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{ auth('admin')->user()->name }}"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email1" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email1" name="email" placeholder="Email" value="{{ auth('admin')->user()->email }}"><br>
                            @error('email')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password1" class="col-sm-3 col-form-label">Current Password</label>
                        <div class="col-sm-9">
                            <input type="password" readonly onfocus="this.removeAttribute('readonly');" class="form-control" name="current_password" id="password1" placeholder="Current Password"><br>
                            @if (session()->has('current_password'))
                            <div class="alert alert-danger">
                                Current password does not match
                            </div>
                            @elseif (session()->has('validator'))
                            <div class="alert alert-danger">
                                Current password is requierd
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password2" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                            <input type="password" readonly onfocus="this.removeAttribute('readonly');" class="form-control" name="password" id="password2" placeholder="New Password"><br>
                            @if (session()->has('new_password'))
                            <div class="alert alert-danger">
                                New Password cann't be same as your current password
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone1" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone1" name="phone" placeholder="Mobile number" value="{{ auth('admin')->user()->phone }}"><br>
                            @error('phone')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gender1" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select name="gender" id="gender1" class="form-control">
                                <option value="male" {{auth('admin')->user()->gender==="male"?"selected":""}}>Male</option>
                                <option value="female" {{auth('admin')->user()->gender==="female"?"selected":""}}>Female</option>
                            </select><br>
                            @error('gender')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="profile_photo_path1" class="col-sm-3 col-form-label">Profile
                            Photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="profile_photo_path1" name="avatar" placeholder="Profile Photo"><br>
                            @error('profilePhoto')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Update</button>
                        <button class="btn btn-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection