@php
    $heads = ['Start Date', 'End Date', 'Schedule Time', 'Service Type', 'Note', 'Invoice No', 'Cost', 'Edit', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Vehicle Maintenance Events"/>

            <x-pages.table :heads="$heads">
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td>{{ $event->schedule_time }}</td>
                        <td>{{ $event->service_type }}</td>
                        <td>{{ $event->note }}</td>
                        <td>{{ $event->invoice_ref }}</td>
                        <td>{{ $event->cost }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.edit-vehicle-maintenance-event', $event->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-vehicle-maintenance-event', $event->id) }}">
                                <button class="btn btn-info btn-sm rounded-0" type="button"
                                        data-toggle="tooltip">
                                    Unarchive
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>
        </div>
    </div>
@endsection
