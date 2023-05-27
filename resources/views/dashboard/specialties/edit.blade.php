@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-bookmark-outline"></i>
        </span>
        Edit Specialty
    </h3>
</div>
@auth('admin')
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar">
                    <div class="nav_specialty_icon">
                        <img src="{{$specialty->image}}" alt="{{$specialty->title}}">
                    </div>
                </div><br>
                <h3 class="specialty_name badge badge-gradient-primary">{{ $specialty->title }}</h3>
                <div class="about text-left">
                    <h4 class="py-2 text-info"> <i class="mdi mdi-information-outline "></i> Brief</h4>
                    <p> {{ $specialty->brief }} </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit
                    <label class="badge badge-gradient-primary">{{ ' ' . $specialty->title . ' ' }}</label>
                    Information
                </h4><br>
                <form method="POST" action="{{ route('specialties.update', $specialty->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">Specialty Title</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="title" name="title" placeholder="ex:- Dentistry" value="{{ $specialty->title }}">
                            @error('title')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label">Specialty Photo</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                            <div class="alert alert-danger mt-2 mb-1">
                                {{ $message  }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="brief" class="col-sm-3 col-form-label">Specialty Brief</label>
                        <div class="col-sm-9">
                            <textarea name="brief" id="brief" rows="10" class="form-control">
                            {{ $specialty->brief }}
                            </textarea>
                            @error('brief')
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
@endsection
