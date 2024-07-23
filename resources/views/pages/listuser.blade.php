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
                                @if ($users->isEmpty())
                                    <p>No users found</p>
                                @else
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Mobile</th>
                                                <th>Sub Division</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->username }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td>{{ $user->sub_division }}</td>
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
