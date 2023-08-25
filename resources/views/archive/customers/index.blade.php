@php
    $heads = ['Company', 'First Name', 'Surname', 'Address Line 1', 'Address Line 2', 'Phone', 'Mobile', 'Edit', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Customers"></x-pages.header>

            <x-pages.table :heads="$heads">
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->company ? $customer->company->name : '' }}</td>
                        <td>{{ $customer->first_name }}</td>
                        <td>{{ $customer->surname }}</td>
                        <td>{{ $customer->address_1 }}</td>
                        <td>{{ $customer->address_2 }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->mobile }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('customer.edit-customer', $customer->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-customer', $customer->id) }}">
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
