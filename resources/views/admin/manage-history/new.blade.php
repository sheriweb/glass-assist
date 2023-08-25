@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add History" back="admin.manage-history"/>

            <x-forms.form route="{{ route('admin.new-manage-history') }}">
                <x-forms.input name="name" label="Name" required/>

                <x-forms.button text="Save"/>
            </x-forms.form>

        </div>
    </div>
@endsection
