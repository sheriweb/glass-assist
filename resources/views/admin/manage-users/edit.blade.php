@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Sub User" back="admin.manage-users" />

            <x-forms.form route="{{ route('admin.edit-manage-users', $user->id) }}">
                @method('PUT')

                <x-forms.input name="first_name" label="First Name" :value="$user->first_name"/>

                <x-forms.input name="surname" label="Surname" :value="$user->surname"/>

                <x-forms.input name="email" label="Email" :value="$user->email"/>

                <x-forms.input name="username" label="Username" :value="$user->username"/>

                <x-forms.input name="password" label="New Password" type="password"/>

                @include('admin.manage-users.access-level', ['access_level' => $user->access_level])

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection
