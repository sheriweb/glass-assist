<div class="modal fade" id="technician-booking-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
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

            <x-forms.form route="{{ route('booking.save') }}"  class="overflow-auto" formId simple>
                <div class="modal-body">
                    <input type="hidden" name="vehicle_history_id" id="vehicle_history_id">
                    <div class="row">
                        <div class="col-md-6 ">
                            <div class="d-flex align-items-center gap-2">
                                <h5>Status: </h5>
                                <h6 id="card_status"></h6>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center ">
                                    <h5 class="update_info_date">Added by:</h5>
                                    <h6 class="update_info_name" id="added_by_username"></h6>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <h5 class="update_info_date">Added on:</h5>
                                    <h6 class="update_info_name" id="date_added"></h6>
                                </div>
                                <div class="col-md-6  d-flex align-items-center">
                                    <h5 class="update_info_date">Updated by:</h5>
                                    <h6 class="update_info_name" id="updated_by_username"></h6>
                                </div>
                                <div class="col-md-6 d-flex align-items-center">
                                    <h5 class="update_info_date">Updated on:</h5>
                                    <h6 class="update_info_name" id="date_updated"></h6>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="detailTab">
                                    <button class="accordion-button position-relative" type="button">
                                       <h5>Detail</h5>
                                        <i class="fas fa-chevron-up position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="detailCollapsePanel" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-4 p-2" id="calendar" >
                                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                                    <x-forms.select label="Calendar" name="calendar" id="calendar" :options="$calendarTypes"
                                                                    :disabled="$disabled ?? ''" simple></x-forms.select>
                                                    <span>Invoice To</span>

                                                    <x-forms.select label="Company Name" name="company_name" id="company_id"
                                                                    :options="$companies"
                                                                    :disabled="$disabled ?? ''"
                                                                    default
                                                                    simple>
                                                        <div class="float-end">
                                                            <a href="{{ route('customer.add-company') }}" type="button" target="_blank"
                                                               class="btn btn-outline-primary my-2 my-0 disabled" >Add New</a>
                                                        </div>
                                                    </x-forms.select>

                                                    <br/>
                                                    <x-forms.input label="Ref Caller Name" name="ref_caller_name" id="ref_caller_name"
                                                                   :disabled="$disabled ?? ''" simple></x-forms.input>

                                                    <x-forms.input label="Cust Order No" name="order_number" id="order_number"
                                                                   :disabled="$disabled ?? ''"   simple></x-forms.input>

                                                    <x-forms.input label="C Card Ref No" name="c_card_ref_number" id="c_card_ref_number"
                                                                   :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                    <x-forms.input label="GA Invoice Number" name="ga_invoice_number" id="ga_invoice_number"
                                                                   :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                    <x-forms.checkbox name="invoice_type" id="invoice_type" label="Job Invoiced"
                                                                      :disabled="$disabled ?? ''"        simple></x-forms.checkbox>

                                                    <hr/>

                                                    <label>Insurance Details</label>
                                                    <x-forms.input name="policy_number" id="policy_number" label="Policy Number"
                                                                   :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                    <x-forms.input name="expiry_date" id="expiry_date" label="Expiry Date" type="date"
                                                                   :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                    <hr/>

                                                    <label>Contact Details</label>
                                                    <div class="new_customer_div new_customer_visibility">
                                                        <x-forms.select label="Title" name="title" id="customer_title"
                                                                        :options="$customerTitles"
                                                                        :disabled="$disabled ?? ''"
                                                                        default
                                                                        simple></x-forms.select>
                                                        <x-forms.input name="first_name" id="customer_first_name" label="First Name"
                                                                       :disabled="$disabled ?? ''"    simple></x-forms.input>

                                                        <x-forms.input name="surname" id="customer_surname" label="Surname"
                                                                       :disabled="$disabled ?? ''"    simple></x-forms.input>


                                                        <div class="mt-2">
                                                            <label>Job Location</label>
                                                            <x-forms.checkbox name="same_as_company" id="same_as_company"
                                                                              label="Same as Company"
                                                                              :disabled="$disabled ?? ''"
                                                                              simple></x-forms.checkbox>
                                                        </div>

                                                        <div id="postcode_lookup" class="d-flex flex-row justify-content-between mb-2"></div>

                                                        <x-forms.input name="address_1" id="customer_address_1" label="Address Line 1"
                                                                       :disabled="$disabled ?? ''"    simple></x-forms.input>

                                                        <x-forms.input name="address_2" id="customer_address_2" label="Address Line 2"
                                                                       :disabled="$disabled ?? ''"  simple></x-forms.input>

                                                        <x-forms.input name="city" id="customer_city" label="City" :disabled="$disabled ?? ''" simple></x-forms.input>

                                                        <x-forms.input name="postcode" id="customer_postcode" label="Postcode"
                                                                       :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                        <x-forms.input name="phone" id="customer_phone" label="Phone" type="number"
                                                                       :disabled="$disabled ?? ''"   simple></x-forms.input>

                                                        <x-forms.input name="mobile" id="customer_mobile" label="Mobile Phone" type="text"
                                                                       :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                        <x-forms.input name="email" id="customer_email" label="Email" type="email"
                                                                       :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                        <span class="mb-2">
                                                            Note: Checking these boxes gives permission to send texts and/or emails to customer.
                                                            It will send texts/emails when MOT/Service is due, and a reminder the day before bookings
                                                        </span>
                                                    </div>



                                                    <x-forms.input name="datetime" id="datetime" label="Booking Date Time"
                                                                   type="date"
                                                                   :disabled="$disabled ?? ''"
                                                                   simple></x-forms.input>

                                                    <x-forms.input name="time_allocated" id="time_allocated" label="Time Allocated"
                                                                   type="time"
                                                                   :disabled="$disabled ?? ''"
                                                                   simple></x-forms.input>

                                                    <hr/>

                                                    <x-forms.checkbox name="warranty_work" id="warranty_work" label="Warranty Work"
                                                                      :disabled="$disabled ?? ''"     simple></x-forms.checkbox>

                                                    <x-forms.checkbox name="cust_account" id="cust_account" label="Cust Account"
                                                                      :disabled="$disabled ?? ''"    simple></x-forms.checkbox>

                                                    <hr/>

                                                    <h4>Send on Save</h4>
                                                    <x-forms.checkbox name="send_email" id="send_email" label="Send Email"
                                                                      :disabled="$disabled ?? ''"    simple></x-forms.checkbox>

                                                    <x-forms.checkbox name="send_text" id="send_text" label="Send Text"
                                                                      :disabled="$disabled ?? ''"      simple></x-forms.checkbox>

                                                    <span>Note: This will send a message to customer straight away</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4 p-2" id="model" >
                                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                                    <x-forms.input name="manual_make_model" id="manual_make_model" label="Enter Make/Model"
                                                                   :disabled="$disabled ?? ''"    simple></x-forms.input>

                                                    <x-forms.input name="mileage" id="mileage" type="number" label="Enter Mileage"
                                                                   :disabled="$disabled ?? ''"  simple></x-forms.input>

                                                    @include('shared.dvla-lookup', ['simple' => true,])

                                                    <x-forms.select label="Make" name="make_id" id="vehicle_make_id" :options="$carMakes"
                                                                    :disabled="$disabled ?? ''"      simple
                                                                    default></x-forms.select>
                                                    <x-forms.select label="Model" name="model_id" id="vehicle_model_id"
                                                                    :options="$carModels"
                                                                    :disabled="$disabled ?? ''"
                                                                    simple
                                                                    default></x-forms.select>

                                                    @include('shared.model-ajax', ['simple' => true])

                                                    <x-forms.input name="reg_no" id="vehicle_reg_no" label="Vehicle Reg"
                                                                   :disabled="$disabled ?? ''"  simple></x-forms.input>

                                                    <x-forms.input name="vin_number" id="vehicle_vin_number" label="VIN No."
                                                                   :disabled="$disabled ?? ''"     simple></x-forms.input>

                                                    <hr/>

                                                    <x-forms.textarea name="job_cost" id="job_cost" label="Job Cost"
                                                                      :disabled="$disabled ?? ''"       simple></x-forms.textarea>

                                                    <x-forms.textarea name="work_required" id="work_required" label="Work Required"
                                                                      :disabled="$disabled ?? ''"       simple></x-forms.textarea>

                                                    <x-forms.textarea name="additional_details" id="additional_details"
                                                                      label="Additional Details"
                                                                      :disabled="$disabled ?? ''"
                                                                      simple></x-forms.textarea>

                                                    <hr/>

                                                    <x-forms.select label="Sub Contractor" name="sub_contractor" id="sub_contractor"
                                                                    :options="$subContractors"
                                                                    :disabled="$disabled ?? ''"
                                                                    simple default>
                                                        <div class="float-end">
                                                            <a href="{{ route('customer.add-sub-contractors') }}" type="button"
                                                               target="_blank"
                                                               class="btn btn-outline-primary my-2 my-0 disabled">Add New</a>
                                                        </div>
                                                    </x-forms.select>

                                                    <div class="mt-5">
                                                        <label>Manual Contact Details</label>
                                                        <x-forms.input name="manual_mobile" id="manual_mobile" label="Mobile Phone"
                                                                       :disabled="$disabled ?? ''"          simple></x-forms.input>

                                                        <x-forms.input name="manual_email" id="manual_email" label="Email"
                                                                       :disabled="$disabled ?? ''"        simple></x-forms.input>
                                                    </div>

                                                    <hr/>

                                                    <x-forms.select label="Glass Supplier" name="glass_supplier" id="glass_supplier"
                                                                    :options="$glassSuppliers"
                                                                    :disabled="$disabled ?? ''"
                                                                    simple default>
                                                    </x-forms.select>

                                                    <x-forms.checkbox name="calibration" id="calibration" label="CALIBRATION"
                                                                      :disabled="$disabled ?? ''"     simple></x-forms.checkbox>

                                                    <hr/>

                                                    <x-forms.input name="part_code" id="part_code" label="Part Code" :disabled="$disabled ?? ''" simple></x-forms.input>

                                                    <hr/>

                                                    <x-forms.select name="technician" id="technician" label="Technician"
                                                                    :options="$technicians"
                                                                    :disabled="$disabled ?? ''"
                                                                    simple default></x-forms.select>

                                                    <hr/>

                                                    <x-forms.input name="miles" id="miles" label="Miles" :disabled="$disabled ?? ''"  simple></x-forms.input>

                                                    <x-forms.textarea name="note" id="note" label="Job Notes" :disabled="$disabled ?? ''"  simple></x-forms.textarea>

                                                    <label>Technician Notes</label>

                                                    <x-forms.input name="batch_number" id="batch_number" label="Eurethane Batch Number:"
                                                                   :disabled="$disabled ?? ''"    simple></x-forms.input>

                                                    <x-forms.textarea name="tech_details" id="tech_details" label=""
                                                                      :disabled="$disabled ?? ''"   simple></x-forms.textarea>

                                                    @include('shared.group-select', ['groups' => $groups])
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4 p-2" id="service-invoice">
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
                                                                               :disabled="$disabled ?? ''"
                                                                               simple></x-forms.input>
                                                                <x-forms.input label="" type="hidden" name="type[]" id="type[]"
                                                                               value="labour"
                                                                               simple></x-forms.input>
                                                            </td>
                                                            <td>
                                                                <x-forms.textarea label="" name="description[]" id="description[]"
                                                                                  :disabled="$disabled ?? ''"    simple></x-forms.textarea>
                                                            </td>
                                                            <td>
                                                                <x-forms.input label="" type="number" name="qty[]" id="qty[]" value="1"
                                                                               :disabled="$disabled ?? ''"     simple></x-forms.input>
                                                            </td>
                                                            <td>
                                                                <x-forms.input label="" type="number" name="cost_price[]" id="cost_price[]"
                                                                               value="0.0"
                                                                               :disabled="$disabled ?? ''"
                                                                               simple></x-forms.input>
                                                            </td>
                                                            <td>
                                                                <x-forms.input label="" type="number" name="sell_price[]" id="sell_price[]"
                                                                               value="0.0"
                                                                               :disabled="$disabled ?? ''"
                                                                               simple></x-forms.input>
                                                            </td>
                                                            <td>
                                                                <x-forms.input label="" type="number" value="0.0" name="total[]"
                                                                               id="total[]"
                                                                               :disabled="$disabled ?? ''"
                                                                               simple></x-forms.input>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger disabled" id="remCF" >
                                                                    <i class="fa fa-trash" ></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <x-forms.input label="Invoice Number" name="invoice_number" id="invoice_number"
                                                                           :disabled="$disabled ?? ''"    simple></x-forms.input>
                                                            <x-forms.input type="date" label="Invoice Date" name="invoice_date"
                                                                           id="invoice_date"
                                                                           :disabled="$disabled ?? ''"
                                                                           simple></x-forms.input>
                                                            <x-forms.textarea label="Additional Notes" name="job_card_field"
                                                                              id="job_card_field"
                                                                              :disabled="$disabled ?? ''"
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

                                                    <x-forms.select label="Add Row" name="row_type" :options="$cardItemTypes" :disabled="$disabled ?? ''"
                                                                    defualt></x-forms.select>
                                                    <button type="button" class="btn btn-outline-primary col-lg-6 disabled" id="addItem" >Add</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="preInstallationCheckCollapsePanelHeading">
                                    <button class="accordion-button position-relative" type="button"  >
                                        <h5>Pre Installation Check</h5>
                                        <i class="fas fa-chevron-down position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="preInstallationCheckCollapsePanel" class="accordion-collapse collapse " aria-labelledby="preInstallationCheckCollapsePanelHeading" >
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-4 p-2" id="pre-installation-check">
                                                <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                          <x-forms.textarea label="Pre Installation Check - Notes" name="pre_check_notes" id="pre_check_notes"   simple></x-forms.textarea>
                                                      </div>
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                               <div class="col-md-12">
                                                                   <x-forms.input label="Customer Name" name="pre_c_name" id="pre_c_name"  simple></x-forms.input>
                                                               </div>
                                                                <div class="col-md-12 mt-2">
                                                                    <x-forms.checkbox label="Customer Approved " name="pre_job_complete" id="pre_job_complete"  simple ></x-forms.checkbox>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <table class="table table-bordered dt-responsive nowrap bg-whitesmoke rounded" id="priceTable" style="table-layout: fixed !important;">
                                                        <tr class="fw-bold">
                                                            <td class="text-center">
                                                                <img class="card-img-top" style="width: 27vw;" src="{{ asset('files/pre_check.jpeg') }}" alt="pre install">
                                                            </td>
                                                            <td>
                                                                <div id="canvas_image">
                                                                    <img src="" id="canvas_image_show" />
                                                                </div>
                                                                @include('shared.signature', ['canvas' => 'sig-canvas', 'submit' => 'sig-submitBtn', 'clear' => 'sig-clearBtn', ])
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="jobSignOffHeading">
                                    <button class="accordion-button position-relative" type="button" >
                                        <h5>Job Sign Off</h5>
                                        <i class="fas fa-chevron-down position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="jobSignOffCollapsePanel" class="accordion-collapse collapse " aria-labelledby="headingOne" >
                                    <div class="accordion-body">
                                        <div class="col-md-12 mb-4 p-2" id="signoff">
                                            <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Customer Signature</label>
                                                        @include('shared.signature1', ['canvas' => 'sig-canvas22', 'submit' => 'sig-submitBtn2', 'clear' => 'sig-clearBtn2'])
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="col-md-12">
                                                            <x-forms.input label="Customer Name" name="c_name" id="c_name"  simple></x-forms.input>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <x-forms.select label="Payment Type" name="payment_type" id="payment_type"
                                                                            :options="$paymentTypes"
                                                                            simple></x-forms.select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <x-forms.checkbox label="Job Completed" name="job_complete" id="job_complete" simple></x-forms.checkbox>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <x-forms.input label="Completion Date/Time" name="s_date" id="user_s_date" :disabled="$disabled ?? ''"  simple></x-forms.input>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <x-forms.input label="User Name" name="s_name" id="user_s_name" :disabled="$disabled ?? ''"  simple></x-forms.input>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="jobNotCompletedHeading">
                                    <button class="accordion-button position-relative" type="button">
                                        <h5>Job Not Completed</h5>
                                        <i class="fas fa-chevron-down position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="jobNotCompletedCollapsePanel" class="accordion-collapse collapse " aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="col-md-12 mb-4 p-2" id="job-not-completed">
                                            <div class="border border-dark rounded border-1 p-3 bg-whitesmoke">
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="col-md-12">
                                                              <x-forms.select name="technician_statement" id="technician_statement"
                                                                              label="Reason"
                                                                              :options="$jobNotCompletedReasons"
                                                                              simple>
                                                              </x-forms.select>
                                                          </div>
                                                          <div class="col-md-12">
                                                              <x-forms.checkbox label="Job Not Completed" name="job_not_completed" id="job_not_completed" simple></x-forms.checkbox>
                                                          </div>
                                                      </div>
                                                        <div class="col-md-6">
                                                            <div class="col-md-12">
                                                                <x-forms.textarea name="technician_note" label="Reason, if any other" simple></x-forms.textarea>
                                                            </div>
                                                        </div>

                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="documentHeading">
                                    <button class="accordion-button position-relative" type="button">
                                        <h5>Documents</h5>
                                        <i class="fas fa-chevron-down position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="documentCollapsePanel" class="accordion-collapse collapse " aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="col-md-12 mb-4 p-2" id="docs">
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
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="jobCardBookedByHeading">
                                    <button class="accordion-button position-relative" type="button">
                                        <h5>Job Card Booked By</h5>
                                        <i class="fas fa-chevron-down position-absolute drop_arrow" style="right: 21px"></i>
                                    </button>
                                </h2>
                                <div id="jobCardBookedByCollapsePanel" class="accordion-collapse collapse " aria-labelledby="headingOne">
                                    <div class="accordion-body">
                                        <div class="col-md-12 mb-4 p-2 added-updated-info">
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer sticky-bottom d-inline-block w-100">
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <button type="button"  class="btn btn-warning me-1 mb-2 text-uppercase" id="btn-save-booking">
                               <span class="indicator-label" style="font-size: 12px">
                                     Save
                                    </span>
                                <span id="indicatorProgress" class="indicator-progress d-none" style="font-size: 12px">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            <button type="button"  class="btn btn-success me-1 mb-2 text-uppercase"  id="btn-save-and-close">
                               <span class="indicator-label" style="font-size: 12px">
                                     Save & Close
                                    </span>
                                <span id="indicatorProgress" class="indicator-progress d-none" style="font-size: 12px">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
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
            $('.accordion-button').click(function() {
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
                const $panelBody = $(this).closest('.accordion-item').find('.accordion-collapse');
                $panelBody.collapse('toggle');
            });

            // $('#select-label').css('display', 'none');

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

            // $('#technician_statement').select2({
            //     dropdownParent: $('#booking-modal'),
            // });

            $('#customer_id').select2({
                tags: true,
                width: '100%',
                dropdownParent: $('#booking-modal'),
                ajax: {
                    url: "{{ route('api.customer') }}",
                    dataType: 'json'
                }
            });


            const colsToToggle = ["status", "calendar", "model", "service-invoice"];
            // colsToToggle.forEach((col) => {
            //     const colElement = document.getElementById(col);
            //     if (colElement) {
            //         console.log(colElement)
            //         colElement.style.display = "none";
            //     }
            // });
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

        $("#btn-save-and-close").click(function () {
            saveAndClose = true;
        });

        $(".booking-form").submit(function (event) {
            event.preventDefault();

            const checkboxes = $(this).find('input[type="checkbox"]');
            checkboxes.each(function () {
                const checkbox = $(this);
                if (checkbox.is(':checked') === true) {
                    checkbox.val(1);
                } else {
                    checkbox.val(0);
                }
            });

            const formData = $(this).serialize();

            {{--$.ajax({--}}
            {{--    url: "{{ route('booking.save') }}",--}}
            {{--    type: "POST",--}}
            {{--    data: formData,--}}
            {{--    dataType: "json",--}}
            {{--    success: function (response) {--}}
            {{--        if (saveAndClose) {--}}
            {{--            $("#booking-modal").modal('hide'); // close the modal on success--}}
            {{--            saveAndClose = false;--}}
            {{--        }--}}
            {{--        $('#vehicle_history_id').val(response.id);--}}
            {{--        showMessage(response);--}}
            {{--        calendar.refetchEvents();--}}
            {{--    },--}}
            {{--    error: function (xhr, status, error) {--}}
            {{--        var errorMessage = xhr.responseText; // Retrieve the error message--}}
            {{--        console.log(errorMessage); // Display the error message in the console--}}
            {{--        // Handle the error message--}}
            {{--    }--}}
            {{--});--}}
        });

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
        let isOpenPre = false, isOpenSignOff = false, isJobNotComplete = false, isDetailBtn=false;

        isDetailBtn = false;

        // function detail() {
        //
        //     const detailButton = document.getElementById("detail-btn");
        //     const status = document.getElementById('select-label');
        //
        //     const colsToToggle = ["status", "calendar", "model", "service-invoice"];
        //
        //     if (!isDetailBtn) {
        //         status.style.display = 'block';
        //         colsToToggle.forEach((col) => {
        //             const colElement = document.getElementById(col);
        //             if (colElement) {
        //                 colElement.style.display = "block";
        //             }
        //         });
        //         isDetailBtn = true;
        //         detailButton.innerText = "Hide Details";
        //     } else {
        //         status.style.display = 'none';
        //         colsToToggle.forEach((col) => {
        //             const colElement = document.getElementById(col);
        //             if (colElement) {
        //                 colElement.style.display = "none";
        //             }
        //         });
        //         isDetailBtn = false;
        //         detailButton.innerText = "Show Details";
        //     }
        // }

        function pre() {
            const preInstallation = document.getElementById("pre-installation-check");
            if (!isOpenPre) {
                preInstallation.style.display = "block";
                isOpenPre = true;
            } else {
                // preInstallation.style.display = "none";
                isOpenPre = false;
            }
        }
        window.addEventListener("DOMContentLoaded", function() {
            const preInstallation = document.getElementById("pre-installation-check");
            // preInstallation.style.display = "none";
        });

        window.onload = function() {
            document.getElementById("pre-installation-check").style.display = 'none';

        };

        function signoff() {
            const signOff = document.getElementById("signoff"); // Declare z outside the if-else block

            if (!isOpenSignOff) {
                signOff.style.display = "block";
                isOpenSignOff = true;
            } else {
                // signOff.style.display = "none";
                isOpenSignOff = false;
            }
        }
        window.addEventListener("DOMContentLoaded",function(){
            const signOff = document.getElementById("signoff");
            // signOff.style.display="none"
        });
        window.onload=function(){
            // document.getElementById("signoff").style.display="none"
        }

        function jobNot(){
            const jobnot = document.getElementById("job-not-completed"); // Declare z outside the if-else block

            if (!isJobNotComplete) {
                jobnot.style.display = "block";
                isJobNotComplete = true;
            } else {
                // jobnot.style.display = "none";
                isJobNotComplete = false;
            }
        }
        window.addEventListener("DOMContentLoaded",function(){
            const jobnot = document.getElementById("job-not-completed");
            // jobnot.style.display="none"
        });
        window.onload=function(){
            // document.getElementById("job-not-completed").style.display="none"
        }




    </script>
@endsection
<style>
    .button-33 {
        background-color: #FFBF00;
        border-radius: 100px;
        box-shadow: rgb(187, 151, 44) 0 -25px 18px -14px inset, rgb(187, 163, 44) 0 1px 2px, rgb(187, 173, 44) 0 2px 4px, rgb(187, 163, 44) 0 4px 8px, rgba(44, 187, 99, .15) 0 8px 16px, rgba(44, 187, 99, .15) 0 16px 32px;
        color: #000000;
        cursor: pointer;
        display:block;
        font-family: CerebriSans-Regular, -apple-system, system-ui, Roboto, sans-serif;
        padding: 7px 20px;
        text-align: center;
        text-decoration: none;
        transition: all 250ms;
        border: 0;
        font-size: 16px;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        margin: 8px 8px 3px 0;
        width: auto;
        height: auto;
    }
.modal-footer{
    position: sticky;
    bottom: 0;
    background: white;
}
.booking-form .modal-body{
    max-height: 420px !important;
}
    h6#added_by_username {
        margin-left: 14px;
    }
    h5.update_info_date {
        font-size: 12px;
        font-weight: 600;
    }
    .convas_btn{
        text-align: center;
        margin-top: 20px;
    }
</style>
