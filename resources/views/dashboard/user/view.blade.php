@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-face-profile"></i>
            </span>

            @if ($user->user_type == 2)
                Doctor Profile
            @elseif ($user->user_type == 3)
                Patient Profile
            @endif
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
                            @if ($user->avatar != null)
                                <div class="nav_profile_img">
                                    <img class="profile_img_icon" src="{{ asset($user->avatar) }}" alt="profile"
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
                        @if ($user->user_type == 1)
                            <label class="badge badge-gradient-info">Administraitor</label>
                        @elseif ($user->user_type == 2)
                            <label class="badge badge-gradient-success">Docotor</label>
                        @elseif ($user->user_type == 3)
                            <label class="badge badge-gradient-warning">Patient</label>
                        @endif
                        @if ($user->user_type == 2)
                            <h2>{{ 'Dr. ' . $user->name }}</h2>
                        @else
                            <h2>{{ $user->name }}</h2>
                        @endif
                        @if ($user->user_type == 2)
                            <h3>
                                <img width="25" src="{{ asset('landing-assets/images/icons/specialty.png') }}">
                                {{ $user->doctor->specialty->name }}
                            </h3>
                        @endif
                        <div class="personal">
                            <p class="profile-card-loc__txt" title="Addres">
                                <img width="25" src="{{ asset('landing-assets/images/icons/location.png') }}">
                                @if ($user->address == '')
                                    {{ $user->address['postal_code'] . $user->address['city'] . $user->address['state'] }}
                                @else
                                    {{ $user->address['postal_code'] . ', ' . $user->address['city'] . ', ' . $user->address['state'] }}
                                @endif
                            </p>
                            <p>
                                <i class="mdi mdi-email-outline"></i>
                                {{ $user->email }}
                            </p>
                            <p>
                                <i class="mdi mdi-cellphone"></i>
                                {{ $user->phone }}
                            </p>
                            <p>
                                <i class="mdi mdi-calendar-check"></i>
                                {{ $user->birth_date }}
                            </p>
                            @if ($user->user_type == 2)
                                <p>
                                    {{ 'Fees: ' . $user->doctor->fees }}
                                    <i class='fa fa-gbp'></i>
                                </p>
                                <p>
                                    <i class="fa fa-info-circle"></i>
                                    {{ $user->doctor->bio }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Personal Information</h4><br>
                        @if ($user->user_type == 2)
                            <form method="POST" action="{{ route('user.update', $user->id) }}"
                                enctype="multipart/form-data">
                            @elseif ($user->user_type == 3)
                                <form method="POST" action="{{ route('user.update', $user->id) }}"
                                    enctype="multipart/form-data">
                        @endif
                        @csrf
                        @method('patch')
                        <div class="form-group row">
                            <label for="pat_name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Full Name"
                                    value="{{ $user->name }}"><br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email1" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email1" name="email" placeholder="Email"
                                    value="{{ $user->email }}"><br>
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
                                    placeholder="Mobile number" value="{{ $user->phone }}"><br>
                                @error('phone')
                                    <div class="alert alert-danger">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if ($user->user_type == 2)
                            <div class="form-group row">
                                <label for="specialty" class="col-sm-3 col-form-label">Specialty</label>
                                <div class="col-sm-9">
                                    <select name="specialty" id="specialty"class="form-control">
                                        @foreach ($allSpecialties as $specialty)
                                            <option value="{{ $specialty->id }}"
                                                {{ $specialty->id == $user->doctor->specialty_id ? 'selected' : '' }}>
                                                {{ $specialty->name }}</option>
                                        @endforeach
                                    </select><br>
                                    @error('specialty')
                                        <div class="alert alert-danger">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif
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
                                    placeholder="birth Date" value="{{ $user->birth_date }}"><br>
                                @error('birth_date')
                                    <div class="alert alert-danger">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="city" class="col-sm-3 col-form-label">Address</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="city" name="city" placeholder="City"
                                    value="{{ $user->address->city }}"><br>
                                @error('city')
                                    <div class="alert alert-danger">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <select name="state" id="states"class="form-control">
                                                                                    {{ $specialty->id == $user->doctor->specialty_id ? 'selected' : '' }}>

                                </select>

                                <br>
                                @error('state')
                                    <div class="alert alert-danger">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-3">
                                <input type="number" class="form-control" id="postal_code" name="postal_code"
                                    placeholder="Postal Code" value="{{ $user->address->postal_code }}"><br>
                                @error('postal_code')
                                    <div class="alert alert-danger">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @if ($user->user_type == 2)
                            <div class="form-group row">
                                <label for="bio" class="col-sm-3 col-form-label">Bio</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="bio" id="bio" cols="30" rows="10">{{ $user->doctor->bio }}</textarea>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <label for="avatar" class="col-sm-3 col-form-label">Profile
                                Photo</label>
                            <div class="col-sm-9">
                                <input type="file" class="form-control" id="avatar" name="avatar"
                                    placeholder="Profile Photo"><br>
                                @error('avatar')
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


    {{-- <img src="{{ asset('assets/images/faces/face1.jpg') }}" class="mr-2" alt="image">
    <label class="badge badge-gradient-success">DONE</label>
    <label class="badge badge-gradient-warning">PROGRESS</label>
    <label class="badge badge-gradient-danger">REJECTED</label> --}}
@endsection
