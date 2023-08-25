@php
    $heads = ['Surname', 'First Name', 'Company', 'Address', 'Postcode', 'Mobile', 'Edit', 'Send'];
@endphp

@extends('master')

@section('content')
    <style>
        .dataTables_wrapper .dt-buttons {
            float:none;
            text-align:right;
            margin-left: 76%;
            margin-top: -148px;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Customers">
                <a type="button" class="btn btn-secondary ml-30" href="{{ route('customer.add-customer') }}">Add
                    Customer</a>
                {{--<button type="button" class="btn btn-secondary mr-5">Export</button>--}}
                <button type="button" class="btn btn-secondary mr-10">Duplicate</button>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="customerTable" class="display nowrap" />
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#customerTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', text: 'Export' }
                ],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'surname'},
                    {data: 'firstName'},
                    {data: 'company'},
                    {data: 'address'},
                    {data: 'postcode'},
                    {data: 'mobile'},
                    {data: 'edit'},
                    {data: 'send'},
                ]
            });
        });
    </script>
@endsection

