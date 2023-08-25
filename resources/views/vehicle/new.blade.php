@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Vehicle" back="vehicle"/>

            <x-pages.card>
                <form method="POST" class="form-horizontal mt-3"
                      action="{{ route('add-vehicle') }}">
                    @csrf

                    @include('shared.vehicle-form', ['carMakes' => $carMakes, 'canView' => $canView])

                    <x-forms.button text="Save" large/>
                </form>
            </x-pages.card>

        </div>
    </div>
@endsection
