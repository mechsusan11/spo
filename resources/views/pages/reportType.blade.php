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
                        Report Type Master
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">Users List</div> --}}
                            <div class="card-body">
                                @if ($report_types->isEmpty())
                                    <p>No report types found</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Icon</th>
                                                <th>Report Type</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report_types as $report_type)
                                                <tr>
                                                    <td>{{ $report_type->id }}</td>
                                                    <td><img width="60rem" height="60rem"
                                                            src="{{ $report_type->icon_path }}" alt="Report type icons">
                                                    </td>
                                                    <td>{{ $report_type->report_type }}</td>
                                                    {{-- <td>
                                                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                                                        <form action="#" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@section('content')
