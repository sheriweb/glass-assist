@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Companies" back="customer.companies"/>

            <x-forms.form route="{{ route('customer.add-company') }}">
                <div class="row">
                    <x-forms.input label="Name" name="name" required/>

                    <x-forms.input label="Phone" type="number" name="phone"/>

                    <x-forms.input label="Email" type="email" name="email" required/>

                    <x-forms.input label="Address 1" name="address_1"/>

                    <x-forms.input label="Address 2" name="address_2"/>

                    <x-forms.input label="City" name="city"/>

                    <x-forms.input label="County" name="county"/>

                    <x-forms.input label="Post Code" name="postcode"/>

                    <x-forms.select2 :options="$companies" :selected="null" name="parent_company_id" label="Parent Company" optionValue="id" optionName="name"/>
                </div>

                <x-forms.button text="Save" large/>
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
