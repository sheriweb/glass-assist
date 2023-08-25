@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Change Password" back="admin"/>

            <x-forms.form route="{{ route('admin.change-password') }}">
                <x-forms.input label="Password" name="password" type="password" required/>

                <x-forms.input label="Confirm Password" name="password_confirmation" required type="password"/>

                <x-forms.button text="save"/>
            </x-forms.form>
        </div>
    </div>
@endsection
