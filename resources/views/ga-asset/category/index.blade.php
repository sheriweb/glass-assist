@php
    $heads = ['Name', 'Type', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Asset Categories" customClass="mb-2">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('ga-asset.new-asset-categories') }}">
                    Add Category
                </a>
            </x-pages.header>
            <x-pages.table :heads="$heads" id="categoryTable"></x-pages.table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            var table = $('#categoryTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('get.asset-categories') }}",
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
