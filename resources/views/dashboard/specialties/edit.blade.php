@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-bookmark-outline"></i>
            </span>
            Edit Specialty
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
                            @if ($specialty->spec_icon != null)
                                <div class="nav_specialty_icon">
                                    <i class="{{ $specialty->spec_icon }} "></i>
                                </div>
                            @else
                                <div class="nav_specialty_icon">
                                    <i class="mdi mdi-apps"></i>
                                </div>
                            @endif
                        </div><br>
                        <h3 class="specialty_name badge badge-gradient-primary">{{ $specialty->name }}</h3>
                        <div class="about text-left">
                            <h4 class="py-2 text-info"> <i class="mdi mdi-information-outline "></i> About</h4>
                            <p> {{ $specialty->about }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    @if (session()->has('success'))
                        <div class="card card-inverse-success" id="context-menu-open">
                            <div class="card-body">
                                <p class="card-text"> Greate! Update Successfully</p>
                            </div>
                        </div>
                    @elseif (session()->has('error'))
                        <div class="card card-inverse-danger" id="context-menu-open">
                            <div class="card-body">
                                <p class="card-text"> oops! Update Fail</p>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">Edit
                            <label class="badge badge-gradient-primary">{{ ' ' . $specialty->name . ' ' }}</label>
                            Information
                        </h4><br>
                        <form method="POST" action="{{ route('specialties.update', $specialty->id) }}" >
                            @csrf
                            @method('patch')
                            <div class="form-group row">
                                <label for="pat_name" class="col-sm-3 col-form-label">Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="ex:- Dentistry" value="{{ $specialty->name }}"><br>
                                    @error('name')
                                        <div class="alert alert-danger"> {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="spec_icon" class="col-sm-3 col-form-label">Specialty Icon Class</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="spec_icon" name="spec_icon"
                                        placeholder="ex:- mdi mdi-account" value="{{ $specialty->spec_icon }}"><br>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="about" class="col-sm-3 col-form-label">About Specialty</label>
                                <div class="col-sm-9">
                                    <textarea name="about" id="about" rows="10" class="form-control">
                                        {{ $specialty->about }}
                                    </textarea>
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
