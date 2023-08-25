@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Customer" back="customer"/>

            <x-forms.form route="{{ route('customer.add-customer') }}">

                <div class="row">
                    <x-forms.select label="Company Name" :options="$companies" name="company_name"
                              required default>
                        <div class="float-end">
                            <a href="{{ route('customer.add-company') }}" type="button" target="_blank"
                               class="btn btn-info my-2 my-0">[Add New]</a>
                        </div>
                    </x-forms.select>

                    <x-forms.input label="Phone" name="phone" type="number"/>

                    <x-forms.input label="Business/Title" name="title"/>

                    <x-forms.input label="Fax" name="fax"/>

                    <x-forms.input label="First Name" name="first_name" required/>

                    <x-forms.input label="Mobile" name="mobile"/>

                    <x-forms.input label="Surname" name="surname" required/>

                    <x-forms.input label="Email" name="email" type="email" required/>

                    <x-forms.input label="Address 1" name="address_1"/>

                    <x-forms.textarea label="Notes" name="notes"/>

                    <x-forms.input label="Address 2" name="address_2"/>

                    <x-forms.input label="Link" name="link"/>

                    <x-forms.input label="City" name="city"/>

                    <x-forms.checkbox label="Send Text" name="send_text"/>

                    <x-forms.input label="Country" name="country"/>

                    <x-forms.checkbox label="Send Email" name="send_email"/>

                    <x-forms.input label="Post Code" name="postcode"/>

                    <x-forms.input label="Date Of Birth" type="date" name="dob"/>
                </div>

                @include('shared.group-select', ['groups' => $groups])

                <x-forms.button text="Save" large/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#company_name').select2();
        });
    </script>
@endsection
