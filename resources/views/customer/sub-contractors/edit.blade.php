@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Sub Contractor" back="customer.sub-contractors"/>

            <x-forms.form route="{{ route('customer.edit-sub-contractors', $subContractor->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input label="Name" name="name" :value="$subContractor->name" required/>

                    <x-forms.input label="Office Phone" name="office_phone" :value="$subContractor->office_phone"/>

                    <x-forms.input label="Email 1" type="email" name="email1" :value="$subContractor->email1"/>

                    <x-forms.input label="Email 2" type="email" name="email2" :value="$subContractor->email2"/>

                    <x-forms.input label="Email 3" type="email" name="email3" :value="$subContractor->email3"/>

                    <x-forms.input label="Address 1" name="address_1" :value="$subContractor->address_1"/>

                    <x-forms.input label="Address 2" name="address_2" :value="$subContractor->address_2"/>

                    <x-forms.input label="City" name="city" :value="$subContractor->city"/>

                    <x-forms.input label="County" name="county" :value="$subContractor->county"/>

                    <x-forms.input label="Post Code" name="postcode" :value="$subContractor->postcode"/>

                    <x-forms.input label="Mobile 1" type="number" name="phone" :value="$subContractor->phone"/>

                    <x-forms.input label="Mobile 2" type="number" name="phone_2" :value="$subContractor->phone_2"/>
                </div>

                <x-forms.button text="Update" large/>
            </x-forms.form>

        </div>
    </div>
@endsection
