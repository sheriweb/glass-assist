@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="New Bank Holiday" back="admin.manage-bank-holiday"/>

            <x-forms.form route="{{ route('admin.add-manage-bank-holiday') }}">
                <x-forms.input name="date_from" type="datetime-local" label="Date From" required/>

                <x-forms.input name="date_to" type="datetime-local" label="Date To" required/>

                <x-forms.input name="details" label="Details"/>

                <x-forms.button text="Save"/>
            </x-forms.form>

        </div>
    </div>
@endsection
