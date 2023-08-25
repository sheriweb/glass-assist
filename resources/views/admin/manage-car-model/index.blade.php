@php
    $heads = ['Model', 'Make', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Car Model" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-manage-car-model') }}">
                    Add Car Model
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="carModelTable"/>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#carModelTable').DataTable({
                processing: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]],
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.manage-car-model') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'name'},
                    {data: 'make'},
                    {data: 'edit'},
                ]
            });
        });
    </script>
@endsection
