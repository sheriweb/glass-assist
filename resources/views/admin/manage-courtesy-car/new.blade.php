@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Courtesy Car" back="admin.manage-courtesy-car"/>

            <x-forms.form route="{{ route('admin.new-courtesy-car') }}">
                <div class="row">
                    <x-forms.input name="name" label="Name"/>

                    <x-forms.select label="Make" name="make_id" :options="$carMakes" />

                    <x-forms.select label="Model" name="model_id" :options="$carModels" />

                    <x-forms.input name="reg_no" label="Registration Number" type="number"/>

                    <x-forms.input name="colour" label="Colour" type="color" />
                </div>

                <x-forms.button text="Save" large />
            </x-forms.form>

        </div>
    </div>

@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#make_id').select2();
            $('#model_id').select2();
        });
    </script>
@endsection
