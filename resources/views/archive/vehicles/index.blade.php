@php
    $heads = ['Vehicle Reg', 'Make', 'Model', 'VIN Number', 'Service Due Date', 'MOT Due Date', 'Edit', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Vehicles"/>

            <x-pages.table :heads="$heads">
                @foreach($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->reg_no }}</td>
                        <td>{{ $vehicle->carMake ? $vehicle->carMake->name : '' }}</td>
                        <td>{{ $vehicle->carModel ? $vehicle->carModel->name : '' }}</td>
                        <td>{{ $vehicle->vin_number }}</td>
                        <td>{{ $vehicle->due_date_1 }}</td>
                        <td>{{ $vehicle->due_date_2 }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('edit-vehicle', $vehicle->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-vehicle', $vehicle->id) }}">
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
