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
                        Users List
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">Users List</div> --}}
                            <div class="card-body">
                                @if ($report_status->isEmpty())
                                    <p>No users found</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Report Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report_status as $report_status_list)
                                                <tr>
                                                    <td>{{ $report_status_list->id }}</td>
                                                    <td>{{ $report_status_list->report_status }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-info btn-sm">Edit</a>
                                                        <form action="#" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
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
