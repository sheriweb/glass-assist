@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Sub Contractor" back="customer.sub-contractors"/>

            <x-forms.form route="{{ route('customer.add-sub-contractors') }}">
                <div class="row">
                    <x-forms.input label="Name" name="name" required/>

                    <x-forms.input label="Office Phone" name="office_phone"/>

                    <x-forms.input label="Email 1" type="email" name="email1"/>

                    <x-forms.input label="Email 2" type="email" name="email2"/>

                    <x-forms.input label="Email 3" type="email" name="email3"/>

                    <x-forms.input label="Address 1" name="address_1"/>

                    <x-forms.input label="Address 2" name="address_2"/>

                    <x-forms.input label="City" name="city"/>

                    <x-forms.input label="County" name="county"/>

                    <x-forms.input label="Post Code" name="postcode"/>

                    <x-forms.input label="Mobile 1" type="number" name="phone"/>

                    <x-forms.input label="Mobile 2" type="number" name="phone_2"/>
                </div>

                <x-forms.button text="Save" large/>
            </x-forms.form>

        </div>
    </div>
@endsection
