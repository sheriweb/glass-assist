@php
    $heads = ['Job No', 'Inv Date', 'Co Name', 'Last Name', 'Total Ex VAT', 'Total Inc VAT', 'VAT Amount', 'Non-VAT Amount', 'Gross Total'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Invoices Income Report" back="admin"/>

            <x-pages.card>
                <x-forms.form route="{{ route('admin.invoice-income-report') }}" simple>
                    <x-forms.input type="date" label="Start" name="start" :value="$start" required/>

                    <x-forms.input type="date" label="End" name="end" :value="$end" required/>

                    <x-forms.button text="Generate Report"/>
                </x-forms.form>

                <div class="mt-5"></div>

                <x-pages.table :heads="$heads" id="invoiceDatatable" simple>
                    @foreach($vehicleHistoryInvoices as $vehicleHistoryInvoice)
                        <tr>
                            <td>{{ $vehicleHistoryInvoice->id }}</td>
                            <td>{{ $vehicleHistoryInvoice->datetime }}</td>
                            <td>{{ $vehicleHistoryInvoice->company ? $vehicleHistoryInvoice->company->name : ''  }}</td>
                            <td>{{ $vehicleHistoryInvoice->surname }}</td>
                            <td>{{ $vehicleHistoryInvoice->total_ex_vat }}</td>
                            <td>{{ $vehicleHistoryInvoice->total_inc_vat }}</td>
                            <td>{{ $vehicleHistoryInvoice->vat }}</td>
                            <td>{{ $vehicleHistoryInvoice->non_vat }}</td>
                            <td>{{ $vehicleHistoryInvoice->gross_total }}</td>
                        </tr>
                    @endforeach
                </x-pages.table>

                {{ $vehicleHistoryInvoices->links() }}
            </x-pages.card>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#invoiceDatatable').DataTable({
                paging: false,
                info: false,
            });
        });
    </script>
@endsection
