@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Car Make" back="admin.manage-car-make"/>

            <x-forms.form route="{{ route('admin.edit-manage-car-make', $carMake->id) }}">
                @method('PUT')

                <x-forms.input name="name" :value="$carMake->name" label="Name"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection
