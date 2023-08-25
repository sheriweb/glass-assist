@php
    $heads = ['Name', 'Make', 'Model', 'Reg No', 'Colour', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Courtesy Car" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-courtesy-car') }}">
                    Add Courtesy Car
                </a>
            </x-pages.header>

            <x-pages.table id="manage_courtesy_car" :heads="$heads">
                @foreach ($courtesyCars as $courtesyCar)
                    <tr>
                        <th>{{ $courtesyCar->name }}</th>
                        <td>{{ $courtesyCar->carMake ? $courtesyCar->carMake->name : '' }}</td>
                        <td>{{ $courtesyCar->carModel ? $courtesyCar->carModel->name : '' }}</td>
                        <td>{{ $courtesyCar->reg_no }}</td>
                        <td>{{ $courtesyCar->colour }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-manage-courtesy-car', $courtesyCar->id) }}">
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
        $(document).ready(function () {
            let courtesyCarTable = $('#manage_courtesy_car').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1],[100, 50, 25, 10, "All"]],
                searching: true
            });
        })
    </script>
@endsection

