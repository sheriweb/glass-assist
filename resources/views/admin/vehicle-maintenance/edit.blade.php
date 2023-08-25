@php
    $heads = ['Event', 'Start Date', 'End Date', 'Service Type', 'Note', 'Invoice No', 'Cost', 'Edit/Archive'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Vehicle Maintenance" back="admin"/>

            <x-forms.form route="{{ route('admin.edit-vehicle-maintenance', $vehicleMaintenance->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.input name="make" label="Make" :value="$vehicleMaintenance->make"/>

                    <x-forms.input name="model" label="Model" :value="$vehicleMaintenance->model"/>

                    <x-forms.input name="reg" label="Reg" :value="$vehicleMaintenance->reg"/>

                    <x-forms.input name="vin_number" label="VIN Number" :value="$vehicleMaintenance->vin_number"/>

                    <x-forms.input name="tyre_size" label="Type Size" :value="$vehicleMaintenance->tyre_size"/>

                    <x-forms.input name="date_of_purchase" label="Date of purchase"
                             :value="$vehicleMaintenance->date_of_purchase"
                             type="date"/>

                    <x-forms.input name="mot_date" label="MOT Date" :value="$vehicleMaintenance->mot_date" type="date"/>

                    <x-forms.input name="service_date" label="Service Date" :value="$vehicleMaintenance->service_date"
                             type="date"/>

                    <x-forms.input name="insurance_date" label="Insurance Date" :value="$vehicleMaintenance->insurance_date"
                             type="date"/>

                    <x-forms.select name="user_id" :options="$users" :selected="$vehicleMaintenance->user_id"
                              label="Linked User"/>
                </div>

                <x-forms.button text="Update"/>

            </x-forms.form>

            <div class="d-flex justify-content-between mb-2">
                <div class="float-right">
                    <a type="button" class="btn btn-secondary mr-5"
                       href="{{ route('admin.new-event', $vehicleMaintenance->id) }}">Add Event</a>
                </div>
            </div>

            <x-pages.table :heads="$heads">
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td>{{ $event->service_type }}</td>
                        <td>{{ $event->note }}</td>
                        <td>{{ $event->invoice_ref }}</td>
                        <td>{{ $event->cost }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-event', $event->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>

                            <div class="list-inline-item">
                                <form action="{{ route('admin.edit-event', $event->id) }}" method="post">
                                    <button class="btn btn-danger btn-sm rounded-0" type="submit"
                                            data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fa fa-trash"></i></button>
                                    @method('delete')
                                    @csrf
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

        </div>
    </div>
@endsection
