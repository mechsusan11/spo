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
                        Sub Division Master
                    </div>
                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSubdivisionModal">
                        Add New
                    </button>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-md-12">
                        {{-- <div class="card-header">Sub Division Master</div> --}}
                        <div class="card">
                            <div class="card-body">
                                @if ($sub_divisions->isEmpty())
                                    <p>No users found</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Sub Division</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sub_divisions as $sub_division)
                                                <tr>
                                                    <td>{{ $sub_division->id }}</td>
                                                    <td>{{ $sub_division->name }}</td>
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

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="addSubdivisionModal" tabindex="-1" role="dialog"
        aria-labelledby="addSubdivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubdivisionModalLabel">Add New Subdivision</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('subdivision.add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="subdivisionName">Subdivision Name</label>
                            <input type="text" class="form-control" id="subdivisionName" name="name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('content')
