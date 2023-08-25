@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Car Model" back="admin.manage-car-model" />

            <x-forms.form route="{{ route('admin.edit-manage-car-model', $carModel->id) }}">
                @method('PUT')

                <x-forms.input name="name" :value="$carModel->name" label="Name"/>

                <x-forms.select label="Make" name="make_id" :options="$carMakes" :selected="$carModel->make_id"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#make_id').select2();
        });
    </script>
@endsection
