@extends('layout')

@section('content')
    <!-- MAIN CONTENT -->
    <div class="main">
        <div class="main-content">
            <section class="login singup">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="d-flex">
                                <div class="mobile-toggle" id="mobile-toggle">
                                    <i class='bx bx-menu'></i>
                                </div>
                                <div class="main-title">
                                    Add User
                                </div>
                            </div>

                            <div class="box-body">
                                <div class="auth-content my-auto">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $message)
                                                    <li>{{ $message }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="mt-6 pt-2" action="{{ route('register.user') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label mb-14">Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                placeholder="Your Name" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 mt-24">
                                            <label class="form-label mb-14">User Name</label>
                                            <input type="text" name="username"
                                                class="form-control @error('username') is-invalid @enderror" id="username"
                                                placeholder="Your User Name" value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 mt-24">
                                            <label class="form-label mb-14">Mobile Number</label>
                                            <input type="number" name="mobile"
                                                class="form-control @error('mobile') is-invalid @enderror" id="mobile"
                                                placeholder="Your mobile number" value="{{ old('mobile') }}">
                                            @error('mobile')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 mt-24">
                                            <label class="form-label mb-14">Sub Division</label>
                                            <select name="sub_division" id="sub_division"
                                                class="form-control @error('sub_division') is-invalid @enderror">
                                                <option value="" disabled selected>Select</option>
                                                @foreach ($sub_divisions as $sub_division)
                                                    <option value="{{ $sub_division->id }}"
                                                        {{ old('sub_division') == $sub_division->id ? 'selected' : '' }}>
                                                        {{ $sub_division->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('sub_division')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3 mt-24">
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <label class="form-label mb-14">Password</label>
                                                </div>
                                            </div>

                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" name="password" id="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Enter password">
                                                <button class="btn shadow-none ms-0" type="button" id="password-addon"><i
                                                        class="far fa-eye-slash"></i></button>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3 mt-29">
                                            <button
                                                class="btn bg-primary color-white w-100 waves-effect waves-light fs-18 font-w500"
                                                type="submit">Create user</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- END MAIN CONTENT -->
@endsection
