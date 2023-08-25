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
            <x-pages.header title="New Holiday" back="admin.manage-absence-period"/>

            <x-forms.form route="{{ route('admin.new-holiday') }}">

                <x-forms.select :options="$halfOrFull" label="All Day/Half Day" name="ampm"/>

                @include('shared.absence-type', ['type' => ''])

                <x-forms.select :options="$staffs" name="staff_id" label="Staff" default required/>

                <x-forms.input name="date_from" label="Date From" type="datetime-local"/>

                <x-forms.input name="date_to" label="Date To" type="datetime-local"/>

                <x-forms.input name="details" label="Details" type="text"/>

                <x-forms.button text="Save"/>
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
