@php

    $prices = [
        (object)[
            'id' => 100,
            'name' => '100 (£10.20 / 10.2p each)'
        ],
        (object)[
            'id' => 250,
            'name' => '250 (£24.25 / 9.7p each)'
        ],
        (object)[
            'id' => 500,
            'name' => '500 (£46.00 / 9.2p each)'
        ],
        (object)[
            'id' => 750,
            'name' => '750 (£61.50 / 8.2p each)'
        ],
        (object)[
            'id' => 1000,
            'name' => '1000 (£72.00 / 7.2p each)'
        ],
        (object)[
            'id' => 1500,
            'name' => '1500 (£108.00 / 7.2p each)'
        ],
        (object)[
            'id' => 2000,
            'name' => '2000 (£124.00 / 6.2p each)'
        ],
        (object)[
            'id' => 3000,
            'name' => '3000 (£156.00 / 5.2p each)'
        ],
        (object)[
            'id' => 4000,
            'name' => '4000 (£192.00 / 4.8p each)'
        ],
    ];

@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <x-pages.card>
                <h5>Confirm Details</h5>

                <x-forms.select
                    label="Please select the number of Text (SMS) Credits you'd like to purchase, and press Continue."
                    name="price"
                    :options="$prices"
                />

                <x-forms.button text="continue"/>
            </x-pages.card>

        </div>
    </div>

@endsection
