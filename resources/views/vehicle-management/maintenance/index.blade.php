@php
    $heads = ['Make', 'Model', 'Reg', 'VIN Number', 'Date of Purchase', 'MOT Date', 'Service Date', 'Insurance Date', 'Action'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Vehicle Maintenance"/>

            <x-pages.table :heads="$heads" id="datatable2">
                @foreach($vehicleManagements as $vehicleManagement)
                    <tr>
                        <td>{{ $vehicleManagement->make }}</td>
                        <td>{{ $vehicleManagement->model }}</td>
                        <td>{{ $vehicleManagement->reg }}</td>
                        <td>{{ $vehicleManagement->vin_number }}</td>
                        <td>{{ $vehicleManagement->date_of_purchase }}</td>
                        <td>{{ $vehicleManagement->mot_date }}</td>
                        <td>{{ $vehicleManagement->service_date }}</td>
                        <td>{{ $vehicleManagement->insurance_date }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('vehicle-management.edit-management', $vehicleManagement->id) }}">
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
        $(document).ready(function() {
            $('#datatable2').DataTable();
        });
    </script>
@endsection

