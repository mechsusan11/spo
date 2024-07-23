@extends('layout')

@section('content')
    <div class="main">
        <div class="container mt-5">
            <div class="main-content">
                <div class="d-flex">
                    <div class="mobile-toggle" id="mobile-toggle">
                        <i class='bx bx-menu'></i>
                    </div>
                    <div class="main-title">
                        Report List
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($reports->isEmpty())
                                    <p>No reports found</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>User Id</th>
                                                <th>Report ID</th>
                                                <th>Sub Division</th>
                                                <th>Incident Details</th>
                                                <th>Incident Date & Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reports as $reportlist)
                                                <tr>
                                                    <td>{{ $reportlist->user_id }}</td>
                                                    <td>{{ $reportlist->report_id }}</td>
                                                    <td>{{ $reportlist->sub_division }}</td>
                                                    <td>{{ $reportlist->incident_details }}</td>
                                                    <td>{{ $reportlist->incident_date_time }}</td>
                                                    <td>
                                                        <a href="{{ route('reports.view', $reportlist->id) }}"
                                                            class="btn btn-primary btn-sm">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
