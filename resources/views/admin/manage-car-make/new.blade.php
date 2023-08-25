@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Car Make" back="admin"/>

            <x-forms.form route="{{ route('admin.new-manage-car-make') }}">
                <x-forms.input name="name" label="Name" required/>

                <x-forms.button text="Submit"/>
            </x-forms.form>

        </div>
    </div>
@endsection
