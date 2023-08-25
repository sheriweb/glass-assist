@php
    $heads = ['Job No', 'Inv Date', 'Co Name', 'Last Name', 'Total Ex VAT', 'Total inc VAT', 'VAT Amount', 'Non-VAT Amount', 'Gross Total'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Income Report" back="admin"/>

            <x-pages.card>
                <x-forms.form route="{{ route('admin.invoice-income-report') }}" simple>
                    <x-forms.input type="date" label="Start" name="start" required/>

                    <x-forms.input type="date" label="End" name="end" required/>

                    <x-forms.button text="Generate Report"/>
                </x-forms.form>
            </x-pages.card>

        </div>
    </div>
@endsection
