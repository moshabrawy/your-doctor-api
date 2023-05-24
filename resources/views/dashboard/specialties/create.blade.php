@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-bookmark-outline"></i>
        </span>
        Create New Specialty
    </h3>
</div>
@auth('admin')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Specialty
                </h4><br>
                <form method="POST" action="{{ route('specialties.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Specialty Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="ex:- Dentistry">
                                @error('title')
                                <div class="alert alert-danger mt-2 mb-1">
                                    {{ $message  }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="image">Specialty Photo</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @error('image')
                                <div class="alert alert-danger mt-2 mb-1">
                                    {{ $message  }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="brief">Specialty Brief</label>
                                <textarea name="brief" id="brief" rows="10" class="form-control">
                                </textarea>
                                @error('brief')
                                <div class="alert alert-danger mt-2 mb-1">
                                    {{ $message  }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-gradient-primary mr-2">Create</button>
                        <button class="btn btn-light" type="reset">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection