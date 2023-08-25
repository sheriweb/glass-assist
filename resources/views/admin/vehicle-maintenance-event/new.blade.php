@php

    $types = [
        (object)[
            'id' => 'MOT',
            'name' => 'MOT'
        ],
        (object)[
            'id' => 'Service',
            'name' => 'Service'
        ],
        (object)[
            'id' => 'Repair',
            'name' => 'Repair'
        ],
        (object)[
            'id' => 'Tyres',
            'name' => 'Tyres'
        ],
        (object)[
            'id' => 'Breaks',
            'name' => 'Breaks'
        ],
    ];

@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Event" back="admin.vehicle-maintenance"/>

            <x-forms.form route="{{ route('admin.new-event', $id) }}">
                <x-forms.input name="start_date" label="Start Date" type="date"/>

                <x-forms.input name="end_date" label="End Date" type="date"/>

                <x-forms.input name="schedule_time" label="Schedule Time" type="time"/>

                <x-forms.select :options="$types" label="Service Type" name="service_type"/>

                <x-forms.textarea label="Notes" name="note"/>

                <x-forms.input name="cost" label="Cost"/>

                <x-forms.input name="invoice_ref" label="Invoice Ref"/>

                <x-forms.button text="Submit"/>
            </x-forms.form>

        </div>
    </div>
@endsection
