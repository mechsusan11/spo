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
                        Report Details
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
                                        <td>{{ $report->subDivision->name }}</td>
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
                                            @foreach ($report->image_path as $image)
                                                <img src="{{ url('storage/uploads/images/' . $image) }}" alt="Report Images"
                                                    title="Images" />
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Audio</th>
                                        <td><audio controls>
                                                <source src="{{ url('storage/uploads/audios/' . $report->audio_path) }}"
                                                    type="audio/mpeg">Your
                                                browser does not support the audio element.
                                            </audio></td>
                                    </tr>
                                    <tr>
                                        <th>Video</th>
                                        <td><video width="320" height="240" controls>
                                                <source src="{{ url('storage/uploads/videos/' . $report->video_path) }}"
                                                    type="video/mp4">Your browser
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
