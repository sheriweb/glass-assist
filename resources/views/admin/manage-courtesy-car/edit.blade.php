@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Courtesy Car" back="admin.manage-courtesy-car"/>

            <x-forms.form route="{{ route('admin.edit-manage-courtesy-car', $courtesyCar->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input name="name" :value="$courtesyCar->name" label="Name"/>

                    <x-forms.select label="Make" name="make_id" :options="$carMakes" :selected="$courtesyCar->make_id"/>

                    <x-forms.select label="Model" name="model_id" :options="$carModels" :selected="$courtesyCar->model_id"/>

                    <x-forms.input name="reg_no" :value="$courtesyCar->reg_no" label="Registration Number" type="number"/>

                    <x-forms.input name="colour" :value="$courtesyCar->colour" label="Colour" type="color" />
                </div>

                <x-forms.button text="Update" large />
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
