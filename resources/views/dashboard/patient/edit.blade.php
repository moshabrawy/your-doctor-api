@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-face-profile"></i>
        </span>
        Patient Profile
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
                <label class="badge badge-gradient-warning">Patient</label>
                <h2 class="h4">{{ $user->name }}</h2>
                <div class="personal">
                    <p>
                        <i class="mdi mdi-email-outline"></i>
                        {{ $user->email }}
                    </p>
                    <p>
                        <i class="mdi mdi-cellphone"></i>
                        {{ $user->phone }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit {{$user->name}} Information</h4><br>
                <form method="POST" action="{{ route('patients.update', $user->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Doctor Name</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ $user->name }}" class="form-control" id="name" name="name" placeholder="Full Name">
                            @error('name')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" value="{{ $user->email }}" class="form-control" id="email" name="email" placeholder="Email">
                            @error('email')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="number" value="{{ $user->phone }}" class="form-control" id="phone" name="phone" placeholder="phone">
                            @error('phone')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                            <input readonly onfocus="this.removeAttribute('readonly');" type="password" class="form-control" name="password" id="password" placeholder="Password">
                            @error('password')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirmPassword" class="col-sm-3 col-form-label">confirm Password</label>
                        <div class="col-sm-9">
                            <input readonly onfocus="this.removeAttribute('readonly');" type="password" class="form-control" id="confirmPassword" name="confirm_password" placeholder="confirm Password">
                            @error('confirm_password')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
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