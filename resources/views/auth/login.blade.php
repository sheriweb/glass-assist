@extends('auth.master')

@section('content')
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-4 mb-5">
                        <div class="mb-3">
                            <a href="#" class="auth-logo">
                                <img src="{{ asset('assets/images/glass-assist-logo.png') }}" height="40" class="logo-dark mx-auto" alt="">
                            </a>
                        </div>
                    </div>
                    <h4 class="text-muted text-center font-size-18 mt-3"><b>Sign In</b></h4>
                    <div class="p-3">
                        <form class="form-horizontal mt-3" action="{{ route('login.attempt') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3 row justify-content-center">
                                <div class="col-12">
                                    <input
                                            class="form-control {{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email" type="text" id="email" required placeholder="Username"
                                            value="{{ old('username') ?: old('email') }}" autofocus>

                                    @if ($errors->has('username') || $errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
                                       </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group mb-3 row justify-content-center">
                                <div class="col-12">
                                    <input class="form-control @error('password') is-invalid @enderror"
                                           type="password"
                                           id="password" name="password" required="" placeholder="Password"
                                           autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row justify-content-center">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                               id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-label ms-1" for="customCheck1">Remember me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3 text-center row mt-3 pt-1 justify-content-center">
                                <div class="col-md-4">
                                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">
                                        Log In
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
