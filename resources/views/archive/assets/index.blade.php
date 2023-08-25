@php
    $heads = ['ID', 'Category', 'Name', 'Type', 'Date', 'Image', 'File', 'Edit', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Assets"/>

            <x-pages.table :heads="$heads">
                @foreach($assets as $asset)
                    <tr>
                        <td>{{ $asset->id }}</td>
                        <td>{{ $asset->category ? $asset->category->name : '' }}</td>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->categoryType ? $asset->categoryType->name : '' }}</td>
                        <td>{{ $asset->review_date }}</td>
                        <td>{{ $asset->image }}</td>
                        <td>{{ $asset->file_name }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('ga-asset.edit-asset', $asset->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-assets', $asset->id) }}">
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
