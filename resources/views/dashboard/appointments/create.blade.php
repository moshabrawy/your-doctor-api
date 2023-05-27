@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-bookmark-outline"></i>
            </span>
            Create New Appointment
        </h3>
    </div>
    @auth('admin')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Appointment
                        </h4><br>
                        <form method="POST" action="{{ route('appointments.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="day">Day</label>
                                        <input type="date" class="form-control" id="day" name="day"
                                            placeholder="ex:- Dentistry"><br>
                                        @error('day')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="start_time">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            placeholder="ex:- Dentistry"><br>
                                        @error('start_time')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="end_time">End Time</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time"
                                            placeholder="ex:- Dentistry"><br>
                                        @error('end_time')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="doc_name">Doctor Name</label>
                                        <select name="doc_name" id="doc_name" class="form-control">
                                            @foreach ($allDoctors as $doctor)
                                            <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                            @endforeach
                                        </select><br>
                                        @error('doc_name')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pat_name">Patient Name</label>
                                        <select name="pat_name" id="pat_name" class="form-control">
                                            @foreach ($allPatients as $patient)
                                            <option value="{{$patient->id}}">{{$patient->name}}</option>
                                            @endforeach
                                        </select><br>
                                        @error('pat_name')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-gradient-primary mr-2">Create</button>
                                <button class="btn btn-light" type="reset">
                                    <i class="mdi mdi-reload btn-icon-prepend"></i>
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection
