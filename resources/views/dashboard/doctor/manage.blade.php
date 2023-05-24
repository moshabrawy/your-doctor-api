@extends('dashboard.layout')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-account-multiple"></i>
        </span> Doctors
    </h3>
</div>
<div class="row">
    <!-- Table Content -->
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="card-title">All Doctors</h4>
                    </div>
                    <div class="col-md-4">
                        <div class="search-field d-none d-md-block">
                            <form class="align-items-center h-100" action="{{ route('doctors.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-transparent border-0" placeholder="Type search here..." name="search">
                                    <button type="submit" class="badge badge-gradient-success search">
                                        <i class="search_icon mdi mdi-magnify"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @if ($allDoctors->isEmpty())
                <div class="no_results">
                    <div class="py-3">
                        <img src="{{ asset('assets/images/no-results.png') }}" alt="No Results">
                    </div>
                    <h3 class="text-center text-gray-200">Sorry, We couldn't find any results</h3>
                </div>
                @else
                <table class="table table-striped text-center">
                    <thead class="blue-edit">
                        <tr>
                            <th> ID </th>
                            <th> Avatar </th>
                            <th> Doctor Name </th>
                            <th> Specialization </th>
                            <th> Email Address </th>
                            <th> Doctor Phone No. </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allDoctors as $doctor)
                        <tr>
                            <td> #10{{ $loop->index }} </td>
                            <td>
                                @if ($doctor->avatar != null)
                                <img src="{{ asset($doctor->avatar) }}" class="mr-2" alt="Avatar">
                                @else
                                <img src="{{ asset('assets/images/faces/admin.png') }}" class="mr-2" alt="Avatar">
                                @endif
                            </td>
                            <td> {{ $doctor->name }} </td>
                            <td> {{ $doctor->doctor_info->specialty->title }} </td>
                            <td> {{ $doctor->email }} </td>
                            <td> {{ $doctor->phone }} </td>
                            <td>
                                <a href="{{ route('doctors.show', $doctor->id) }}}" class="btn btn-inverse-warning btn-sm">
                                    <i class="mdi mdi-lead-pencil"></i>
                                </a>
                                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-inverse-danger btn-sm">
                                        <i class="mdi mdi-delete"></i>
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
                        {{ $allDoctors->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- end col-lg-12 -->
</div>
@endsection