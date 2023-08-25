@php
    $heads = ['Make', 'Model', 'Reg', 'VIN Number', 'Date of Purchase', 'MOT Date', 'Service Date', 'Insurance Date', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Vehicle Maintenance" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-vehicle-maintenance') }}">
                    Add Vehicle Maintenance
                </a>
            </x-pages.header>

            <x-pages.table id="vehicle_maintenance" :heads="$heads">
                @foreach ($vehicleMaintenances as $vehicleMaintenance)
                    <tr>
                        <td>{{ $vehicleMaintenance->make }}</td>
                        <td>{{ $vehicleMaintenance->model }}</td>
                        <td>{{ $vehicleMaintenance->reg }}</td>
                        <td>{{ $vehicleMaintenance->vin_number }}</td>
                        <td>{{ $vehicleMaintenance->date_of_purchase }}</td>
                        <td>{{ $vehicleMaintenance->mot_date }}</td>
                        <td>{{ $vehicleMaintenance->service_date }}</td>
                        <td>{{ $vehicleMaintenance->insurance_date }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-vehicle-maintenance', $vehicleMaintenance->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            $('#vehicle_maintenance').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]]
            });
        });
    </script>
@endsection

