@php
    $heads = ['Date', 'Receipt Group', 'Email Subject', 'Manage'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Groups Mail">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('new-group-email') }}">
                    Send new email
                </a>
            </x-pages.header>

            <x-pages.table :heads="$heads">
                @foreach($groupEmails as $groupEmail)
                    <tr>
                        <th>{{ $groupEmail->date }}</th>
                        <th>{{ $groupEmail->type }}</th>
                        <th>{{ $groupEmail->subject }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('view-group-email', $groupEmail->id) }}">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                        data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-mail-bulk"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-pages.table>
        </div>
    </div>
@endsection
