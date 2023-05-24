@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-account-multiple"></i>
        </span>
        Add New User
    </h3>
</div>
<div class="row">
    <!-- Table Content -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> Add New Patient</h4>
                <form class="forms-sample" action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Patient Name</label>
                        <div class="col-sm-9">
                            <input type="text" value="{{ old('name') }}" class="form-control" id="name" name="name" placeholder="Full Name">
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
                            <input type="email" value="{{ old('email') }}" class="form-control" id="email" name="email" placeholder="Email">
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
                            <input type="number" value="{{ old('phone') }}" class="form-control" id="phone" name="phone" placeholder="phone">
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
                        <div class="col-sm-9 mt-3 ml-auto">
                            <div class="form-group">
                                <button type="submit" class="btn blue-edit mr-2">Create</button>
                                <button type="reset" class="btn btn-light">Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end col-lg-12 -->
</div>
@endsection