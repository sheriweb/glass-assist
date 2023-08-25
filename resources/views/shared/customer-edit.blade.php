@php

    $vehicleHeads = ['Make', 'Model', 'VIN Number', 'Vehicle Reg', 'Service Due Date', 'MOT Due Date', 'Edit/Unlink'];
    $groupHeads = ['Name', 'Select'];

@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Customer"/>

            <x-forms.form route="{{ route('customer.edit-customer', $customer->id) }}">
                @method('PUT')

                <div class="row">
                    <x-forms.select label="Company Name" :options="$companies" name="company_name"
                                    :selected="$customer->company_name" required default>
                        <div class="float-end">
                            <a href="{{ route('customer.add-company') }}" type="button" target="_blank"
                               class="btn btn-info my-2 my-0">[Add New]</a>
                        </div>
                    </x-forms.select>

                    <x-forms.input label="Phone" name="phone" :value="$customer->phone" type="number"/>

                    <x-forms.input label="Business/Title" name="title" :value="$customer->title"/>

                    <x-forms.input label="Fax" name="fax" :value="$customer->fax"/>

                    <x-forms.input label="First Name" name="first_name" :value="$customer->first_name" required/>

                    <x-forms.input label="Mobile" name="mobile" :value="$customer->mobile"/>

                    <x-forms.input label="Surname" name="surname" :value="$customer->surname" required/>

                    <x-forms.input label="Email" name="email" :value="$customer->email" type="email" required/>

                    <x-forms.input label="Address 1" name="address_1" :value="$customer->address_1"/>

                    <x-forms.textarea label="Notes" name="notes" :value="$customer->notes"/>

                    <x-forms.input label="Address 2" name="address_2" :value="$customer->address_2"/>

                    <x-forms.input label="Link" name="link" :value="$customer->link"/>

                    <x-forms.input label="City" name="city" :value="$customer->city"/>

                    <x-forms.checkbox :checked="$customer->send_text" label="Send Text" name="send_text"/>

                    <x-forms.input label="Country" name="country" :value="$customer->country"/>

                    <x-forms.checkbox :checked="$customer->send_email" label="Send Email" name="send_email"/>

                    <x-forms.input label="Post Code" name="postcode" :value="$customer->postcode"/>

                    <x-forms.input label="Date Of Birth" type="date" name="dob" :value="$customer->dob"/>

                </div>

                <div class="my-5">
                    <x-pages.table :heads="$vehicleHeads" id="customersTable" simple>
                        @if($customer->vehicles)
                            @foreach($customer->vehicles as $vehicle)
                                <tr>
                                    <td>{{ $vehicle->carMake ? $vehicle->carMake->name : '' }}</td>
                                    <td>{{ $vehicle->carModel ? $vehicle->carModel->name : '' }}</td>
                                    <td>{{ $vehicle->vin_number }}</td>
                                    <td>{{ $vehicle->reg_no }}</td>
                                    <td>{{ $vehicle->due_date_1 }}</td>
                                    <td>{{ $vehicle->due_date_2 }}</td>
                                    <td>
                                        <a class="list-inline-item"
                                           href="">
                                            <button class="btn btn-success btn-sm rounded-0" type="button"
                                                    data-toggle="tooltip"
                                                    data-placement="top" title="Edit"><i class="fa fa-edit"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </x-pages.table>
                </div>

                <div class="row align-items-center">
                    <x-forms.select :options="$vehicles" label="Link a Vehicle" name="selectLinkVehicle" default/>

                    <div class="col-lg-6 mt-4">
                        <button id="linkVehicle" type="button" class="btn btn-dark">Link</button>
                    </div>
                </div>

                @include('shared.group-select', ['groups' => $groups, 'customer' => $customer])

                <x-forms.button text="Save" large/>
            </x-forms.form>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#single_select_link_vehicle').select2();
            $("#linkVehicle").click(function () {
                const id = $("#selectLinkVehicle").find(":selected").val();
                const customerId = {!! json_encode($customer->id) !!};

                $.ajax({
                    type: 'GET',
                    url: `/customer/${customerId}/link-vehicle/${id}`,
                    success: function (data) {
                        if (data.message) {
                            toastr.success(data.message);
                            location.reload();
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
