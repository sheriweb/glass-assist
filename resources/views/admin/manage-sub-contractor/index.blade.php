@php
    $heads = ['Name', 'Edit'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Sub Contractor" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('customer.add-sub-contractors') }}">
                    Add Sub Contractor
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="subContractorsTable"/>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#subContractorsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.manage-sub-contractors') }}",
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
