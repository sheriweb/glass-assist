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
    ]

@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Event" back="admin.vehicle-maintenance"/>

            <x-forms.form route="{{ route('admin.edit-event', $event->id) }}">
                @method('PUT')

                <x-forms.input name="start_date" label="Start Date" :value="$event->start_date" type="date"/>

                <x-forms.input name="end_date" label="End Date" :value="$event->end_date" type="date"/>

                <x-forms.input name="schedule_time" label="Schedule Time" :value="$event->schedule_time" type="time"/>

                <x-forms.select :options="$types" label="Service Type" :selected="$event->service_type"
                          name="service_type"/>

                <x-forms.textarea label="Notes" name="note" :value="$event->note"/>

                <x-forms.input name="cost" label="Cost" :value="$event->cost"/>

                <x-forms.input name="invoice_ref" label="Invoice Ref" :value="$event->invoice_ref"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#service_type').select2();
        });
    </script>
@endsection
