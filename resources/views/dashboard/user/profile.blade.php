@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-face-profile"></i>
            </span> Profile
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>
    @auth
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar">
                            @if (auth()->user()->avatar != null)
                                <div class="nav_profile_img">
                                    <img class="profile_img_icon" src="{{ asset(auth()->user()->avatar) }}" alt="profile"
                                        title="profile">
                                    <span class="availability-status online"></span>
                                </div>
                            @else
                                <div class="nav_profile_img">
                                    <img class="profile_img_icon" src="{{ asset('assets/images/faces/admin.png') }}"
                                        alt="profile" title="profile">
                                    <span class="availability-status online"></span>
                                </div>
                            @endif
                        </div><br>
                        <label class="badge badge-gradient-info">Administraitor</label>
                        <h2>{{ auth()->user()->name }}</h2>
                        <div class="personal">
                            <p class="profile-card-loc__txt" title="Addres">
                                <img width="25" src="{{ asset('landing-assets/images/icons/location.png') }}">
                                @if (auth()->user()->address == '')
                                    {{ auth()->user()->address['postal_code'] . auth()->user()->address['city'] . auth()->user()->address['state'] }}
                                @else
                                    {{ auth()->user()->address['postal_code'] . ', ' . auth()->user()->address['city'] . ', ' . auth()->user()->address['state'] }}
                                @endif
                            </p>
                            <p>
                                <i class="mdi mdi-email-outline"></i>
                                {{ auth()->user()->email }}
                            </p>
                            <p>
                                <i class="mdi mdi-cellphone"></i>
                                {{ auth()->user()->phone }}
                            </p>
                            <p>
                                <i class="mdi mdi-calendar-check"></i>
                                {{ auth()->user()->birth_date }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Personal Information</h4><br>
                        <form method="POST" action="{{ route('user.update', auth()->user()->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group row">
                                <label for="pat_name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Full Name" value="{{ auth()->user()->name }}"><br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email1" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email1" name="email" placeholder="Email"
                                        value="{{ auth()->user()->email }}"><br>
                                    @error('email')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password1" class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" id="password1"
                                        placeholder="Password"><br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone1" class="col-sm-3 col-form-label">Mobile</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone1" name="phone"
                                        placeholder="Mobile number" value="{{ auth()->user()->phone }}"><br>
                                    @error('phone')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender1" class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <select name="gender" id="gender1"class="form-control">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select><br>
                                    @error('gender')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birth_date1" class="col-sm-3 col-form-label">Birth
                                    Date</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control" id="birth_date1" name="birth_date"
                                        placeholder="birth Date" value="{{ auth()->user()->birth_date }}"><br>
                                    @error('birth_date')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-sm-3 col-form-label">Address</label>

                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="city" name="city"
                                        placeholder="City" value="{{ auth()->user()->address->city }}"><br>
                                    @error('city')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <select name="state" id="states"class="form-control">
                                    </select><br>
                                    @error('state')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control" id="postal_code" name="postal_code"
                                        placeholder="Postal Code" value="{{ auth()->user()->address->postal_code }}"><br>
                                    @error('postal_code')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="profile_photo_path1" class="col-sm-3 col-form-label">Profile
                                    Photo</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="profile_photo_path1" name="avatar"
                                        placeholder="Profile Photo"><br>
                                    @error('profilePhoto')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
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
