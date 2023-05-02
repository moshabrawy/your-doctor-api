@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-multiple"></i>
            </span>
            Add New User
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row">
        <!-- Table Content -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Choose User Type</h4>
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2">
                                        <ul class="nav nav-pills nav-pills-vertical nav-pills-info" id="v-pills-tab"
                                            role="tablist" aria-orientation="vertical">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill"
                                                    href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                                    aria-selected="true">
                                                    <i class="mdi mdi-home-outline"></i> Doctor </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill"
                                                    href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                                    aria-selected="false">
                                                    <i class="mdi mdi-account-outline"></i> patient </a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="col-9">
                                        <div class="tab-content tab-content-vertical" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <div class="col-md-12 grid-margin stretch-card">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form class="forms-sample"
                                                                        action="{{ route('regDoctor') }}" method="POST"
                                                                        enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="form-group row">
                                                                            <label for="doc_name"
                                                                                class="col-sm-3 col-form-label">Doctor
                                                                                Name</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control"
                                                                                    id="doc_name" name="doc_name"
                                                                                    placeholder="Full Name"><br>
                                                                                @error('doc_name')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="email"
                                                                                class="col-sm-3 col-form-label">Email</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="email" class="form-control"
                                                                                    id="email" name="email"
                                                                                    placeholder="Email"><br>
                                                                                @error('email')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <label for="password"
                                                                                class="col-sm-3 col-form-label">Password</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="password" class="form-control"
                                                                                    name="password" id="password"
                                                                                    placeholder="Password"><br>
                                                                                @error('password')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="ConfirmPassword"
                                                                                class="col-sm-3 col-form-label">Re
                                                                                Password</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="password" class="form-control"
                                                                                    id="ConfirmPassword"
                                                                                    name="confirmPassword"
                                                                                    placeholder="Password"><br>
                                                                                @error('confirmPassword')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="phone"
                                                                                class="col-sm-3 col-form-label">Mobile</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control"
                                                                                    id="phone" name="phone"
                                                                                    placeholder="Mobile number"><br>
                                                                                @error('phone')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="specialty"
                                                                                class="col-sm-3 col-form-label">Specialty</label>
                                                                            <div class="col-sm-9">
                                                                                <select name="specialty"
                                                                                    id="specialty"class="form-control">
                                                                                    @foreach ($allSpecialties as $specialty)
                                                                                        <option
                                                                                            value="{{ $specialty->id }}">
                                                                                            {{ $specialty->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select><br>
                                                                                @error('specialty')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="gender"
                                                                                class="col-sm-3 col-form-label">Gender</label>
                                                                            <div class="col-sm-9">
                                                                                <select name="gender"
                                                                                    id="gender"class="form-control">
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
                                                                            <label for="birth_date"
                                                                                class="col-sm-3 col-form-label">Birth
                                                                                Date</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="date" class="form-control"
                                                                                    id="birth_date" name="birth_date"
                                                                                    placeholder="birth Date">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="fees"
                                                                                class="col-sm-3 col-form-label">Fees</label>
                                                                            <div class="col-sm-9">
                                                                                <div class="input-group">
                                                                                    <div class="input-group-prepend">
                                                                                        <span
                                                                                            class="input-group-text bg-gradient-primary text-white">&pound;</span>
                                                                                    </div>
                                                                                    <input type="number"
                                                                                        class="form-control"
                                                                                        id="fees" name="fees">
                                                                                    <div class="input-group-append">
                                                                                        <span
                                                                                            class="input-group-text">.00</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="city"
                                                                                class="col-sm-3 col-form-label">Address</label>

                                                                            <div class="col-sm-3">
                                                                                <input type="text" class="form-control"
                                                                                    id="city" name="city"
                                                                                    placeholder="City"><br>
                                                                                @error('city')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <select name="state"
                                                                                    id="states"class="form-control">
                                                                                </select><br>
                                                                                @error('state')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <input type="number" class="form-control"
                                                                                    id="postal_code" name="postal_code"
                                                                                    placeholder="Postal Code"><br>
                                                                                @error('postal_code')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="bio"
                                                                                class="col-sm-3 col-form-label">Bio</label>
                                                                            <div class="col-sm-9">
                                                                                <textarea class="form-control" name="bio" id="bio" cols="30" rows="10"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="avatar"
                                                                                class="col-sm-3 col-form-label">Profile
                                                                                Photo</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" class="form-control"
                                                                                    id="avatar" name="avatar"
                                                                                    placeholder="Profile Photo"><br>
                                                                                @error('avatar')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="user_type"
                                                                                class="col-sm-3 col-form-label">User
                                                                                Type</label>
                                                                            <div class="col-sm-9">
                                                                                <input disabled type="text"
                                                                                    class="form-control" id="user_type"
                                                                                    name="user_type" value="Doctor">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button type="submit"
                                                                                class="btn blue-edit mr-2">Register</button>
                                                                            <button class="btn btn-light">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                <div class="media">
                                                    <div class="media-body">
                                                        <div class="col-md-12 grid-margin stretch-card">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <form class="forms-sample"
                                                                        action="{{ route('regPatient') }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        <div class="form-group row">
                                                                            <label for="pat_name"
                                                                                class="col-sm-3 col-form-label">Patient
                                                                                Name</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control"
                                                                                    id="pat_name" name="pat_name"
                                                                                    placeholder="Full Name"><br>
                                                                                @error('pat_name')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>

                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="email1"
                                                                                class="col-sm-3 col-form-label">Email</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="email" class="form-control"
                                                                                    id="email1" name="email"
                                                                                    placeholder="Email"><br>
                                                                                @error('email')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="password1"
                                                                                class="col-sm-3 col-form-label">Password</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="password"
                                                                                    class="form-control" name="password"
                                                                                    id="password1"
                                                                                    placeholder="Password"><br>
                                                                                @error('password')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="ConfirmPassword1"
                                                                                class="col-sm-3 col-form-label">Re
                                                                                Password</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="password"
                                                                                    class="form-control"
                                                                                    id="ConfirmPassword1"
                                                                                    name="confirmPassword"
                                                                                    placeholder="Password"><br>
                                                                                @error('confirmPassword')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="phone1"
                                                                                class="col-sm-3 col-form-label">Mobile</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="text" class="form-control"
                                                                                    id="phone1" name="phone"
                                                                                    placeholder="Mobile number"><br>
                                                                                @error('phone')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="gender1"
                                                                                class="col-sm-3 col-form-label">Gender</label>
                                                                            <div class="col-sm-9">
                                                                                <select name="gender"
                                                                                    id="gender1"class="form-control">
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
                                                                            <label for="birth_date1"
                                                                                class="col-sm-3 col-form-label">Birth
                                                                                Date</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="date" class="form-control"
                                                                                    id="birth_date1" name="birth_date"
                                                                                    placeholder="birth Date"><br>
                                                                                @error('birth_date')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="city"
                                                                                class="col-sm-3 col-form-label">Address</label>

                                                                            <div class="col-sm-3">
                                                                                <input type="text" class="form-control"
                                                                                    id="city" name="city"
                                                                                    placeholder="City"><br>
                                                                                @error('city')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <select name="state"
                                                                                    id="userStates"class="form-control">
                                                                                </select><br>
                                                                                @error('state')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                                <input type="number" class="form-control"
                                                                                    id="postal_code" name="postal_code"
                                                                                    placeholder="Postal Code"><br>
                                                                                @error('postal_code')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="profile_photo_path1"
                                                                                class="col-sm-3 col-form-label">Profile
                                                                                Photo</label>
                                                                            <div class="col-sm-9">
                                                                                <input type="file" class="form-control"
                                                                                    id="profile_photo_path1"
                                                                                    name="avatar"
                                                                                    placeholder="Profile Photo"><br>
                                                                                @error('avatar')
                                                                                    <div class="alert alert-danger">
                                                                                        {{ $message }}</div>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label for="user_type1"
                                                                                class="col-sm-3 col-form-label">User
                                                                                Type</label>
                                                                            <div class="col-sm-9">
                                                                                <input disabled type="text"
                                                                                    class="form-control" id="user_type1"
                                                                                    name="user_type" value="Patient">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <button type="submit"
                                                                                class="btn blue-edit mr-2">Register</button>
                                                                            <button class="btn btn-light">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!-- end col-lg-12 -->
    </div>
@endsection
