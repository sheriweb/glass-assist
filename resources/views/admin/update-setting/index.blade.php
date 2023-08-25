@php

    use App\Helpers\BladeHelpers;

    $defaultDueDate = [
        (object)[
            'id' => 'due_date_1',
            'name' => 'Service'
        ],
        (object)[
            'id' => 'due_date_2',
            'name' => 'MOT'
        ],
        (object)[
            'id' => 'due_date_3',
            'name' => 'Warranty'
        ]
    ];

@endphp

@extends('master')

@section('content')

    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Update System Settings" back="admin"/>

            <x-forms.form route="{{ route('admin.update-settings') }}">
                @method('put')

                <div class="row">
                    <x-forms.input label="Email" name="email" :value="$admin->email" required/>

                    <x-forms.input label="Link 01" name="link_01" :value="$admin->link_01"/>

                    <x-forms.input label="Company Name" name="company_name" :value="$admin->company_name"/>

                    <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                              :selected="$admin->link_01_colour" name="link_01_colour"/>

                    <x-forms.checkbox name="vat_registered" label="VAT Register" :checked="$admin->vat_registered"/>

                    <x-forms.input label="Display Code" name="link_01_code" :value="$admin->link_01_code"/>

                    <x-forms.input label="VAT Number" name="vat_number" type="number" :value="$admin->vat_number"/>

                    <x-forms.input label="Link 02" name="link_02" :value="$admin->link_02"/>

                    <x-forms.input label="Title" name="title" :value="$admin->title"/>

                    <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                              :selected="$admin->link_02_colour" name="link_02_colour"/>

                    <x-forms.input label="First Name" name="first_name" :value="$admin->first_name"/>

                    <x-forms.input label="Display Code" name="link_02_code" :value="$admin->link_02_code"/>

                    <x-forms.input label="Surname" name="surname" :value="$admin->surname"/>

                    <x-forms.input label="Link 03" name="link_03" :value="$admin->link_03"/>

                    <x-forms.input label="Address 1" name="address_1" :value="$admin->address_1"/>

                    <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                              :selected="$admin->link_03_colour" name="link_03_colour"/>

                    <x-forms.input label="City" name="city" :value="$admin->city"/>

                    <x-forms.input label="Display Code" name="link_03_code" :value="$admin->link_03_code"/>

                    <x-forms.input label="County" name="county" :value="$admin->county"/>

                    <x-forms.input label="Link 04" name="link_04" :value="$admin->link_04"/>

                    <x-forms.input label="Postcode" name="postcode" :value="$admin->postcode"/>

                    <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                              :selected="$admin->link_04_colour" name="link_04_colour"/>

                    <x-forms.input label="Phone" name="phone" :value="$admin->phone"/>

                    <x-forms.input label="Display Code" name="link_04_code" :value="$admin->link_04_code"/>

                    <x-forms.input label="Mobile" name="mobile" :value="$admin->mobile"/>

                    <x-forms.input label="Link 05" name="link_05" :value="$admin->link_05"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                              :selected="$admin->link_05_colour" name="link_05_colour"/>

                    <div class="col-lg-6"></div>

                    <x-forms.input label="Display Code" name="link_05_code" :value="$admin->link_05_code"/>

                    @for($i = 6; $i < 13; $i++)
                        <div class="col-lg-6"></div>

                        <x-forms.input :label="($i > 9 ? 'Link ' : 'Link 0') . $i " :name="($i > 9 ? 'link_' : 'link_0') . $i"
                                 :value="$admin->{($i > 9 ? 'link_' : 'link_0') . $i}"/>

                        <div class="col-lg-6"></div>

                        <x-forms.select label="Background Colour" :options="BladeHelpers::selectColor()"
                                  :selected="$admin->{($i > 9 ? 'link_' : 'link_0') . $i . '_colour'}"
                                  :name="($i > 9 ? 'link_' : 'link_0') . $i . '_colour'"/>

                        <div class="col-lg-6"></div>

                        <x-forms.input label="Display Code" :name="($i > 9 ? 'link_' : 'link_0') . $i . '_code'"
                                 :value="$admin->{($i > 9 ? 'link_' : 'link_0') . $i . '_code'}"/>
                    @endfor

                    <x-forms.select label="Site Background" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_1" name="colour_1"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Site Text" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_2" name="colour_2"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Site Links" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_3" name="colour_3"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Header Background" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_4" name="colour_4"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Header Text" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_5" name="colour_5"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Table Headers" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_6" name="colour_6"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Table Background" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_7" name="colour_7"/>

                    <div class="col-lg-6"></div>

                    <x-forms.select label="Borders" :options="BladeHelpers::selectColor()"
                              :selected="$admin->colour_8" name="colour_8"/>

                    <div class="col-lg-6"></div>

                    <x-forms.checkbox name="enable_cron" label="Enable Automated Messages" :checked="$admin->enable_cron"/>

                    <x-forms.input name="tag_customer" :value="$admin->tag_customer" label="Tag Customer"/>

                    <x-forms.checkbox name="show_payment_method" label="Show paid amount"
                                :checked="$admin->show_payment_method"/>

                    <x-forms.input name="tag_vehicle" :value="$admin->tag_vehicle" label="Tag Vehicle"/>

                    <x-forms.checkbox name="show_cost" label="Show Cost" :checked="$admin->show_cost"/>

                    <x-forms.input name="tag_item" :value="$admin->tag_item" label="Tag Item"/>

                    <x-forms.checkbox name="show_amount_paid" label="Show Amount Paid" :checked="$admin->show_amount_paid"/>

                    <x-forms.input name="tag_vehicle_reg" :value="$admin->tag_vehicle_reg" label="Tag Vehicle Reg"/>

                    <x-forms.checkbox name="show_company" label="Show Company" :checked="$admin->show_company"/>

                    <x-forms.input name="tag_vin_number" :value="$admin->tag_vin_number" label="Tag VIN Number"/>

                    <x-forms.checkbox name="show_invoice_margin" label="Show Invoice Margin"
                                :checked="$admin->show_invoice_margin"/>

                    <x-forms.input name="tag_miles" :value="$admin->tag_miles" label="Tag Miles"/>

                    <x-forms.input name="invoice_margin_top" :value="$admin->invoice_margin_top" label="Invoice Margin Top"
                             type="number"/>

                    <x-forms.input name="tag_due_date_1" :value="$admin->tag_due_date_1" label="Tag Due Date 1" type="date"/>

                    <x-forms.input name="invoice_margin_bottom" :value="$admin->invoice_margin_bottom"
                             label="Invoice Margin Bottom" type="number"/>

                    <x-forms.input name="tag_due_date_2" :value="$admin->tag_due_date_2" label="Tag Due Date 2" type="date"/>

                    <x-forms.input name="hourly_rate" :value="$admin->hourly_rate" label="Hourly Rate" type="number"/>

                    <x-forms.input name="tag_due_date_3" :value="$admin->tag_due_date_3" label="Tag Due Date 3" type="date"/>

                    <x-forms.input name="start_time" :value="$admin->start_time" label="Start Time" type="time"/>

                    <x-forms.input name="tag_reminder" :value="$admin->tag_reminder" label="Tag Reminder"/>

                    <x-forms.select label="Default Due Date" :options="$defaultDueDate"
                              :selected="$admin->default_due_date" name="default_due_date"/>

                    <div class="col-lg-6"></div>

                    <x-forms.textarea name="msg_due_date_1" label="Service Due Date Message" :value="$admin->msg_due_date_1"/>

                    <x-forms.textarea name="msg_booking_24" label="Booking 24 Hour Message (Drop Off)"
                                :value="$admin->msg_booking_24"/>

                    <x-forms.textarea name="msg_due_date_2" label="MOT Due Date Message" :value="$admin->msg_due_date_2"/>

                    <x-forms.textarea name="msg_booking_24_pickup" label="Booking 24 Hour Message (Pick Up)"
                                :value="$admin->msg_booking_24_pickup"/>

                    <x-forms.textarea name="msg_due_date_3" label="Warranty Due Date Message"
                                :value="$admin->msg_due_date_3"/>

                    <x-forms.textarea name="msg_booking_24_cc" label="Booking 24 Hour Message (Courtesy Car)"
                                :value="$admin->msg_booking_24_cc"/>

                    <div class="col-lg-6 mb-2">
                        <h4>Replacement Labels</h4>
                        [REGNO] = {{ $admin->tag_vehicle_reg }}<br/>
                        [PHONE] = {{ $admin->phone }}<br/>
                        [COMPANYNAME] = {{ $admin->company_name }}<br/>
                        [RELATED] = {{ $admin->tag_vehicle }}<br/>
                        [DUEDATE1] = {{ $admin->tag_due_date_1 }}<br/>
                        [DUEDATE2] = {{ $admin->tag_due_date_2 }}<br/>
                        [DUEDATE3] = {{ $admin->tag_due_date_3 }}
                    </div>

                    <x-forms.textarea name="msg_booking_instant" label="Booking Instant Message"
                                :value="$admin->msg_booking_instant"/>

                    <div class="col-lg-6">
                        <h4>
                            Booking 24 Hour Message only <br>
                            Booking Instant Message and
                        </h4>
                        [DATE] = Date Due<br>
                        [TIME] = Appointment Time
                    </div>

                    <x-forms.textarea name="msg_booking_completed" label="Booking Completed Message"
                                :value="$admin->msg_booking_completed"/>
                </div>

                <x-forms.button text="Save" large/>
            </x-forms.form>
        </div>
    </div>
@endsection

@section('scripts7')
    <script>
        $(document).ready(function() {
            $('#default_due_date').select2();
            $('#colour_8').select2();
            $('#colour_7').select2();
            $('#colour_6').select2();
            $('#colour_5').select2();
            $('#colour_4').select2();
            $('#colour_3').select2();
            $('#colour_2').select2();
            $('#colour_1').select2();
        });
    </script>
@endsection
