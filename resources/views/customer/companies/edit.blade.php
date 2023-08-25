@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Company" back="customer.companies"/>

            <x-forms.form route="{{ route('customer.edit-company', $company->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input label="Name" name="name" :value="$company->name" required/>

                    <x-forms.input label="Phone" type="number" name="phone" :value="$company->phone"/>

                    <x-forms.input label="Email" type="email" name="email" :value="$company->email" required/>

                    <x-forms.input label="Address 1" name="address_1" :value="$company->address_1"/>

                    <x-forms.input label="Address 2" name="address_2" :value="$company->address_2"/>

                    <x-forms.input label="City" name="city" :value="$company->city"/>

                    <x-forms.input label="County" name="county" :value="$company->county"/>

                    <x-forms.input label="Post Code" name="postcode" :value="$company->postcode"/>

                    <x-forms.select2 :options="$allCompaniesWithoutCurrent" :selected="$company->parent_company_id" name="parent_company_id" label="Parent Company" optionValue="id" optionName="name"/>
                </div>

                <x-forms.button text="Update" large/>
            </x-forms.form>

        </div>
    </div>
@endsection
@push('selectScripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: 'Select parent company',
                allowClear: true,
            });
        });
    </script>
@endpush
