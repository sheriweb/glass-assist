@php
    $heads = ['Date From', 'Date To', 'Details', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Bank Holidays" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.add-manage-bank-holiday') }}">
                    Add a Bank Holiday
                </a>
            </x-pages.header>

            <x-pages.table id="manage_bank_holiday" :heads="$heads">
                @foreach ($bankHolidays as $bankHoliday)
                    <tr>
                        <th>{{ $bankHoliday->date_from }}</th>
                        <th>{{ $bankHoliday->date_to }}</th>
                        <th>{{ $bankHoliday->details }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-manage-bank-holiday', $bankHoliday->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>

            {{ $bankHolidays->links() }}

        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function () {
            manageBankTable = $('#manage_bank_holiday').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu:  [[100, 50, 25, 10, -1],[100, 50, 25, 10, "All"]],
                searching: true
            });
        })
    </script>

@endsection

