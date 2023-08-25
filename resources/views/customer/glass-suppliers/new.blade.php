@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Glass Supplier" back="customer.glass-suppliers"/>

            <x-forms.form route="{{ route('customer.add-glass-suppliers') }}">

                <div class="row">
                    <x-forms.input label="Name" name="name" required/>

                    <x-forms.input label="Phone" type="number" name="phone"/>

                    <x-forms.input label="Email" type="email" name="email"/>

                    <x-forms.input label="Address 1" name="address_1"/>

                    <x-forms.input label="Address 2" name="address_2"/>

                    <x-forms.input label="City" name="city"/>

                    <x-forms.input label="Country" name="county"/>

                    <x-forms.input label="Post Code" name="postcode"/>

                    <x-forms.input label="VAT Number" name="vat" required/>
                </div>

                <x-forms.button text="Save" large/>
            </x-forms.form>

        </div>
    </div>
@endsection
