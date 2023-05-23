@extends('dashboard.layout')

@section('content')
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-bookmark-outline"></i>
            </span>
            Specialties
        </h3>
    </div>
    <div class="row">
        <!-- Table Content -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                @if (session()->has('specialtyCreated'))
                    <div class="card card-inverse-success" id="context-menu-open">
                        <div class="card-body">
                            <p class="card-text"> Greate! Add Successfully</p>
                        </div>
                    </div>
                @elseif (session()->has('error'))
                    <div class="card card-inverse-danger" id="context-menu-open">
                        <div class="card-body">
                            <p class="card-text"> oops! Add Fail</p>
                        </div>
                    </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title">All Specialties</h4>
                        </div>
                        <div class="col-md-4">
                            <div class="search-field d-none d-md-block">
                                <form class="align-items-center h-100" action="{{ route('specialties.search') }}"
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
                    @if ($allSpecialties->isEmpty())
                        <div class="no_results  text-center">
                            <div class=" py-3">
                                <img src="{{asset('assets/images/no-results.png')}}" alt="No Results">
                            </div>
                            <h3 class="text-center text-info">Sorry, We couldn't find any results</h3>
                        </div>
                    @else
                        <table class="table table-striped text-center">
                            <thead class=" blue-edit">
                                <tr>
                                    <th> ID </th>
                                    <th> Specialty Name </th>
                                    <th> Specialty About</th>
                                    <th> Specialty Icon </th>
                                    <th> action </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allSpecialties as $specialty)
                                    <tr>
                                        <td>{{ $specialty->id }}</td>
                                        <td>{{ $specialty->name }}</td>
                                        <td>{{ $specialty->about }}</td>
                                        <td>{{ $specialty->spec_icon }}</td>
                                        <td>
                                            <a href="{{ route('specialties.edit', ['specialty' => $specialty->id]) }}"
                                                class="btn btn-inverse-warning btn-sm">
                                                <i class="mdi mdi-lead-pencil"></i>
                                            </a>
                                            <form class="del_form"
                                                action="{{ route('specialties.destroy', ['specialty' => $specialty->id]) }}"
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
                            {{ $allSpecialties->links('pagination::bootstrap-4') }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <!-- end col-lg-12 -->
    </div>

    <!-- View Modal starts -->
    <div class="modal fade" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  role=" document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">
                        View Details
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <ul class="nav nav-tabs nav-tabs-vertical" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href=""
                                        role="tab" aria-controls="Details" aria-selected="true"> Details
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-8">
                            <div class="tab-content tab-content-vertical">
                                <div class="tab-pane fade show active" id="home-2" role="tabpanel"
                                    aria-labelledby="home-tab">
                                    <div>
                                        <p> day </p>
                                        <p>doc-id </p>
                                        <p>pat-id</p>
                                        <p>start- time </p>
                                        <p>end- time</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">
                            close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- View Modal Ends -->

    <!-- Edit Modal starts -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Edit your Appointment
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="example-form" action="#">
                        <div role="application" class="wizard clearfix" id="steps-uid-0">
                            <div class="steps clearfix">
                                <div class="content clearfix clearfix-edit">
                                    <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0"
                                        class="body curren">
                                        <div class="form-group">
                                            <label>day</label>
                                            <input type="text" class="form-control" value="15464545">
                                        </div>
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" class="form-control" aria-describedby="emailHelp"
                                                placeholder="Enter email" value="Email@gmail.com">
                                        </div>
                                        <div class="form-group">
                                            <label>start-time</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                placeholder="Enter email" value="male">
                                        </div>
                                        <div class="form-group">
                                            <label>End date</label>
                                            <input type="text" class="form-control" value="012545421">
                                        </div>
                                        <div class="form-group">
                                            <label>doc-id</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                placeholder="Enter email" value="25/13/2020">
                                        </div>
                                        <div class="form-group">
                                            <label>pat-id</label>
                                            <input type="text" class="form-control" aria-describedby="emailHelp"
                                                placeholder="Enter email" value="25/13/2020">
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal Ends -->

    <!-- delete Modal starts -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">
                        Delete Appointment
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body body-edit">
                    <p>Are you sure you want to delete it?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal End -->
@endsection
