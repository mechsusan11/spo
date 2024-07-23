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
                        Sub Division Mis-match Reports
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>User Id</th>
                                        <td>{{ $report->user_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Report Id</th>
                                        <td>{{ $report->report_id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Sub Division</th>
                                        <td>
                                            <form action="{{ route('reports.updateSubDivision') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                                <select name="sub_division" class="form-control"
                                                    onchange="this.form.submit()">
                                                    @foreach ($subDivisions as $subDivision)
                                                        <option value="{{ $subDivision->id }}"
                                                            {{ $subDivision->id == $report->sub_division ? 'selected' : '' }}>
                                                            {{ $subDivision->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Incident Details</th>
                                        <td>{{ $report->incident_details }}</td>
                                    </tr>
                                    <tr>
                                        <th>Incident Date & Time</th>
                                        <td>{{ $report->incident_date_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Image</th>
                                        <td>
                                            <img src="{{ asset($report->image_path) }}" alt="Report Image"
                                                style="max-width: 100px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Audio</th>
                                        <td><audio controls>
                                                <source src="{{ asset($report->audio_path) }}" type="audio/mpeg">Your
                                                browser does not support the audio element.
                                            </audio></td>
                                    </tr>
                                    <tr>
                                        <th>Video</th>
                                        <td><video width="320" height="240" controls>
                                                <source src="{{ asset($report->video_path) }}" type="video/mp4">Your
                                                browser
                                                does not support the video tag.
                                            </video></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
