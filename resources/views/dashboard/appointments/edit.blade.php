@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-bookmark-outline"></i>
            </span>
            Edit Appointment
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
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    @if (session()->has('appointmentUpdated'))
                        <div class="card card-inverse-success" id="context-menu-open">
                            <div class="card-body">
                                <p class="card-text"> Greate! Updateed Successfully</p>
                            </div>
                        </div>
                    @elseif (session()->has('error'))
                        <div class="card card-inverse-danger" id="context-menu-open">
                            <div class="card-body">
                                <p class="card-text"> oops! Updateed Fail</p>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title">Edit Appointment
                        </h4><br>
                        <form method="POST" action="{{ route('appointments.update',['appointment' => $appointment->id]) }}">
                            @csrf
                            @method('patch')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="day">Day</label>
                                        <input type="date" class="form-control" id="day" name="day"
                                            value="{{ $appointment->day }}"><br>
                                        @error('day')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="start_time">Start Time</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            value="{{ $appointment->start_time }}"><br>
                                        @error('start_time')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="end_time">End Time</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time"
                                            value="{{ $appointment->end_time }}"><br>
                                        @error('end_time')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="doc_name">Doctor Name</label>
                                        <select name="doc_id" id="doc_name" class="form-control">
                                            @foreach ($allDoctors as $doctor)
                                                <option value="{{ $doctor->id }}"
                                                    {{ $doctor->id == $appointment->id ? 'selected' : '' }}>
                                                    {{ $doctor->name }}</option>
                                            @endforeach
                                        </select><br>
                                        @error('doc_id')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pat_name">Patient Name</label>
                                        <select name="pat_id" id="pat_name" class="form-control">
                                            @foreach ($allPatients as $patient)
                                                <option value="{{ $patient->id }}"
                                                    {{ $patient->id == $appointment->id ? 'selected' : '' }}>
                                                    {{ $patient->name }}
                                                </option>
                                            @endforeach
                                        </select><br>
                                        @error('pat_id')
                                            <div class="alert alert-danger"> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
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
