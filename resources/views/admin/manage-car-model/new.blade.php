@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Car Model" back="admin.manage-car-model"/>

            <x-forms.form route="{{ route('admin.new-manage-car-model') }}">
                <x-forms.input name="name" label="Name" required/>

                <x-forms.select label="Make" name="make_id" :options="$carMakes" default/>

                <x-forms.button text="Submit"/>
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
