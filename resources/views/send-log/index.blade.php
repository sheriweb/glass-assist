@php
    $heads = ['Type', 'Date', 'Customer', 'Recipient', 'Message'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Send Log"/>

            <x-pages.table :heads="$heads" id="sendLogsTable"/>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#sendLogsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('send-log') }}",
                    dataType: "json",
                    type: "GET",
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
                },
                columns: [
                    {data: 'type'},
                    {data: 'dateSent'},
                    {data: 'customer'},
                    {data: 'recipient'},
                    {data: 'message'},
                ]
            });
        });
    </script>
@endsection
