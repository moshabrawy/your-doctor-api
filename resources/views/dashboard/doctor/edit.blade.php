@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-face-profile"></i>
        </span>
        Doctor Profile
    </h3>
</div>
@auth('admin')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar">
                    @if ($user->avatar != null)
                    <div class="nav_profile_img">
                        <img class="profile_img_icon" src="{{ asset($user->avatar) }}" alt="profile" title="profile">
                        <span class="availability-status online"></span>
                    </div>
                    @else
                    <div class="nav_profile_img">
                        <img class="profile_img_icon" src="{{ asset('assets/images/faces/admin.png') }}" alt="profile" title="profile">
                        <span class="availability-status online"></span>
                    </div>
                    @endif
                </div><br>
                <label class="badge badge-gradient-success">Docotor</label>
                <h2 class="h4">{{ 'Dr. ' . $user->name }}</h2>
                <h3 class="d-flex justify-content-center">
                    <img width="25" src="{{ asset('assets/images/specialty.png') }}">
                    {{ $user->doctor_info->specialty->title }}
                </h3>
                <div class="personal">
                    @if($user->address !== [])
                    @foreach($user->address as $address)
                    <p class="d-flex justify-content-center">
                        <img width="25" src="{{ asset('assets/images/location.png') }}">
                        {{$address->address . ', ' . $address->state . ', ' . $address->country}}.
                    </p>
                    @endforeach
                    @endif
                    <p>
                        <i class="fa fa-info-circle"></i>
                        {{ $user->doctor_info->bio }}
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
                        {{ 'Fees: ' . $user->doctor_info->fees }}
                        <i class='fa fa-gbp'></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit DR. {{$user->name}} Information</h4><br>
                <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="pat_name" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" value="{{ $user->name }}"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email1" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email1" name="email" placeholder="Email" value="{{ $user->email }}"><br>
                            @error('email')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password1" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password" id="password1" placeholder="Password"><br>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone1" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone1" name="phone" placeholder="Mobile number" value="{{ $user->phone }}"><br>
                            @error('phone')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @if ($user->user_type == 2)
                    <div class="form-group row">
                        <label for="specialty" class="col-sm-3 col-form-label">Specialty</label>
                        <div class="col-sm-9">
                            <select name="specialty" id="specialty" class="form-control">
                                @foreach ($allSpecialties as $specialty)
                                <option value="{{ $specialty->id }}" {{ $specialty->id == $user->doctor->specialty_id ? 'selected' : '' }}>
                                    {{ $specialty->name }}
                                </option>
                                @endforeach
                            </select><br>
                            @error('specialty')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="gender1" class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                            <select name="gender" id="gender1" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select><br>
                            @error('gender')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birth_date1" class="col-sm-3 col-form-label">Birth
                            Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="birth_date1" name="birth_date" placeholder="birth Date" value="{{ $user->birth_date }}"><br>
                            @error('birth_date')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" value="{{ $user->address }}"><br>
                            @error('city')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <select name="state" id="states" class="form-control">

                            </select>

                            <br>
                            @error('state')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
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
                            <input type="file" class="form-control" id="avatar" name="avatar" placeholder="Profile Photo"><br>
                            @error('avatar')
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


{{-- <img src="{{ asset('assets/images/faces/face1.jpg') }}" class="mr-2" alt="image">
<label class="badge badge-gradient-success">DONE</label>
<label class="badge badge-gradient-warning">PROGRESS</label>
<label class="badge badge-gradient-danger">REJECTED</label> --}}
@endsection