@php

    $cards = [
        [
            'title' => 'Update System Settings',
            'route' => 'admin.update-settings',
            'icon'  => 'ri-bubble-chart-line'
        ],
        [
            'title' => 'Change Password',
            'route' => 'admin.change-password',
            'icon'  => 'ri-lock-password-fill'
        ],
        [
            'title' => 'Buy Text(SMS) Credits',
            'route' => 'admin.buy-text-credit',
            'icon'  => 'ri-mail-open-fill'
        ],
        [
            'title' => 'Manage ' . auth()->user()->tag_item,
            'route' => 'admin.manage-history',
            'icon'  => 'ri-folder-history-line'
        ],
        [
            'title' => 'Manage Courtesy Cars',
            'route' => 'admin.manage-courtesy-car',
            'icon'  => 'ri-car-washing-line'
        ],
        [
            'title' => 'Manage Car Makes',
            'route' => 'admin.manage-car-make',
            'icon'  => 'ri-car-line'
        ],
        [
            'title' => 'Manage Car Models',
            'route' => 'admin.manage-car-model',
            'icon'  => 'ri-car-line'
        ],
        [
            'title' => 'Manage Users',
            'route' => 'admin.manage-users',
            'icon'  => 'ri-file-user-fill'
        ],
        [
            'title' => 'Manage Staff',
            'route' => 'admin.manage-staff',
            'icon'  => 'ri-shield-user-line'
        ],
        [
            'title' => 'Vehicle Maintenance',
            'route' => 'admin.vehicle-maintenance',
            'icon'  => 'ri-taxi-wifi-line'
        ],
        [
            'title' => 'Manage Companies',
            'route' => 'admin.manage-companies',
            'icon'  => 'ri-community-fill'
        ],
        [
            'title' => 'Manage Glass Suppliers',
            'route' => 'admin.manage-glass-supplier',
            'icon'  => 'ri-parent-fill'
        ],
        [
            'title' => 'Manage Sub Contractors',
            'route' => 'admin.manage-sub-contractors',
            'icon'  => 'ri-parent-fill'
        ],
        [
            'title' => 'Manage Bank Holidays',
            'route' => 'admin.manage-bank-holiday',
            'icon'  => 'ri-bank-fill'
        ],
        [
            'title' => 'Manage Absence Periods',
            'route' => 'admin.manage-absence-period',
            'icon'  => 'ri-markup-fill'
        ],
        [
            'title' => 'View ICOMSS Invoices',
            'route' => 'admin.view-icomss-invoices',
            'icon'  => 'ri-invision-line'
        ],
        [
            'title' => 'Upload Logo',
            'route' => 'admin.upload-logo',
            'icon'  => 'ri-file-upload-fill'
        ],
        [
            'title' => 'Income Report',
            'route' => 'admin.income-report',
            'icon'  => 'ri-git-repository-line'
        ],
        [
            'title' => 'Invoice Income Report',
            'route' => 'admin.invoice-income-report',
            'icon'  => 'ri-git-repository-line'
        ],
    ];

@endphp

@extends('master')

@section('content')
    <style>
        .admin-card-heading-color {
            color: #6c757d !important;
            text-align: center !important;
        }

        .avatar-sm {
            margin-left: 40%;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Admin</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Admin</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach($cards as $card)
                    <x-admin-card :title="$card['title']" :route="$card['route']" :icon="$card['icon']"/>
                @endforeach

            </div>
        </div>
    </div>
@endsection
