@php
    $heads = ['Name','Address_1', 'Address_2','City','County','Postcode', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Companies" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('customer.add-company') }}">
                    Add Company
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="companiesTable"/>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#companiesTable').DataTable({
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.manage-companies') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'name'},
                    {data: 'address_1'},
                    {data: 'address_2'},
                    {data: 'city'},
                    {data: 'county'},
                    {data: 'postcode'},
                    {data: 'edit'},
                ]
            });
        });
    </script>
@endsection
