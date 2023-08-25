@php
    $heads = ['Name', 'Type', 'Edit', 'Unarchive'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="[Archive] Categories"/>

            <x-pages.table :heads="$heads">
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->categoryType ? $category->categoryType->name : '' }}</td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('ga-asset.edit-asset-categories', $category->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                            </a>
                        </td>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('archive.unarchive-categories', $category->id) }}">
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
