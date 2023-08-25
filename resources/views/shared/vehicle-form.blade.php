@php

    $status  = [
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

<div class="row">
    @include('shared.dvla-lookup',['vehicles' => $vehicles])

    <x-forms.select :options="$carMakes" label="Make" name="make_id" required default/>

    <x-forms.select :options="(object)[]" label="Model" name="model_id" required default/>

    <x-forms.input label="VIN Number" type="number" name="vin_number"/>

    <x-forms.input label="Date of First Registration" type="date" name="commencement_date"/>

    <x-forms.input label="Service Due Date" type="date" name="due_date_1"/>

    <x-forms.input label="MOT Due Date" type="date" name="due_date_2"/>

    <x-forms.input label="Warranty Due Date" type="date" name="due_date_3"/>

    <div class="w-100 mb-2">
        <div class="col-2 float-end">
            <button class="btn btn-success w-100 waves-effect waves-light"
                    type="submit">
                Save
            </button>
        </div>
    </div>

    <hr/>

    <x-forms.input label="Colour" name="colour"/>

    <x-forms.input label="Tax Details" name="taxDetails"/>

    <x-forms.input label="Year Of Manufacture" name="yearOfManufacture"/>

    <x-forms.input label="MOT Details" name="motDetails"/>

    <x-forms.input label="Cylinder Capacity" name="cylinderCapacity"/>

    <x-forms.input label="Taxed" name="taxed"/>

    <x-forms.input label="CO2 Emissions" name="co2Emissions"/>

    <x-forms.input label="MOT" name="mot"/>

    <x-forms.input label="Fuel Type" name="fuelType"/>

    <x-forms.input label="Transmission" name="transmission"/>

    <x-forms.input label="Tax Status" name="taxStatus"/>

    <x-forms.input label="Number Of Doors" name="numberOfDoors"/>

    <x-forms.input label="Type Approval" name="typeApproval"/>

    <x-forms.input label="Type Approval" name="typeApproval"/>

    <x-forms.input label="6 Month Rate" name="sixMonthRate"/>

    <x-forms.input label="Wheel Plan" name="wheelPlan"/>

    <x-forms.input label="12 Month Rate" name="twelveMonthRate"/>

    <x-forms.input label="Revenue Weight" name="revenueWeight"/>

    <div class="w-100 mb-2">
        <div class="col-2 float-end">
            <button class="btn btn-success w-100 waves-effect waves-light"
                    type="submit">
                Save
            </button>
        </div>
    </div>

    <hr/>

    @if ($canView)
        <x-forms.checkbox label="Revenue Weight" name="sale"/>

        <x-forms.checkbox label="Revenue Weight" name="sale"/>

        <x-forms.select :options="$status" label="Sale Status" name="sale_status" default="1"/>

        <x-forms.input label="Date of Sale" type="date" name="date_of_sale"/>

        <x-forms.input label="Sale Price" type="number" name="sale_price"/>

        <x-forms.input label="Date of Purchase" type="date" name="date_of_purchase"/>

        <x-forms.input label="Purchase Price" type="number" name="purchase_price"/>

        <x-forms.input label="Additional Cost" type="number" name="additional_cost"/>

        <x-forms.input label="Margin" type="number" name="margin"/>

        <x-forms.input label="Margin %" type="number" name="margin_percent"/>

        <x-forms.input label="Mileage" type="number" name="sale_mileage"/>

        <div class="w-100 mb-2">
            <div class="col-2 float-end">
                <button class="btn btn-success w-100 waves-effect waves-light"
                        type="submit">
                    Save
                </button>
            </div>
        </div>

        <hr/>
    @endif

    <div class="col-lg-12 mb-4">
        <label for="notes">Notes</label>
        <textarea class="form-control" name="notes" id="notes"
                  placeholder="Notes" rows="3">
                                        </textarea>
    </div>
</div>

@section('scripts3')
    <script>
        $(document).ready(function ($) {
	        $('#make_id').change(function (e) {
                $.ajax({
                    type: 'GET',
                    url: `/vehicle/get-car-model/${e.target.value}`,
                    success: function (data) {
                        data.map(carModel => {
	                        $('#model_id').append(new Option(carModel.name, carModel.id));
                        });
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            })
        });
    </script>
@endsection

