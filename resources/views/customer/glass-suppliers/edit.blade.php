@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Glass Supplier" back="customer.glass-suppliers"/>

            <x-forms.form route="{{ route('customer.edit-glass-suppliers', $glassSupplier->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input label="Name" name="name" :value="$glassSupplier->name" required/>

                    <x-forms.input label="Phone" type="number" name="phone" :value="$glassSupplier->phone"/>

                    <x-forms.input label="Email" type="email" name="email" :value="$glassSupplier->email"/>

                    <x-forms.input label="Address 1" name="address_1" :value="$glassSupplier->address_1"/>

                    <x-forms.input label="Address 2" name="address_2" :value="$glassSupplier->address_2"/>

                    <x-forms.input label="City" name="city" :value="$glassSupplier->city"/>

                    <x-forms.input label="Country" name="county" :value="$glassSupplier->county"/>

                    <x-forms.input label="Post Code" name="postcode" :value="$glassSupplier->postcode"/>

                    <x-forms.input label="VAT Number" name="vat" :value="$glassSupplier->vat" required/>
                </div>

                <x-forms.button text="Update" large/>
            </x-forms.form>

        </div>
    </div>
@endsection
