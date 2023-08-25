@php
    $heads = ['Name', 'User Name', 'Email', 'Access Level', 'Edit'];
@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Manage User" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-manage-users') }}">
                    Add Sub User
                </a>
            </x-pages.header>

            <x-pages.table id="manage_sub_user" :heads="$heads">
                @foreach ($users as $user)
                    <tr>
                        <th>{{ $user->name }}</th>
                        <th>{{ $user->username }}</th>
                        <th>{{ $user->email }}</th>
                        <th>{{ $user->access_level }}</th>
                        <td>
                            <a class="list-inline-item"
                               href="{{ route('admin.edit-manage-users', $user->id) }}">
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
            let categoryTable = $('#manage_sub_user').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]],
                searching: true,
            });

            categoryTable.columns.adjust().draw();
        });
    </script>
@endsection

