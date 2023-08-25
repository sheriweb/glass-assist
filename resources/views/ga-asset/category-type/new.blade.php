@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Category Type" back="ga-asset.new-asset-categories"/>

            <x-forms.form route="{{ route('ga-asset.new-asset-category-type') }}">
                <x-forms.input label="Name" name="name" required/>
                <div style="margin-top: 70px">
                    <x-forms.button text="Save"/>
                </div>
            </x-forms.form>

        </div>
    </div>
@endsection
