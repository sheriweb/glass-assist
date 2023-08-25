<div class="modal fade" id="booking-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog position-relative  modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content position-relativeeuro_code_log_table">
            @include('shared.pre-loader')
            <div class="modal-header">
                <div class="col-md-6">
                    <h5 class="modal-title">Job Card <span id="job-card-id"></span></h5>
                </div>
                <div class="col-md-6">
                    <button type="button" class="close btn float-end" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <x-forms.form route="{{ route('booking.save') }}" id="booking-form" class="overflow-auto" simple>
                <div class="modal-body">
                    <div class="modal-body">
                        <input type="hidden" name="vehicle_history_id" id="vehicle_history_id">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h4>Job Type *</h4>
                                <p>Note: To add a new job type, go to Admin > Job Types</p>
                                <div class="added-updated-info mt-1">
                                    Added by <span id="added_by_username"></span> on <span id="date_added"></span>
                                    <br/>
                                    Updated by <span id="updated_by_username"></span> on <span id="date_updated"></span>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <x-forms.select label="Status" name="status" id="status" :options="$jobStatuses" simple
                                                default></x-forms.select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <x-forms.select label="Calendar" name="calendar" id="calendar"
                                                    :options="$calendarTypes"
                                                    simple></x-forms.select>
                                    <span>Invoice To</span>
                                    <x-forms.select2 :options="$companies"
                                                     :selected="null"
                                                     id="company_id"
                                                     :dataAttributes="['id','name','city','postcode']"
                                                     addClasses="col-lg-12 adjust-width"
                                                     name="company_name"
                                                     label="Company Name"
                                                     optionValue="id"
                                                     optionName="name"
                                    />
                                    <div class="float-end">
                                        <a href="{{ route('customer.add-company') }}" type="button" target="_blank"
                                           class="btn btn-outline-primary my-2 my-0">Add New</a>
                                    </div>


                                    <br/>
                                    <x-forms.input label="Ref Caller Name" name="ref_caller_name" id="ref_caller_name"
                                                   simple></x-forms.input>

                                    <x-forms.input label="Cust Order No" name="order_number" id="order_number"
                                                   simple></x-forms.input>

                                    <x-forms.input label="C Card Ref No" name="c_card_ref_number" id="c_card_ref_number"
                                                   simple></x-forms.input>

                                    <x-forms.input label="GA Invoice Number" name="ga_invoice_number"
                                                   id="ga_invoice_number"
                                                   simple></x-forms.input>

                                    <x-forms.checkbox name="invoice_type" id="invoice_type" label="Job Invoiced"
                                                      simple></x-forms.checkbox>

                                    <hr class="hr_line"/>

                                    <label>Insurance Details</label>
                                    <x-forms.input name="policy_number" id="policy_number" label="Policy Number"
                                                   simple></x-forms.input>

                                    <x-forms.input name="expiry_date" id="expiry_date" label="Expiry Date" type="date"
                                                   simple></x-forms.input>

                                    <h class="hr_line" r/>

                                    <label>Contact Details</label>
                                    <div class="new_customer_div new_customer_visibility">
                                        <x-forms.select label="Title" name="title" id="customer_title"
                                                        :options="$customerTitles"
                                                        default
                                                        simple></x-forms.select>
                                        <x-forms.input name="first_name" id="customer_first_name" label="First Name"
                                                       simple></x-forms.input>

                                        <x-forms.input name="surname" id="customer_surname" label="Surname"
                                                       simple></x-forms.input>
                                        {{--<div class="float-end">
                                            <button type="button" id="existing_customer_button"
                                                    onclick="existingCustomer()"
                                                    class="btn btn-outline-primary my-0 w-20">
                                                Existing Customer
                                            </button>
                                        </div>--}}

                                        <div class="mt-2">
                                            <label>Job Location</label>
                                            <x-forms.checkbox name="same_as_company" id="same_as_company"
                                                              label="Same as Company"
                                                              simple></x-forms.checkbox>
                                        </div>

                                        <div id="postcode_lookup"
                                             class="d-flex flex-row justify-content-between mb-2"></div>

                                        <x-forms.input name="address_1" id="customer_address_1" label="Address Line 1"
                                                       simple></x-forms.input>

                                        <x-forms.input name="address_2" id="customer_address_2" label="Address Line 2"
                                                       simple></x-forms.input>

                                        <x-forms.input name="city" id="customer_city" label="City"
                                                       simple></x-forms.input>

                                        <x-forms.input name="postcode" id="customer_postcode" label="Postcode"
                                                       simple></x-forms.input>

                                        <x-forms.input name="phone" id="customer_phone" label="Phone" type="number"
                                                       simple></x-forms.input>

                                        <x-forms.input name="mobile" id="customer_mobile" label="Mobile Phone"
                                                       type="text"
                                                       simple></x-forms.input>

                                        <x-forms.input name="email" id="customer_email" label="Email" type="email"
                                                       simple></x-forms.input>

                                        <span class="mb-2">
                                        Note: Checking these boxes gives permission to send texts and/or emails to customer.
                                        It will send texts/emails when MOT/Service is due, and a reminder the day before bookings
                                    </span>
                                    </div>

                                    {{--                                <div class="existing_customer_div existing_customer_visibility">--}}
                                    {{--<div class="row mb-3">
                                        <x-forms.select label="Select Customer" name="customer_id" id="customer_id"
                                                        :options="$customers" required
                                                        default
                                                        simple>
                                        </x-forms.select>--}}
                                    {{--                                        <div class="mb-3">--}}
                                    {{--                                            <button type="button" id="new_customer_button" onclick="newCustomer()"--}}
                                    {{--                                                    class="btn btn-outline-primary float-end">--}}
                                    {{--                                                New Customer--}}
                                    {{--                                            </button>--}}
                                    {{--                                        </div>--}}
                                    {{--</div>--}}
                                    {{--                                </div>--}}

                                    <x-forms.input name="datetime" id="datetime" label="Booking Date Time"
                                                   type="date"
                                                   simple></x-forms.input>

                                    <x-forms.input name="time_allocated" id="time_allocated" label="Time Allocated"
                                                   type="time"
                                                   simple></x-forms.input>

                                    <hr class="hr_line"/>

                                    <x-forms.checkbox name="warranty_work" id="warranty_work" label="Warranty Work"
                                                      simple></x-forms.checkbox>

                                    <x-forms.checkbox name="cust_account" id="cust_account" label="Cust Account"
                                                      simple></x-forms.checkbox>

                                    <hr class="hr_line"/>

                                    <h4>Send on Save</h4>
                                    <x-forms.checkbox name="send_email" id="send_email" label="Send Email"
                                                      simple></x-forms.checkbox>

                                    <x-forms.checkbox name="send_text" id="send_text" label="Send Text"
                                                      simple></x-forms.checkbox>

                                    <span>Note: This will send a message to customer straight away</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    @include('shared.dvla-lookup', ['simple' => true])
                                    @php
                                        $glassPositions = $glassPositions['status'] == 200 ? $glassPositions['data']['glassPositions'] : [];
                                    @endphp
                                    <div class="row">
                                        {{--<x-forms.input name="vrn_number" id="vehicle_vrn_number" label="VRN:" placeholder="" ></x-forms.input>--}}
                                        <x-forms.input name="vin_number" id="vehicle_vin_number_id" label="VIN:"
                                                       placeholder=""></x-forms.input>
                                        <x-forms.input name="vehicle_year_manufacture" id="vehicle_year_manufacture"
                                                       label="Year of Manf:" placeholder=""></x-forms.input>
                                        <x-forms.input name="vehicle_make" id="vehicle_make" label="Make:"
                                                       placeholder=""></x-forms.input>
                                        <x-forms.input name="vehicle_model" id="vehicle_model" label="Model:"
                                                       placeholder=""></x-forms.input>
                                        {{--<x-forms.input name="vehicle_body_style" id="vehicle_body_style" label="Body Style:" placeholder="" ></x-forms.input>
                                        <x-forms.input name="vehicle_registered_date" id="vehicle_registered_date" label="Registered:" placeholder="" ></x-forms.input>--}}

                                        <x-forms.select-glass-positions label="Select Glass Position"
                                                                        name="glass_position"
                                                                        id="glass_position_id"
                                                                        :options="$glassPositions"
                                                                        simple
                                                                        default></x-forms.select-glass-positions>
                                        <input type="hidden" name="windscreen_lookup_id" id="windscreen_lookup_id">
                                        <div class="row align-items-center argic_no_container_main d-none">
                                            <div class="col-md-8 argic_no_container ">
                                                <x-forms.input name="argic_no" id="argic_no" label="ARGIC (Euro Code) Number:"
                                                               placeholder="" simple></x-forms.input>
                                            </div>
                                            {{--                                            <div class="col-md-6">--}}
                                            {{--                                                <x-forms.input name="euro_code" id="euro_code" label="Euro Code:" placeholder="" simple></x-forms.input>--}}
                                            {{--                                            </div>--}}
                                            {{--                                            <div class="col-md-1">--}}
                                            {{--                                                <button type="button" class="btn btn-primary"--}}
                                            {{--                                                        style="padding: 6px 10px; margin-top: 24px;">Edit--}}
                                            {{--                                                </button>--}}
                                            {{--                                            </div>--}}

                                        </div>
                                        <div class="argic_no_message d-none">
                                            <div class="w3-panel success">
                                                @include('shared.please-wait-loader')
                                                <p style="margin: 0px; text-align: center">Update on your what
                                                    windscreen
                                                    lookup request - <strong id="argic_no_message_status"></strong> -
                                                    Once
                                                    validated, ARGIC number will be provided. Your patience is
                                                    appreciated.</p>
                                            </div>
                                        </div>
                                        <div class="euro_code_log_table">

                                        </div>

                                        {{--                                    <x-forms.input name="reg_no" id="vehicle_reg_no" label="Vehicle Reg" ></x-forms.input>--}}
                                        {{--                                    <x-forms.input name="mileage" id="mileage" type="number" label="Enter Mileage" simple></x-forms.input>--}}
                                        {{--                                    <x-forms.select label="Make" name="make_id" id="vehicle_make_id" :options="$carMakes"  default></x-forms.select>--}}
                                        {{--                                    <x-forms.select label="Model" name="model_id" id="vehicle_model_id" :options="$carModels" default></x-forms.select>--}}
                                    </div>
                                    @include('shared.model-ajax', ['simple' => true])
                                    <hr class="hr_line"/>
                                    <x-forms.textarea name="job_cost" id="job_cost" label="Job Cost"
                                                      simple></x-forms.textarea>

                                    <x-forms.textarea name="work_required" id="work_required" label="Work Required"
                                                      simple></x-forms.textarea>

                                    <x-forms.textarea name="additional_details" id="additional_details"
                                                      label="Additional Details"
                                                      simple></x-forms.textarea>

                                    <hr class="hr_line"/>

                                    <x-forms.select label="Sub Contractor" name="sub_contractor" id="sub_contractor"
                                                    :options="$subContractors"
                                                    simple default>
                                        <div class="float-end">
                                            <a href="{{ route('customer.add-sub-contractors') }}" type="button"
                                               target="_blank"
                                               class="btn btn-outline-primary my-2 my-0">Add New</a>
                                        </div>
                                    </x-forms.select>

                                    <div class="mt-5">
                                        <label>Manual Contact Details</label>
                                        <x-forms.input name="manual_mobile" id="manual_mobile" label="Mobile Phone"
                                                       simple></x-forms.input>

                                        <x-forms.input name="manual_email" id="manual_email" label="Email"
                                                       simple></x-forms.input>
                                    </div>

                                    <hr class="hr_line"/>

                                    <x-forms.select label="Glass Supplier" name="glass_supplier" id="glass_supplier"
                                                    :options="$glassSuppliers"
                                                    simple default>
                                    </x-forms.select>

                                    <x-forms.checkbox name="calibration" id="calibration" label="CALIBRATION"
                                                      simple></x-forms.checkbox>

                                    <hr class="hr_line"/>

                                    <x-forms.input name="part_code" id="part_code" label="Part Code"
                                                   simple></x-forms.input>

                                    <hr class="hr_line"/>

                                    <x-forms.select name="technician" id="technician" label="Technician"
                                                    :options="$technicians"
                                                    simple default></x-forms.select>

                                    <hr class="hr_line"/>

                                    <x-forms.input name="miles" id="miles" label="Miles" simple></x-forms.input>

                                    <x-forms.textarea name="note" id="note" label="Job Notes" simple></x-forms.textarea>

                                    <label>Technician Notes</label>

                                    <x-forms.input name="batch_number" id="batch_number" label="Eurethane Batch Number:"
                                                   simple></x-forms.input>

                                    <x-forms.textarea name="tech_details" id="tech_details" label=""
                                                      simple></x-forms.textarea>

                                    @include('shared.group-select', ['groups' => $groups])
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h4>SERVICE INVOICE / QUOTE SECTION</h4>
                                    <h6>Job Card Items</h6>
                                    <table class="table table-borderless dt-responsive nowrap bg-whitesmoke rounded"
                                           id="customFields">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Cost Price</th>
                                            <th scope="col">Sell Price</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Remove</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="item">
                                            <td>
                                                <x-forms.input label="" type="number" name="invoice_row_id[]"
                                                               id="invoice_row_id[]" value="1"
                                                               simple></x-forms.input>
                                                <x-forms.input label="" type="hidden" name="type[]" id="type[]"
                                                               value="labour"
                                                               simple></x-forms.input>
                                            </td>
                                            <td>
                                                <x-forms.textarea label="" name="description[]" id="description[]"
                                                                  simple></x-forms.textarea>
                                            </td>
                                            <td>
                                                <x-forms.input label="" type="number" name="qty[]" id="qty[]" value="1"
                                                               simple></x-forms.input>
                                            </td>
                                            <td>
                                                <x-forms.input label="" type="number" name="cost_price[]"
                                                               id="cost_price[]"
                                                               value="0.0"
                                                               simple></x-forms.input>
                                            </td>
                                            <td>
                                                <x-forms.input label="" type="number" name="sell_price[]"
                                                               id="sell_price[]"
                                                               value="0.0"
                                                               simple></x-forms.input>
                                            </td>
                                            <td>
                                                <x-forms.input label="" type="number" value="0.0" name="total[]"
                                                               id="total[]"
                                                               simple></x-forms.input>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" id="remCF">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-forms.input label="Invoice Number" name="invoice_number"
                                                           id="invoice_number"
                                                           simple></x-forms.input>
                                            <x-forms.input type="date" label="Invoice Date" name="invoice_date"
                                                           id="invoice_date"
                                                           simple></x-forms.input>
                                            <x-forms.textarea label="Additional Notes" name="job_card_field"
                                                              id="job_card_field"
                                                              simple></x-forms.textarea>
                                        </div>

                                        <div class="col-md-6 mt-4">
                                            <table class="table table-borderless dt-responsive nowrap bg-white rounded"
                                                   id="priceTable">
                                                <tr class="fw-bold">
                                                    <td>
                                                        Total
                                                    </td>
                                                    <td id="totalAmount">
                                                        0.0
                                                    </td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td>
                                                        VAT
                                                    </td>
                                                    <td id="vatTotalAmount">
                                                        0.0
                                                    </td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td>
                                                        Sub Total
                                                    </td>
                                                    <td id="subTotalAmount">
                                                        0.0
                                                    </td>
                                                </tr>
                                                <tr class="fw-bold">
                                                    <td>
                                                        Gross Total
                                                    </td>
                                                    <td id="grossTotalAmount">
                                                        0.0
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <x-forms.select label="Add Row" name="row_type" :options="$cardItemTypes"
                                                    defualt></x-forms.select>
                                    <button type="button" class="btn btn-outline-primary col-lg-6" id="addItem">Add
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h4 class="d-flex">
                                        <span class="me-2">Pre Installation Check</span>
                                        <x-forms.checkbox label="" name="pre_job_complete" id="pre_job_complete"
                                                          simple></x-forms.checkbox>
                                    </h4>

                                    <x-forms.textarea label="Notes" name="pre_check_notes" id="pre_check_notes"
                                                      simple></x-forms.textarea>

                                    <x-forms.input label="Customer Name" name="pre_c_name" id="pre_c_name"
                                                   simple></x-forms.input>

                                    {{--<x-forms.checkbox label="Customer Approved" name="pre_job_complete"
                                                      id="pre_job_complete"
                                                      simple></x-forms.checkbox>--}}

                                    <table class="table table-bordered dt-responsive nowrap bg-whitesmoke rounded"
                                           id="priceTable" style="table-layout: fixed !important;">
                                        <tr class="fw-bold">
                                            <td>
                                                <img class="card-img-top" style="width: 27vw;"
                                                     src="{{ asset('files/pre_check.jpeg') }}" alt="pre install">
                                            </td>
                                            <td>
                                                <div id="canvas_image">
                                                    <img src="" id="canvas_image_show"/>
                                                </div>
                                                @include('shared.signature', ['canvas' => 'sig-canvas', 'submit' => 'sig-submitBtn', 'clear' => 'sig-clearBtn'])
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            <div class="col-md-12 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h4 class="d-flex">
                                        <span class="me-2">Job Sign Off</span>
                                        <x-forms.checkbox name="job_complete" id="job_complete"
                                                          simple></x-forms.checkbox>
                                    </h4>

                                    <x-forms.input label="Customer Name" name="c_name" id="c_name"
                                                   simple></x-forms.input>

                                    <x-forms.select label="Payment Type" name="payment_type" id="payment_type"
                                                    :options="$paymentTypes"
                                                    simple></x-forms.select>

                                    <label>Customer Signature</label>
                                    @include('shared.signature', ['canvas' => 'sig-canvas2', 'submit' => 'sig-submitBtn2', 'clear' => 'sig-clearBtn2'])

                                    <x-pages.header title="Completion Date/Time () - User Name ()">
                                        <button class="btn btn-outline-success">Save Job Card</button>
                                    </x-pages.header>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h4 class="d-flex">
                                        <span class="me-2">Job Not Completed</span>
                                        <x-forms.checkbox label="" name="job_complete" id="job_complete"
                                                          simple></x-forms.checkbox>
                                    </h4>
                                    <x-forms.select name="technician_statement" id="technician_statement"
                                                    label="Reason"
                                                    :options="$jobNotCompletedReasons"
                                                    simple>
                                    </x-forms.select>
                                    <x-forms.textarea name="technician_note" label="Reason, if any other"
                                                      simple></x-forms.textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4 p-2">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h5>Documents</h5>

                                    <p>Max file size per upload is 7Mb - If you require larger capacity please call.</p>

                                    <button class="btn btn-outline-primary">Upload</button>

                                    <table class="table table-bordered dt-responsive nowrap bg-white rounded my-2"
                                           id="priceTable" style="table-layout: fixed !important;">
                                        <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Date Added</th>
                                            <th scope="col">Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 p-2 added-updated-info " style="margin-bottom: 10 0px;">
                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                    <h6>Job Card Booked By</h6>

                                    <table class="table table-bordered dt-responsive nowrap bg-white rounded my-2"
                                           id="priceTable" style="table-layout: fixed !important;">
                                        <tbody>
                                        <tr>
                                            <td class="fw-bold">Booked By</td>
                                            <td id="booked_by_username"></td>
                                            <td class="fw-bold">Booking Date and Time</td>
                                            <td id="booked_by_date"></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <h6>Job Card Last Updated By</h6>

                                    <table class="table table-bordered dt-responsive nowrap bg-white rounded my-2"
                                           id="priceTable" style="table-layout: fixed !important;">
                                        <tbody>
                                        <tr>
                                            <td class="fw-bold">Updated By</td>
                                            <td id="updated_by_status_username"></td>
                                            <td class="fw-bold">Updated Date and Time</td>
                                            <td id="updated_by_status_date"></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div id="not_completed_by_section">
                                        <h6>Job Not Completed</h6>

                                        <table class="table table-bordered dt-responsive nowrap bg-white rounded my-2"
                                               id="priceTable" style="table-layout: fixed !important;">
                                            <tbody>
                                            <tr>
                                                <td class="fw-bold">Not Completed By</td>
                                                <td id="not_completed_by_username"></td>
                                                <td class="fw-bold">Not Completed Date and Time</td>
                                                <td id="not_completed_by_date"></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer sticky-bottom d-inline-block w-100">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-light me-1 mb-2 text-uppercase"
                                    id="send-completed-message">
                                Send Completed Message
                            </button>
                            <button type="button" class="btn btn-light me-1 mb-2 text-uppercase" id="print-job-card">
                                Print Job Card
                            </button>
                            <button type="button" class="btn btn-light me-1 mb-2 text-uppercase"
                                    id="print-sub-c-job-card">
                                Print Sub-C Job Card
                            </button>
                            <button type="button" class="btn btn-light me-1 mb-2 text-uppercase"
                                    id="email-sub-c-job-card">
                                Email Sub-C Job Card
                            </button>
                            <button type="button" class="btn btn-light me-1 mb-2 text-uppercase"
                                    id="text-sub-c-job-card">
                                Text Sub-C Job Card
                            </button>
                            <button type="submit" class="btn btn-warning me-1 mb-2 text-uppercase"
                                    id="btn-save-booking">
                                Save
                            </button>
                            <button type="submit" class="btn btn-success me-1 mb-2 text-uppercase"
                                    id="btn-save-and-close">
                                Save & Close
                            </button>
                            <a type="button" class="btn btn-danger me-1 mb-2 text-uppercase" id="btn-remove-booking">
                                Remove Booking
                            </a>
                        </div>
                    </div>
                </div>
            </x-forms.form>
        </div>
    </div>
</div>

@section('scripts4')
    <script>
		function _x(STR_XPATH) {
			const xresult = document.evaluate(STR_XPATH, document, null, XPathResult.ANY_TYPE, null);
			const xnodes = [];
			let xres;
			while (xres = xresult.iterateNext()) {
				xnodes.push(xres);
			}

			return xnodes;
		}

		const Toast = Swal.mixin({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		});

		function setTotal() {
			$("tr.item").each(function () {
				let qty = 1.0, sellPrice = 0.0;
				const totalEle = $(this).find(_x('/html/.//input[@id="total[]"]'));

				$(this).find(_x('/html/.//input[@id="qty[]"]')).keyup(function (e) {
					qty = e.target.value;

					totalEle.val(parseFloat(qty * sellPrice).toFixed(1));
				});

				$(this).find(_x('/html/.//input[@id="sell_price[]"]')).keyup(function (e) {
					sellPrice = e.target.value;

					totalEle.val(parseFloat(qty * sellPrice).toFixed(1));
				});
			});
		}

		$(document).ready(function () {
			$('#company_id').select2({
				placeholder: 'Select parent company',
				allowClear: true,
				dropdownParent: $('#booking-modal'),
				templateResult: formatResult
			});

			function formatResult(result) {
				if (!result.id) {
					return result.text;
				}
				var company = $(result.element).data('name');
				var city = $(result.element).data('city');
				var postcode = $(result.element).data('postcode');
				console.log(company)
				if (company == 'headings') {
					return $(
						'<div class="result-item heading_container">' +
						'<div class="column column-heading">Company Name</div>' +
						'<div class=" column column-heading">City</div>' +
						'<div class=" column column-heading">Post Code</div>' +
						'</div>'
					);
				} else {
					return $(
						'<div class="result-item">' +
						'<div class="column">' + company + '</div>' +
						'<div class="column">' + city + '</div>' +
						'<div class="column">' + postcode + '</div>' +
						'</div>'
					);
				}
			}

			$("#addItem").click(function () {
				const type = $('#row_type').val();

				if (type === 'blank') {
					$("#customFields").append(
						'<tr class="item">' +
						'<td>' +
						'<input class="form-control" type="number" name="invoice_row_id[]" id="invoice_row_id[]" value="1" />' +
						'<input class="form-control" type="hidden" name="type[]" id="type[]" value=' + type + '/>' +
						'</td>' +
						'<td>' +
						'</td>' +
						'<td>' +
						'</td>' +
						'<td>' +
						'</td>' +
						'<td>' +
						'</td>' +
						'<td>' +
						'</td>' +
						'<td>' +
						'<button type="button" class="btn btn-danger" id="remCF">' +
						'<i class="fa fa-trash"></i>' +
						'</button>' +
						'</td>' +
						'</tr>'
					);
					setTotal();

					return;
				}

				const fixed = ['labour_fixed', 'parts_labour_fixed', 'parts_fixed', 'recovery', 'discount'];
				let qtyType = 'number';

				if (fixed.includes(type)) {
					qtyType = 'hidden';
				}

				$("#customFields").append(
					'<tr class="item">' +
					'<td>' +
					'<input class="form-control" type="number" name="invoice_row_id[]" id="invoice_row_id[]" value="1" />' +
					'<input class="form-control" type="hidden" name="type[]" id="type[]" value=' + type + '/>' +
					'</td>' +
					'<td>' +
					'<div class="mb-4">' +
					'<textarea class="form-control" name="description[]" id="description[]" placeholder="" rows="3"></textarea>' +
					'</div>' +
					'</td>' +
					'<td>' +
					'<input class="form-control" type="' + qtyType + '" name="qty[]" id="qty[]" value="1" placeholder="" />' +
					'</td>' +
					'<td>' +
					'<input class="form-control" type="number" name="cost_price[]" id="cost_price[]"  value="0.0" placeholder="" />' +
					'</td>' +
					'<td>' +
					'<input class="form-control" type="number" name="sell_price[]" id="sell_price[]" value="0.0" placeholder="" />' +
					'</td>' +
					'<td>' +
					'<input class="form-control" type="number" name="total[]" id="total[]" value="0.0" placeholder="" />' +
					'</td>' +
					'<td>' +
					'<button type="button" class="btn btn-danger" id="remCF">' +
					'<i class="fa fa-trash"></i>' +
					'</button>' +
					'</td>' +
					'</tr>'
				);

				setTotal();
			});

			$("#customFields").on('click', '#remCF', function () {
				$(this).parent().parent().remove();
			});

			setTotal();

			$('#technician_statement').select2({
				dropdownParent: $('#booking-modal'),
			});

			$('#customer_id').select2({
				tags: true,
				width: '100%',
				dropdownParent: $('#booking-modal'),
				ajax: {
					url: "{{ route('api.customer') }}",
					dataType: 'json'
				}
			});

			/*$('#vehicle_make_id').select2({
                width: '100%',
                dropdownParent: $('#booking-modal')
            });

            $('#vehicle_model_id').select2({
                width: '100%',
                dropdownParent: $('#booking-modal')
            });

            $('#sub_contractor').select2({/*$('#vehicle_make_id').select2({
                width: '100%',
                dropdownParent: $('#booking-modal')
            });

            $('#glass_supplier').select2({
                width: '100%',
                dropdownParent: $('#booking-modal')
            });*/
		});

		function existingCustomer() {
			$('.new_customer_div').css("display", "none");
			$('.existing_customer_visibility').css("display", "block");
		}

		function newCustomer() {
			$('.new_customer_div').css("display", "block");
			$('.existing_customer_div').css("display", "none");
		}

		let saveAndClose = false;
		let canWhatWindScreen = false;

		$('#what_windScreen_lookup').click(function (e) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
				}
			});
			e.preventDefault();

			const data = {
				vehicle_registration_number: $('#vehicle_registration_number').val(),
				vrn_number: $('#vehicle_vrn_number').val(),
				vin_number: $('#vehicle_vin_number_id').val(),
				vehicle_make: $('#vehicle_make').val(),
				vehicle_model: $('#vehicle_model').val(),
				vehicle_year_manufacture: $('#vehicle_year_manufacture').val(),
				glass_position: $('#glass_position_id').val(),
			};

			$('.error_glass_position').html('');
			var btn = $(this);
			dataIndicator(btn, 'on');
			$.ajax({
				type: 'POST',
				url: '{{route('vehicle.what-windscreen-lookup')}}',
				data: data,
				dataType: 'json',
				success: function (res) {
					dataIndicator(btn, 'off');
					if (res.status == 200) {
						$('#windscreen_lookup_id').val(res.data.lookupId);
						canWhatWindScreen = true;
						Toast.fire({
							icon: 'success',
							title: res.message
						});
						let form = $('.booking-form');
						$('#argic_no_message_status').html(res.data.statusDesc);
                        getWhatWindScreenLookupTable(res.data);
						if (res.data.statusDesc == 'Validated') {

							$('.argic_no_container_main').removeClass('d-none');
                            $('#argic_no').val(res.data.resultEuroCode);
                            $('#part_code').val(res.data.resultEuroCode);
							$('.argic_no_message').addClass('d-none');

						} else {

							$('.argic_no_message').removeClass('d-none');
                            $('.argic_no_container_main').addClass('d-none');
                            bookingModelIsOpen = true;
                            whatWindScreenApiCAllInterval = setInterval(function (){
                                checkBookingModel(res.data.lookupId, res.data.resultEuroCode);
                            }, 5000);

						}
						saveJobCard(form);
					} else {

						if (res.code == 400) {
							Toast.fire({
								icon: 'error',
								title: res.errorMessage
							})
						} else if (res.code == 403) {
							Toast.fire({
								icon: 'error',
								title: 'Unauthorized User'
							})
						}
					}
				},
				error: function (request) {
					dataIndicator(btn, 'off');
					let responseText = jQuery.parseJSON(request.responseText);
					showErrorsByClass(responseText.errors);
				}
			});
		});

		$("#btn-save-and-close").click(function () {
			saveAndClose = true;
		});

		$(".booking-form").submit(function (event) {
			event.preventDefault();
			let form = $(this);
			saveJobCard(form);
		});

		function saveJobCard(form) {
			const checkboxes = $(this).find('input[type="checkbox"]');
			checkboxes.each(function () {
				const checkbox = $(this);
				if (checkbox.is(':checked') === true) {
					checkbox.val(1);
				} else {
					checkbox.val(0);
				}
			});
			const formData = form.serialize();
			$.ajax({
				url: "{{ route('booking.save') }}",
				type: "POST",
				data: formData,
				dataType: "json",
				success: function (response) {
					if (saveAndClose) {
						$("#booking-modal").modal('hide'); // close the modal on success

						if (unallocatedBookingClicked === true) {
							location.reload();
						}

						saveAndClose = false;
					}
					$('#vehicle_history_id').val(response.id);
					if (!canWhatWindScreen) {
						showMessage(response);
					}
					calendar.refetchEvents();
				},
				error: function (xhr, status, error) {
					var errorMessage = xhr.responseText; // Retrieve the error message
					console.log(errorMessage); // Display the error message in the console
					// Handle the error message
				}
			});
		}


		$("#print-job-card").click(function () {
			const vehicleHistoryId = $('#vehicle_history_id').val();
			window.open(
				'/pdf/job-card/' + vehicleHistoryId,
				'_blank'
			);
		});

		$("#print-sub-c-job-card").click(function () {
			const vehicle_history_id = $('#vehicle_history_id').val();
			window.open(
				'/pdf/job-card-subscription/' + vehicle_history_id,
				'_blank'
			);
		});

		function invoicePdf(vehicle_history_id) {
			const invoice_date = $('#invoice_date').val();
			window.open(
				'/pdf/booking-invoice/' + vehicle_history_id + '/' + invoice_date,
				'_blank'
			);
		}

		function quotePdf(vehicle_history_id) {
			window.open(
				'/pdf/booking-invoice/' + vehicle_history_id + '/quote',
				'_blank'
			);
		}

		$("#email-sub-c-job-card").click(function () {
			$.ajax({
				type: "GET",
				url: '/pdf/email-job-card-subscription/' + $('#vehicle_history_id').val(),
				data: [],
				success: function () {
					alert(response.message);
				}
			});
		});

		$("#text-sub-c-job-card").click(function () {
			$.ajax({
				type: "GET",
				url: '/pdf/text-job-card-subscription/' + $('#vehicle_history_id').val(),
				data: [],
				success: function (response) {
					alert(response.message);
				}
			});
		});

		$("#send-completed-message").click(function () {
			const data = $('.booking-form').serialize();

			if (window.confirm('Are you sure you want to send a completed message to the customer?')) {
				$.ajax({
					type: "POST",
					url: "/booking/send-completed/",
					data: data,
					success: function () {

					}
				});
			}
		});

		$("#btn-remove-booking").click(function () {
			const vehicleHistoryId = $('#vehicle_history_id').val();
			deleteJobCard(vehicle_history_id, true);
		});

		$(document).on("click", '#same_as_company', function (e) {
			if (this.checked) {
				let companyId = $('#company_id').val();

				$.ajax({
					url: "/company/detail/" + companyId,
					success: function (response) {
						$('#customer_address_1').val(response.address_1);
						$('#customer_address_2').val(response.address_2);
						$('#customer_city').val(response.city);
						$('#customer_country').val(response.county);
						$('#customer_postcode').val(response.postcode);
						$('#customer_email').val(response.email);
						$('#customer_phone').val(response.phone);
					}
				});
			}
		});
    </script>
@endsection
