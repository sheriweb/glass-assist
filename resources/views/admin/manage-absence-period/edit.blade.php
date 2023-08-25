@php

    $halfOrFull = [
        (object)[
            'id' => '',
            'name' => 'All Day'
        ],
        (object)[
            'id' => 'am',
            'name' => 'Morning (AM)'
        ],
        (object)[
            'id' => 'pm',
            'name' => 'Afternoon (PM)'
        ]
    ];

@endphp


@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Holiday" back="admin.manage-absence-period"/>

            <x-forms.form route="{{ route('admin.edit-holiday', $holiday->id) }}">
                @method('PUT')

                <x-forms.select :options="$halfOrFull" :selected="$holiday->ampm" label="All Day/Half Day" name="ampm"/>

                @include('shared.absence-type', ['type' => $holiday->type])

                <x-forms.select :options="$staffs" :selected="$holiday->staff_id" name="staff_id" label="Staff" required/>

                <x-forms.input name="date_from" label="Date From" type="datetime-local" :value="$holiday->date_from"/>

                <x-forms.input name="date_to" label="Date To" type="datetime-local" :value="$holiday->date_to"/>

                <x-forms.input name="details" label="Details" type="text" :value="$holiday->details"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#staff_id').select2();
        });
    </script>
@endsection
