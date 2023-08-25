@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3>Due in 30 Days</h3>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap bg-white rounded"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">Event Item ID #</th>
                            <th scope="col">Date Scheduled</th>
                            <th scope="col">Vehicle Name</th>
                            <th scope="col">Reg</th>
                            <th scope="col">Types of Events</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicleEvents as $vehicleEvent)
                            <tr>
                                <th>{{ $vehicleEvent->id }}</th>
                                <th>{{ $vehicleEvent->start_date }}</th>
                                <th>{{ $vehicleEvent->vehicleMaintenance->make }} {{ $vehicleEvent->vehicleMaintenance->model }}</th>
                                <th>{{ $vehicleEvent->vehicleMaintenance->reg }}</th>
                                <th>{{ $vehicleEvent->service_type }}</th>
                                <td>
                                    <a class="list-inline-item"
                                       href="{{ route('vehicle-event.edit', $vehicleEvent->id) }}">
                                        <button class="btn btn-success btn-sm rounded-0" type="button"
                                                data-toggle="tooltip"
                                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Over Due</h3>

                    <table id="datatable2" class="table table-bordered dt-responsive nowrap bg-white rounded"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">Event Item ID #</th>
                            <th scope="col">Date Scheduled</th>
                            <th scope="col">Vehicle Name</th>
                            <th scope="col">Reg</th>
                            <th scope="col">Types of Events</th>
                            <th scope="col">Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicleEventsOverDue as $vehicleEvent)
                            <tr>
                                <th>{{ $vehicleEvent->id }}</th>
                                <th>{{ $vehicleEvent->start_date }}</th>
                                <th>{{ $vehicleEvent->vehicleMaintenance->make }} {{ $vehicleEvent->vehicleMaintenance->model }}</th>
                                <th>{{ $vehicleEvent->vehicleMaintenance->reg }}</th>
                                <th>{{ $vehicleEvent->service_type }}</th>
                                <td>
                                    <a class="list-inline-item"
                                       href="{{ route('vehicle-event.edit', $vehicleEvent->id) }}">
                                        <button class="btn btn-success btn-sm rounded-0" type="button"
                                                data-toggle="tooltip"
                                                data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#datatable2').DataTable();
        });
    </script>
@endsection

