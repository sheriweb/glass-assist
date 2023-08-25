@php
    $heads = ['Name', 'Edit'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Glass Suppliers">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('customer.add-glass-suppliers') }}">
                    Add Glass Supplier
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="glassSupplierTable"/>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#glassSupplierTable').DataTable({
                "lengthMenu": [[100, "All", 50, 25], [100, "All", 50, 25]],
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer.glass-suppliers') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'name'},
                    {data: 'edit'},
                ]
            });
        });
    </script>
@endsection
