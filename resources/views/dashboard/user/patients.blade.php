@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-account-multiple"></i>
            </span> Patients
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
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">All Patients</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="search-field d-none d-md-block">
                                <form class="align-items-center h-100" action="{{ route('SearchPatient') }}"
                                    method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-transparent border-0"
                                            placeholder="Type search here..." name="search">
                                        <button type="submit" class="badge badge-gradient-success search">
                                            <i class="search_icon mdi mdi-magnify"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if (session()->has('success'))
                        <div class="alert alert-info">Delete Successfull !</div>
                    @elseif (session()->has('error'))
                        <div class="alert alert-danger">Delete Fail !</div>
                    @endif
                    @if ($allPatients->isEmpty())
                        <div class="no_results  text-center">
                            <div class=" py-3">
                                <img src="{{ asset('assets/images/no-results.png') }}" alt="No Results">
                            </div>
                            <h3 class="text-center text-info">Sorry, We couldn't find any results</h3>
                        </div>
                    @else
                        <table class="table table-striped text-center">
                            <thead class=" blue-edit">
                                <tr>
                                    <th> ID </th>
                                    <th> Avatar </th>
                                    <th> Patient Name </th>
                                    <th> Email Address </th>
                                    <th> Phone Number </th>
                                    <th> Address </th>
                                    <th> Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allPatients as $patient)
                                    <tr>
                                        <td> {{ $patient->id }} </td>
                                        <td>
                                            @if ($patient->avatar != null)
                                                <img src="{{ asset($patient->avatar) }}" class="mr-2" alt="Avatar">
                                            @else
                                                <img src="{{ asset('assets/images/faces/admin.png') }}" class="mr-2"
                                                    alt="Avatar">
                                            @endif
                                        </td>
                                        <td> {{ $patient->name }} </td>
                                        <td> {{ $patient->email }} </td>
                                        <td> {{ $patient->phone }} </td>
                                        <td>
                                            @if ($patient->address == '')
                                            {{ $patient->address['postal_code'] .$patient->address['city'] . $patient->address['state'] }}
                                            @else
                                            {{ $patient->address['postal_code'] . ', ' .$patient->address['city'] . ', ' . $patient->address['state'] }}
                                            @endif
                                         </td>
                                        <td>
                                            <a href="{{ route('ViewUser', $patient->id) }}}"
                                                class="btn btn-inverse-success btn-sm">
                                                <i class="mdi mdi-eye"></i>
                                            </a>
                                            <a href="{{ route('ViewUser', $patient->id) }}}"
                                                class="btn btn-inverse-warning btn-sm">
                                                <i class="mdi mdi-lead-pencil"></i>
                                            </a>
                                            <a href="{{ route('DeletePatient', $patient->id) }}"
                                                class="btn btn-inverse-danger btn-sm"> <i class="mdi mdi-delete"></i>
                                            </a>
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
                            {{ $allPatients->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- end col-lg-12 -->
    </div>
@endsection