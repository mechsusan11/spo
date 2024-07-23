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
                        App Configuration Message Master
                    </div>
                </div>

                <div class="row justify-content-center main-content">
                    <div class="col-md-12">
                        <div class="card">
                            {{-- <div class="card-header">Users List</div> --}}
                            <div class="card-body">
                                @if ($messages->isEmpty())
                                    <p>No report types found</p>
                                @else
                                    <table class="table table-bordered themeLight">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>App Type</th>
                                                <th>Success Message</th>
                                                {{-- <th>Actions</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($messages as $message)
                                                <tr>
                                                    <td>{{ $message->id }}</td>
                                                    <td>{{ $message->app_name }}</td>
                                                    <td>{{ $message->success_message }}</td>
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
