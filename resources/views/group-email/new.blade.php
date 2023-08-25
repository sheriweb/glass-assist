@php

    $group = [
        (object)[
            'id' => 'users',
            'name' => 'Users'
        ],
        (object)[
            'id' => 'staff',
            'name' => 'Staff'
        ],
        (object)[
            'id' => 'companies',
            'name' => 'Companies'
        ],
        (object)[
            'id' => 'subcontractors',
            'name' => 'Sub Contractors'
        ],
        (object)[
            'id' => 'glass_suppliers',
            'name' => 'Glass Suppliers'
        ],
    ];

@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Send New Email" back="group-email"/>

            <x-forms.form route="{{ route('new-group-email') }}">
                <x-forms.select  label="Group" name="group" :options="$group"/>

                <x-forms.input label="Subject" name="subject" required/>

                <x-forms.input label="Attach File" type="file" name="file"/>

                <div class="mt-4"></div>

                <x-tinymce-editor name="body"/>

                <x-forms.button text="Send"/>
            </x-forms.form>
        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#group').select2();
        });
    </script>
@endsection
