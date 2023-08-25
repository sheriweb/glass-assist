@extends('auth.master')

@section('content')

    <div class="wrapper-page">
        <div class="container-fluid">
            <div class="card">
                <div class="col-lg-12">
                    <div class="card-body">
                        <h4 class="text-muted text-center font-size-18"><b>Register</b></h4>
                        <div class="p-3">
                            <x-form route="{{ route('register') }}" simple>
                                <div class="row">
                                    <x-input label="Company Name" name="company_name" required/>

                                    <x-input label="Title" name="title"/>

                                    <x-input label="Address 1" name="address_1"/>

                                    <x-input label="First Name" name="first_name" required/>

                                    <x-input label="Address 2" name="address_2"/>

                                    <x-input label="Surname" name="surname" required/>

                                    <x-input label="City" name="city"/>

                                    <x-input label="Email" type="email" name="email" required/>

                                    <x-input label="Country" name="country"/>

                                    <x-input label="Username" name="username" required/>

                                    <x-input label="Postcode" name="postcode"/>

                                    <x-input label="Password" type="password" name="password" required/>

                                    <x-input label="Phone" type="number" name="phone"/>

                                    <x-input label="Confirm Password" type="password" name="password_confirmation"
                                             required/>

                                    <div class="col-lg-6 mb-4">
                                        <label>Account Level <b class="text-danger">*</b></label>
                                        <select class="form-select" name="account_level"
                                                aria-label="Default select example">
                                            <option selected value="1">MESSENGER (£9.95 per month inc. VAT)</option>
                                            <option value="2">MANAGER (£35.94 per month inc. VAT)</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mb-4">
                                        <div class="custom-control custom-checkbox mt-5">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1"
                                                   required>
                                            <label class="form-label ms-1 fw-normal" for="customCheck1">I accept <a
                                                    href="{{ route('terms') }}" class="text-muted">Terms and Conditions
                                                    <b class="text-danger">*</b></a></label>
                                        </div>
                                    </div>
                                </div>

                                <x-button text="Register" large/>

                                <div class="form-group mt-2 mb-0 row">
                                    <div class="col-12 mt-3 text-center">
                                        <a href="{{ route('user-login') }}" class="text-muted">Already have account?</a>
                                    </div>
                                </div>
                            </x-form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
