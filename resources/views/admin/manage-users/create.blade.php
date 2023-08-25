@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Sub User" back="admin" />

            <x-forms.form route="{{ route('admin.new-manage-users') }}">
                <x-forms.input name="first_name" label="First Name"/>

                <x-forms.input name="surname" label="Surname" />

                <x-forms.input name="email" label="Email" />

                <x-forms.input name="username" label="Username" />

                <x-forms.input name="password" label="Password" type="password" />

                @include('admin.manage-users.access-level', ['access_level' => 4])

                <x-forms.button text="Save" />
            </x-forms.form>

        </div>
    </div>
@endsection
