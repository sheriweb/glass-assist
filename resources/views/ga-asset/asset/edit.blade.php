@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Asset" back="ga-asset.asset"/>

            <x-forms.form route="{{ route('ga-asset.edit-asset', $asset->id) }}" media>
                @method('put')

                <x-forms.input label="Name" name="name" :value="$asset->name"/>

                <x-forms.select id="asset-category" label="Type" :options="$types" name="type_id"
                                required default :selected="$asset->type_id">
                    <div class="float-end">
                        <a href="{{ route('ga-asset.new-asset-category-type') }}" type="button" target="_blank"
                           class="btn btn-info my-2 my-0">[Add New]</a>
                    </div>
                </x-forms.select>

                <x-forms.input label="Review Date" type="date" name="review_date" :value="$asset->review_date"/>

                <x-forms.input label="Price" type="number" name="price" :value="$asset->price"/>

                <x-forms.textarea label="Description" name="description" :value="$asset->description"/>

                @if($asset->image)
                    <img height="200" src="{{ asset('files/' . $asset->image) }}" alt="image preview">
                @endif

                <x-forms.input label="Attach Image" type="file" name="image" :value="$asset->image"/>

                <x-forms.input label="Attach File" type="file" name="file_name" :value="$asset->file_name"/>

                <div style="margin-top: 70px">
                    <x-forms.button text="Update"/>
                </div>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#asset-category').select2();
        });
    </script>
@endsection
