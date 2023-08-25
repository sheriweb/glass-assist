@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Category" back="ga-asset.asset-categories"/>

            <x-forms.form route="{{ route('ga-asset.edit-asset-categories', $category->id) }}">
                @method('put')

                <x-forms.input label="Name" name="name" :value="$category->name" />

                <x-forms.select label="Type" :options="$types" name="type_id"
                          required default :selected="$category->type_id">
                    <div class="float-end">
                        <a href="{{ route('ga-asset.new-asset-category-type') }}" type="button" target="_blank"
                           class="btn btn-info my-2 my-0">[Add New]</a>
                    </div>
                </x-forms.select>

                <div style="margin-top: 70px">
                    <x-forms.button text="Update"/>
                </div>
            </x-forms.form>

        </div>
    </div>
@endsection
