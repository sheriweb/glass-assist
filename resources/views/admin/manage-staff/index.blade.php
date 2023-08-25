@php
    $heads = ['Name', 'Position', '2016', '2017', '2018', '2019', '2020', '2021', '2022', '2023', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Staff" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-manage-staff') }}">
                    Add Staff
                </a>
            </x-pages.header>

            <x-pages.table id="staff_table" :heads="$heads">
                @foreach ($staffs as $staff)
                    <tr>
                        <td>{{ $staff->first_name }} {{ $staff->surname }}</td>
                        <td>{{ $staff->position }}</td>
                        <td>{{ $staff->holiday_entitlement_2016 }}</td>
                        <td>{{ $staff->holiday_entitlement_2017 }}</td>
                        <td>{{ $staff->holiday_entitlement_2018 }}</td>
                        <td>{{ $staff->holiday_entitlement_2019 }}</td>
                        <td>{{ $staff->holiday_entitlement_2020 }}</td>
                        <td>{{ $staff->holiday_entitlement_2021 }}</td>
                        <td>{{ $staff->holiday_entitlement_2022 }}</td>
                        <td>{{ $staff->holiday_entitlement_2023 }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-manage-staff', $staff->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

            {{ $staffs->links() }}

        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            let staffTable = $('#staff_table').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1],[100, 50, 25, 10, "All"]],
                searching: true
            });
        })
    </script>


@endsection

