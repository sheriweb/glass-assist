@php
    $heads = ['Name', 'Edit']
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header :title="Str::plural(auth()->user()->tag_item)" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-manage-history') }}">
                    Add {{ auth()->user()->tag_item }}
                </a>
            </x-pages.header>

            <x-pages.table id="manage_history" :heads="$heads">
                @foreach($items as $item)
                    <tr>
                        <th>{{ $item->name }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-manage-history', $item->id) }}">
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
        $(document).ready(function (){
            let historyTable = $('#manage_history').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]],
                searching: true,
            });

            historyTable.columns.adjust().draw();
        });
    </script>
@endsection
