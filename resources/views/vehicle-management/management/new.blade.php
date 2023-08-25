@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Vehicle Maintenance" back="vehicle-management"/>

            <x-forms.form route="{{ route('vehicle-management.new-management') }}">
                <x-forms.input label="Make" name="make"/>

                <x-forms.input label="Mode" name="model"/>

                <x-forms.input label="Reg" name="reg"/>

                <x-forms.input label="VIN Number" name="vin_number"/>

                <x-forms.input label="Type Size" name="tyre_size"/>

                <x-forms.input label="Date of Purchase" type="date" name="date_of_purchase"/>

                <x-forms.input label="MOT Date" type="date" name="mot_date"/>

                <x-forms.input label="Service Date" type="date" name="service_date"/>

                <x-forms.input label="Warranty Date" name="warranty_date"/>

                <x-forms.input label="Insurance Date" name="insurance_date"/>

                <x-forms.button text="Save"/>
            </x-forms.form>

        </div>
    </div>
@endsection
