@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Vehicle Maintenance" back="admin.vehicle-maintenance"/>

            <x-forms.form route="{{ route('admin.new-vehicle-maintenance') }}">
                <x-forms.input name="make" label="Make"/>

                <x-forms.input name="model" label="Model"/>

                <x-forms.input name="reg" label="Reg"/>

                <x-forms.input name="vin_number" label="VIN Number"/>

                <x-forms.input name="tyre_size" label="Type Size"/>

                <x-forms.input name="date_of_purchase" label="Date of purchase" type="date"/>

                <x-forms.input name="mot_date" label="MOT Date" type="date"/>

                <x-forms.input name="service_date" label="Service Date" type="date"/>

                <x-forms.input name="insurance_date" label="Insurance Date" type="date"/>

                <x-forms.button text="Submit"/>
            </x-forms.form>

        </div>
    </div>
@endsection
