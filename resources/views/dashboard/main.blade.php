@extends('layout')

@section('content')
    <div class="main">
        <div class="main-content dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="box card-box">
                        <div class="icon-box bg-color-1">
                            <div class="icon bg-icon-1">
                                <i class="bx bxs-bell bx-tada bx-tada"></i>
                            </div>
                            <div class="content">
                                <h5 class="title-box">Total Reports</h5>
                                <p class="color-1 mb-0 pt-4">{{ $reports->count() }}</p>
                            </div>
                        </div>

                        <div class="icon-box bg-color-2">
                            <div class="icon bg-icon-2">
                                <i class='bx bxs-message-rounded'></i>
                            </div>
                            <div class="content click-c">
                                <h5 class="title-box">Open Reports</h5>
                                <p class="color-2 mb-0 pt-4">{{ $reports->where('intel', null)->count() }}</p>
                            </div>
                        </div>

                        <div class="icon-box bg-color-3">
                            <a class="create d-flex" href="calendar.blade.php">
                                <div class="icon bg-icon-3">
                                    <i class="bx bx-calendar"></i>
                                </div>
                                <div class="content">
                                    <h5 class="title-box">Closed Reports</h5>
                                    <p class="color-3 mb-0 pt-4">{{ $reports->where('intel', 0 || 1)->count() }}</p>
                                </div>
                            </a>
                        </div>
                    @endsection
