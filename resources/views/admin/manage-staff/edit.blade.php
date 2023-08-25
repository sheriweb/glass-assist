@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Staff" back="admin.manage-staff"/>

            <x-forms.form route="{{ route('admin.edit-manage-staff', $staff->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input name="first_name" label="First Name" :value="$staff->first_name" required/>

                    <x-forms.input name="surname" label="Surname" :value="$staff->surname"/>

                    <x-forms.input name="position" label="Position" :value="$staff->position"/>

                    <x-forms.input name="holiday_entitlement_2016" label="Holiday Entitlement 2016" type="number"
                             :value="$staff->holiday_entitlement_2016"/>
                    <x-forms.input name="holiday_entitlement_2017" label="Holiday Entitlement 2017" type="number"
                             :value="$staff->holiday_entitlement_2017"/>
                    <x-forms.input name="holiday_entitlement_2018" label="Holiday Entitlement 2018" type="number"
                             :value="$staff->holiday_entitlement_2018"/>
                    <x-forms.input name="holiday_entitlement_2019" label="Holiday Entitlement 2019" type="number"
                             :value="$staff->holiday_entitlement_2019"/>
                    <x-forms.input name="holiday_entitlement_2020" label="Holiday Entitlement 2020" type="number"
                             :value="$staff->holiday_entitlement_2020"/>
                    <x-forms.input name="holiday_entitlement_2021" label="Holiday Entitlement 2021" type="number"
                             :value="$staff->holiday_entitlement_2021"/>
                    <x-forms.input name="holiday_entitlement_2022" label="Holiday Entitlement 2022" type="number"
                             :value="$staff->holiday_entitlement_2022"/>
                    <x-forms.input name="holiday_entitlement_2023" label="Holiday Entitlement 2023" type="number"
                             :value="$staff->holiday_entitlement_2023"/>
                    <x-forms.input name="holiday_entitlement_2024" label="Holiday Entitlement 2024" type="number"
                             :value="$staff->holiday_entitlement_2024"/>
                </div>

                <x-forms.button text="Update" large/>
            </x-forms.form>
        </div>
    </div>
@endsection
