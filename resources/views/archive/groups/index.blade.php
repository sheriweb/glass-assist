@php
    $heads = ['Name', 'Overall Total in Group', 'Total Eligible for Text', 'Total Eligible for Email', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Groups"/>

            <x-pages.table :heads="$heads">
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>{{ $vehicle->count }}</td>
                        <td>{{ $vehicle->eligible_text }}</td>
                        <td>{{ $vehicle->eligible_email }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-group', $vehicle->id) }}">
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
