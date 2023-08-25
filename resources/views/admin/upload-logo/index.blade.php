@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Upload Logo" back="admin"/>

            <x-pages.card>
                <x-forms.form route="{{ route('admin.upload-logo') }}" media simple>
                    <x-forms.input name="image" type="file" label="Logo"/>

                    <p>Note: Ensure logo image size is 450 pixels wide by 100 pixels high.</p>

                    <img class="card-img-top" src="{{ asset('files/' . auth()->user()->logo) }}" alt="Card image cap">

                    <x-forms.button text="Upload"/>
                </x-forms.form>
            </x-pages.card>
        </div>
    </div>
@endsection
