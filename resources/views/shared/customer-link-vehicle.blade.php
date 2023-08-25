@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Add Vehicle"/>

            <x-forms.form route="{{ route('customer.customer-link-vehicle', $id) }}">
                @method('PUT')

                <h3>Link an Existing Vehicle:</h3>

                <div class="row align-items-center">
                    <x-forms.select :options="$vehicles" label="Existing Vehicle" id="vehicle_id"
                                    name="selectLinkVehicle" default/>

                    <div class="col-lg-6 mt-4">
                        <button id="linkVehicle" type="button" class="btn btn-dark">Link</button>
                    </div>
                </div>

                <h2 class="my-5">Or Add a New Vehicle Below:</h2>

                @include('shared.vehicle-form', ['carMakes' => $carMakes, 'canView' => $canView, 'vehicles' => $vehicles])

                <x-forms.button text="Save" large/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#linkVehicle").click(function () {
                const id = $("#selectLinkVehicle").find(":selected").val();
                var customerId = {!! json_encode($id) !!};

                $.ajax({
                    type: 'GET',
                    url: `/customer/${customerId}/link-vehicle/${id}`,
                    success: function (data) {
                        if (data.message) {
                            toastr.success(data.message);
                            window.href = +"/customer/edit/"+data.customerId+"";
                        } else {
                            toastr.error(data.error);
                        }
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

            $('#groupDataTable').DataTable();
        });
    </script>

@endsection
