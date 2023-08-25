@extends('master')
@php
    $heads = ['ID', 'Type', 'Name', 'Image', 'Description', 'Review Date', 'Price', 'File', 'Edit'];
@endphp
@section('content')
    <style>
        .select2.select2-container{
            width: 100% !important;
        }
        .type_class{
            display: block !important;
        }
        .type_container button{
            font-size: 10px;
        }
        .asset_name_container{
            margin-top: 10px !important;
        }
        .modal-content.change-color {
            background: #6c757d;
            border: none;
        }
        .category_type_modal_title{
            color: white !important;
        }
        .category_type_container label{
            color: white;
        }
    </style>
    @include('ga-asset.asset.asset-modal',[$types])
    @include('ga-asset.category-type.category-type-modal');
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="{{ $headerTitle }}" customClass="mb-2">
                <a type="button" class="btn btn-secondary mr-5 add_new_asset" href="javascript:void(0)">
                    Add Asset
                </a>
            </x-pages.header>
            <x-pages.table :heads="$heads" id="categoryAssetTable"></x-pages.table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('#type_id').select2({
                dropdownParent: $('#asset_modal')
            });
            let assetCategoryId = {{ $assetCategoryId }};
            let route = `/asset/category/${assetCategoryId}/list`;
            var table = $('#categoryAssetTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: route,
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'type', name: 'type'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'description', name: 'description'},
                    {data: 'review_date', name: 'review_date'},
                    {data: 'price', name: 'price'},
                    {data: 'file_name', name: 'file_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            let addNewAssetButton = document.querySelector('.add_new_asset');
            let saveNewAssetButton = document.querySelector('#save_asset_button');
            let addNewCategoryTypeButton = document.querySelector('.add_new_category_type_button');
            addNewAssetButton.addEventListener('click', function () {
                handleAddNewAssetButtonClick(event);
            });
            addNewCategoryTypeButton.addEventListener('click', function () {
                $('#category_type_modal').modal('show');
            });
            function handleAddNewAssetButtonClick() {
                let assetForm = document.querySelector('#add_new_asset_form');
                $('#add_new_asset_form_title').html('Add New Asset');
                $('#save_asset_button .indicator-label').html('Save');
                assetForm.reset();
                $('#asset_modal').modal('show');
            }
        });
    </script>
@endsection
