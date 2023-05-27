@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-bookmark-outline"></i>
            </span>
            Appointments
        </h3>
    </div>
    <div class="row">
        <!-- Table Content -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">All Appointments</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="search-field d-none d-md-block">
                                <form class="align-items-center h-100" action="{{ route('appointments.search') }}"
                                    method="GET">
                                    <div class="input-group">
                                        <input type="date" class="form-control bg-transparent border-0"
                                            placeholder="Type search here..." name="search">
                                        <button type="submit" class="badge badge-gradient-success search">
                                            <i class="search_icon mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if ($allAppointments->isEmpty())
                        <div class="no_results  text-center">
                            <div class=" py-3">
                                <img src="{{ asset('assets/images/no-results.png') }}" alt="No Results">
                            </div>
                            <h3 class="text-center text-gray-200">Sorry, We couldn't find any results</h3>
                        </div>
                    @else
                        <table class="table table-striped text-center">
                            <thead class=" blue-edit">
                                <tr>
                                    <th> ID </th>
                                    <th> Patient Name </th>
                                    <th> Doctor Name</th>
                                    <th> Appointment Date </th>
                                    <th> Status </th>
                                    <th> action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allAppointments as $appointment)
                                    <tr>
                                        <td> {{ $appointment->id }} </td>
                                        <td>{{ $appointment->user->name }}</td>
                                        <td> {{ $appointment->doctor->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($appointment->day_date)->format('d M Y') }}</td>
                                        <td>{{ $appointment->status }}</td>
                                        <td>
                                            <a href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}"
                                                class="btn btn-inverse-warning btn-sm">
                                                <i class="mdi mdi-lead-pencil"></i>
                                            </a>
                                            <form class="del_form"
                                                action="{{ route('appointments.destroy', ['appointment' => $appointment->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-inverse-danger btn-sm"> <i
                                                        class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-body">
                    <nav>
                        <ul class="pagination flat pagination-success">
                            {{ $allAppointments->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- end col-lg-12 -->
    </div>

@endsection
