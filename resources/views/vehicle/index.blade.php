@php
    $heads = ['Vehicle Reg', 'Make', 'Model', 'VIN Number', 'Service Due Date', 'MOT Due Date', 'Edit'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Vehicles">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('add-vehicle') }}">Add
                    Vehicle</a>
                <button type="button" class="btn btn-secondary mr-5">Export</button>
                <button type="button" class="btn btn-secondary">Duplicate</button>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="vehiclesTable"/>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#vehiclesTable').DataTable({
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25,10, "All"]],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('vehicle') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'reg_no'},
                    {data: 'make_id'},
                    {data: 'model_id'},
                    {data: 'vin_number'},
                    {data: 'due_date_1'},
                    {data: 'due_date_2'},
                    {data: 'edit'},
                ]
            });
        });
    </script>
@endsection
