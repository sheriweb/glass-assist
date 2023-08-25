@php

    $saleStatus = [
        (object)[
            'id' => 1,
            'name' => 'For Sale'
        ],
        (object)[
            'id' => 2,
            'name' => 'Reserved'
        ],
        (object)[
            'id' => 3,
            'name' => 'Sold'
        ],
        (object)[
            'id' => 4,
            'name' => 'Scrapped'
        ],
    ];

@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Vehicle" back="vehicle"/>

            <x-forms.form route="{{ route('edit-vehicle', $vehicle->id) }}">
                @method('PUT')
                <div class="row">
                    @include('shared.dvla-lookup')

                    <x-forms.select label="Make" name="make_id" :options="$carMakes"
                              :selected="$vehicle->make_id" required default/>

                    @include('shared.model-ajax')

                    <x-forms.input type="number" label="VIN Number" name="vin_number" :value="$vehicle->vin_number"/>

                    <x-forms.input type="date" label="Date of First Registration" name="commencement_date"
                             :value="$vehicle->commencement_date"/>

                    <x-forms.input type="date" label="Service Due Date" name="due_date_1" :value="$vehicle->due_date_1"/>

                    <x-forms.input type="date" label="MOT Due Date" name="due_date_2" :value="$vehicle->due_date_2"/>

                    <x-forms.input type="date" label="Warranty Due Date" name="due_date_3" :value="$vehicle->due_date_3"/>

                    <div class="w-100 mb-2">
                        <div class="col-2 float-end">
                            <button class="btn btn-success w-100 waves-effect waves-light"
                                    type="submit">
                                Update
                            </button>
                        </div>
                    </div>

                    <hr/>

                    <x-forms.input label="Colour" name="colour" :value="$vehicle->colour"/>

                    <x-forms.input label="Tax Details" name="taxDetails" :value="$vehicle->taxDetails"/>

                    <x-forms.input label="Year Of Manufacture" name="yearOfManufacture" :value="$vehicle->yearOfManufacture"/>

                    <x-forms.input label="MOT Details" name="motDetails" :value="$vehicle->motDetails"/>

                    <x-forms.input label="Cylinder Capacity" name="cylinderCapacity" :value="$vehicle->cylinderCapacity"/>

                    <x-forms.input label="Taxed" name="taxed" :value="$vehicle->taxed"/>

                    <x-forms.input label="CO2 Emissions" name="co2Emissions" :value="$vehicle->co2Emissions"/>

                    <x-forms.input label="MOT" name="mot" :value="$vehicle->mot"/>

                    <x-forms.input label="Fuel Type" name="fuelType" :value="$vehicle->fuelType"/>

                    <x-forms.input label="Transmission" name="transmission" :value="$vehicle->transmission"/>

                    <x-forms.input label="Tax Status" name="taxStatus" :value="$vehicle->taxStatus"/>

                    <x-forms.input label="Number Of Doors" type="number" name="numberOfDoors"
                             :value="$vehicle->numberOfDoors"/>

                    <x-forms.input label="Type Approval" name="typeApproval" :value="$vehicle->typeApproval"/>

                    <x-forms.input label="6 Month Rate" name="sixMonthRate" :value="$vehicle->sixMonthRate"/>

                    <x-forms.input label="Wheel Plan" name="wheelPlan" :value="$vehicle->wheelPlan"/>

                    <x-forms.input label="12 Month Rate" name="twelveMonthRate" :value="$vehicle->twelveMonthRate"/>

                    <x-forms.input label="Revenue Weight" name="revenueWeight" :value="$vehicle->revenueWeight"/>

                    <div class="w-100 mb-2">
                        <div class="col-2 float-end">
                            <button class="btn btn-success w-100 waves-effect waves-light"
                                    type="submit">
                                Update
                            </button>
                        </div>
                    </div>

                    <hr/>

                    @if ($canView)
                        <x-forms.checkbox label="For Sale?" name="sale" :checked="$vehicle->sale"/>

                        <x-forms.select name="sale_status" :options="$saleStatus" :selected="$vehicle->sale_status" required/>

                        <x-forms.input label="Date of Sale" type="date" name="date_of_sale" :value="$vehicle->date_of_sale"/>

                        <x-forms.input label="Sale Price" type="number" name="sale_price" :value="$vehicle->sale_price"/>

                        <x-forms.input label="Date of Purchase" type="date" name="date_of_purchase"
                                 :value="$vehicle->date_of_purchase"/>

                        <x-forms.input label="Purchase Price" type="number" name="purchase_price"
                                 :value="$vehicle->purchase_price"/>

                        <x-forms.input label="Additional Cost" type="number" name="additional_cost"
                                 :value="$vehicle->additional_cost"/>

                        <x-forms.input label="Margin" type="number" name="margin" :value="$vehicle->margin"/>

                        <x-forms.input label="Margin %" type="number" name="margin_percent"
                                 :value="$vehicle->margin_percent"/>

                        <x-forms.input label="Mileage" type="number" name="sale_mileage" :value="$vehicle->sale_mileage"/>

                        <div class="w-100 mb-2">
                            <div class="col-2 float-end">
                                <button class="btn btn-success w-100 waves-effect waves-light"
                                        type="submit">
                                    Update
                                </button>
                            </div>
                        </div>

                        <hr/>
                    @endif

                    <x-forms.textarea label="Notes" name="notes" :value="$vehicle->notes"/>

                </div>

                <x-forms.button text="Update" large/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#sale_status').select2();
            $('#make_id').select2();
        });
    </script>
@endsection
