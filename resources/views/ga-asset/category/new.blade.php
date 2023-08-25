@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Category" back="ga-asset.asset-categories"/>

            <x-forms.form route="{{ route('ga-asset.new-asset-categories') }}">
                <x-forms.input label="Name" name="name" required/>

                <x-forms.select label="Type" :options="$types" name="type_id"
                          required default>
                    <div class="float-end">
                        <a href="{{ route('ga-asset.new-asset-category-type') }}" type="button" target="_blank"
                           class="btn btn-info my-2 my-0">[Add New]</a>
                    </div>
                </x-forms.select>

                <div style="margin-top: 70px">
                    <x-forms.button text="Save"/>
                </div>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#type_id').select2();
        });
    </script>
@endsection
