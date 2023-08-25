@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit {{ auth()->user()->tag_item }}" back="admin.manage-history"/>

            <x-forms.form route="{{ route('admin.edit-manage-history', $item->id) }}">
                @method('PUT')

                <x-forms.input name="name" :value="$item->name" label="Name"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection
