@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Vehicle Maintenances">
                <a type="button" class="btn btn-secondary mr-5"
                   href="{{ route('vehicle-management.new-management') }}">
                    Add Vehicle Maintenance
                </a>
            </x-pages.header>

            <div class="card">
                <div class="card-body">
                    <h3>Due in 30 Days</h3>
                    <table id="datatable"
                           class="table table-bordered dt-responsive nowrap bg-white rounded vehicle-maintainenece"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            <th scope="col">Reg</th>
                            <th scope="col">VIN Number</th>
                            <th scope="col">Date of Purchase</th>
                            <th scope="col">MOT Date</th>
                            <th scope="col">Service Date</th>
                            <th scope="col">Insurance Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicleManagements as $vehicleManagement)
                            <tr>
                                <th>{{ $vehicleManagement->make }}</th>
                                <th>{{ $vehicleManagement->model }}</th>
                                <th>{{ $vehicleManagement->reg }}</th>
                                <th>{{ $vehicleManagement->vin_number }}</th>
                                <th>{{ $vehicleManagement->date_of_purchase }}</th>
                                <th>{{ $vehicleManagement->mot_date }}</th>
                                <th>{{ $vehicleManagement->service_date }}</th>
                                <th>{{ $vehicleManagement->insurance_date }}</th>
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3>Over Due</h3>

                    <table id="datatable2" class="table table-bordered dt-responsive"
                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">Make</th>
                            <th scope="col">Model</th>
                            <th scope="col">Reg</th>
                            <th scope="col">VIN Number</th>
                            <th scope="col">Date of Purchase</th>
                            <th scope="col">MOT Date</th>
                            <th scope="col">Service Date</th>
                            <th scope="col">Insurance Date</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($vehicleManagementsOverDue as $vehicleManagement)
                            <tr>
                                <th>{{ $vehicleManagement->make }}</th>
                                <th>{{ $vehicleManagement->model }}</th>
                                <th>{{ $vehicleManagement->reg }}</th>
                                <th>{{ $vehicleManagement->vin_number }}</th>
                                <th>{{ $vehicleManagement->date_of_purchase }}</th>
                                <th>{{ $vehicleManagement->mot_date }}</th>
                                <th>{{ $vehicleManagement->service_date }}</th>
                                <th>{{ $vehicleManagement->insurance_date }}</th>
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

