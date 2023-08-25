@php
    $heads = ['ID', 'Amount', 'Type', 'Invoice Date', 'View'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Payment List" back="admin"/>

            <x-pages.table :heads="$heads">
                @foreach ($orders as $order)
                    <tr>
                        <th>{{ $order->id }}</th>
                        <th>{{ $order->amt }}</th>
                        <th>{{ $order->type }}</th>
                        <th>{{ $order->date_added }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="/pdf/invoice?order_id={{ $order->id }}" target="_blank">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit">View
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

        </div>
    </div>
@endsection
