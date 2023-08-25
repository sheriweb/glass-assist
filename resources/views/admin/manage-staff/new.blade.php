@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Staff" back="admin.manage-staff"/>

            <x-forms.form route="{{ route('admin.new-manage-staff') }}">

                <div class="row">
                    <x-forms.input name="first_name" label="First Name" required/>

                    <x-forms.input name="surname" label="Surname"/>

                    <x-forms.input name="position" label="Position"/>

                    <x-forms.input name="holiday_entitlement_2016" label="Holiday Entitlement 2016" type="number"/>
                    <x-forms.input name="holiday_entitlement_2017" label="Holiday Entitlement 2017" type="number"/>
                    <x-forms.input name="holiday_entitlement_2018" label="Holiday Entitlement 2018" type="number"/>
                    <x-forms.input name="holiday_entitlement_2019" label="Holiday Entitlement 2019" type="number"/>
                    <x-forms.input name="holiday_entitlement_2020" label="Holiday Entitlement 2020" type="number"/>
                    <x-forms.input name="holiday_entitlement_2021" label="Holiday Entitlement 2021" type="number"/>
                    <x-forms.input name="holiday_entitlement_2022" label="Holiday Entitlement 2022" type="number"/>
                    <x-forms.input name="holiday_entitlement_2023" label="Holiday Entitlement 2023" type="number"/>
                    <x-forms.input name="holiday_entitlement_2024" label="Holiday Entitlement 2024" type="number"/>
                </div>

                <x-forms.button text="Submit"/>
            </x-forms.form>
        </div>
    </div>
@endsection
