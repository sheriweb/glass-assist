@php
    $heads = ['Name', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Glass Supplier" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('customer.add-glass-suppliers') }}">
                    Add Supplier
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads">
                @foreach ($glassSuppliers as $glassSupplier)
                    <tr>
                        <th>{{ $glassSupplier->name }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('customer.edit-glass-suppliers', $glassSupplier->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

            {{ $glassSuppliers->links() }}

        </div>
    </div>
@endsection
