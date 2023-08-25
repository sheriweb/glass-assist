<style>
    .table thead th {
        background-color: #FFFFFF;
    }

    .table > thead {
        font-size: 14px !important;
        text-align: center;
    }

    td {
        border-right-width: 0 !important;
    }

    .jira-card {
        border-radius: 6px;
        padding: 10px;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        font-family: Arial, sans-serif;
        font-size: 10px;
        cursor: pointer;
        pointer-events: auto;
        border: 2px solid;
        margin-bottom: 10px !important;
        width: 400px;
    }

    .jira-card-head {
        display: flex;
        justify-content: space-between;
    }

    .jira-card .jira-card-id {
        padding: 2px 6px;
        border-top-left-radius: 6px;
        border-top-right-radius: 6px;
        margin-bottom: 7px;
    }

    .jira-card .jira-card-title {
        font-weight: bold;
        margin-bottom: 7px;
    }

    .jira-card .jira-card-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 7px;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 3px;
    }

    .jira-card .jira-card-description {
        margin-bottom: 7px;
        font-size: 10px;
    }

    .jira-card .jira-card-footer {
        padding: 2px 6px;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        font-size: 9px;
    }

    table {
        margin: 0 auto;
    }

    .jira-card {
        float: none;
        margin: 0 auto;
        margin-bottom: 20px;
    }

    .jira-card:nth-child(2) {
        margin-left: 400px;
    }

    .fc-toolbar.fc-header-toolbar {
        margin-bottom: 0.5em;
    }
    .wrapper{
        width:70%;
    }
    @media(max-width:992px){
        .wrapper{
            width:100%;
        }
    }
    .accordion-button:not(.collapsed)::after {
        background-image: initial !important;
        -webkit-transform: initial !important;
        transform: initial !important;
    }
    .accordion-button:not(.collapsed){
        background-color: whitesmoke !important;
    }
    .drop_arrow{
        color: #0a1832 !important;
    }
</style>

@extends('master')

@section('content')
    <div>
        <div class="page-content">
            <div class="container-fluid">
                <x-technician-booking-modal></x-technician-booking-modal>

                <div class="mb-3">
                    <x-pages.header title="Technician Assigned Jobs"></x-pages.header>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="fc-toolbar fc-header-toolbar">
                                    <div class="fc-left">
                                        <div class="btn-group"></div>
                                    </div>
                                    <div class="fc-center">
                                        <h2 class="text-center">
                                            Showing Appointments for {{ date('d/m/Y', strtotime(now()->format('l')))}}
                                            <br/>
                                            {{ now()->format('l') }}
                                        </h2>
                                    </div>
                                    <div class="fc-right">
                                        <div class="btn-group">
                                        </div>
                                    </div>
                                </div>

                                <table class="table" class="p-5">
                                    <thead class="thead-dark">
                                    <tr>
                                        <td colspan="7" class="bg-light">
                                            <div>
                                                <b> You are logged in as: {{ Auth::user()->username }} </b>
                                            </div>
                                        </td>
                                    </tr>
                                    </thead>

                                    @foreach($todayBookings as $booking)
                                        <?php
                                        $title = "";
                                        $description = "";
                                        $carMakeModel = "";
                                        $footer = "";
                                        $className = "border-1 m-2 text-wrap rounded p-2";

                                        $title .= $booking->company ? "<i class='fa fa-industry'></i> " . ucwords(
                                                strtolower($booking->company->name)
                                            ) . "<br/>" : "";
                                        $title .= $booking->customer->first_name ? "<i class='fa fa-user'></i> " . ucwords(
                                                strtolower($booking->customer->first_name)
                                            ) . " " : "";
                                        $title .= $booking->customer->surname ? ucwords(
                                                strtolower($booking->customer->surname)
                                            ) . "<br/>" : "";

                                        $carMakeModel .= $booking->vehicle->carMake ? ucwords(
                                                strtolower($booking->vehicle->carMake->name)
                                            ) . " - " : "";
                                        $carMakeModel .= $booking->vehicle->carModel ? ucwords(
                                                strtolower($booking->vehicle->carModel->name)
                                            ) . " " : "";
                                        $carMakeModel .= $booking->vehicle->reg_no ? "({$booking->vehicle->reg_no})" : "";

                                        $description = htmlspecialchars($description);
                                        $description .= $booking->customer->address_2 ? "<i class='fa fa-location-arrow'></i> " . ucwords(
                                                strtolower($booking->customer->address_2)
                                            ) . "<br/>" : "";
                                        $description .= $booking->customer->city ? ($description ? "" : "<i class='fa fa-location-arrow'></i> ") . ucwords(
                                                strtolower($booking->customer->city)
                                            ) . "<br/>" : "";
                                        $description .= $booking->subcat_name ? ucwords(
                                                strtolower($booking->subcat_name)
                                            ) . "<br/>" : "";
                                        $description .= $booking->subContractor ? "<i class='fa fa-forward'></i> " . ucwords(
                                                strtolower($booking->subContractor->name)
                                            ) . "<br/>" : "";
                                        $description .= $booking->glassSupplier ? "<i class='fa fa-share'></i> " . ucwords(
                                                strtolower($booking->glassSupplier->name)
                                            ) . "<br/>" : "";
                                        $description .= $booking->glasssupplier_name == 'calibration' ? "Calibration<br/>" : "";
                                        $footer .= $booking->part_code ? "<i class='fa fa-barcode'></i> " . $booking->part_code . "<br/>" : "";
                                        $footer .= $booking->technicianData ? "<i class='fa fa-tools'></i> " . ucwords(
                                                strtolower($booking->technicianData->first_name)
                                            ) . " " : "";
                                        $footer .= $booking->technicianData ? ucwords(
                                            strtolower($booking->technicianData->surname)
                                        ) : "";
                                        ?>

                                        <tr>
                                            <td class="jira-card-container">
                                                <div class="jira-card" data-toggle="modal" data-target="#booking-modal"
                                                     style="border: 2px solid {{ $booking->statusColor() }}; color: {{ $booking->statusColor() }}; background: white">
                                                    <div class="jira-card-id">
                                                        <i class="fa fa-bookmark" id="status-id" job-id="{{ $booking->id }}"></i> {{ $booking->id }}
                                                    </div>
                                                    <div class="jira-card-header">
                                                        <div class="jira-card-title">
                                                            {!! $title !!}
                                                        </div>
                                                    </div>
                                                    @if($carMakeModel)
                                                        <div class="jira-card-info">
                                                            <div class="jira-card-info-item">
                                                                <i class="fa fa-car"></i> {{ $carMakeModel }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="jira-card-description">
                                                        {!! $description !!}
                                                    </div>
                                                    <div class="jira-card-footer">
                                                        {!! $footer !!}
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
		$(document).ready(function () {
            $('.panel-collapse').on('show.bs.collapse', function () {
                alert()
                $(this).siblings('.panel-heading').addClass('active');
            });

            $('.panel-collapse').on('hide.bs.collapse', function () {
                $(this).siblings('.panel-heading').removeClass('active');
            });

            $(document).on('click','#btn-save-booking', function (){
                var btn = $(this);
                updateTechnicianBooking(btn)
            });
            function updateTechnicianBooking(btn)
            {
                dataIndicator(btn,'on');
                const formElement = document.getElementById('technician-booking-form');
                var formData = new FormData(formElement);
                $.ajax({
                    url:"{{ route('update.technician.booking') }}",
                    method:"POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(res){
                        dataIndicator(btn,'off');
                        if(res.status == 200){
                            getBooking(res.vehicle_history_id);
                        }
                    },
                    error: function (xhr, status, error) {
                        var errorMessage = xhr.responseText; // Retrieve the error message

                    }
                })
            }

            $('.jira-card').click(function (e) {
                let jobId = $('#status-id').attr('job-id');
                $('#job-card-id').text(jobId);
                    getBooking(jobId);
                $("#technician-booking-modal").modal('show');
            });
            function getBooking(jobId)
            {
                $.ajax({
                    url: '/booking/find/' + jobId,
                    method: 'get',
                    success: function (response) {
                        if (response.vehicle.make_id !== null && response.vehicle.make_id !== 0) {
                            loadMakeModel(response.vehicle.make_id, response.vehicle.model_id);
                        }

                        $('#job-card-id').text("#" + response.id);
                        $('#card_status').text(response.status_text);
                        $('#vehicle_history_id').val(response.id);
                        $('#user_s_name').val(response.current_user);
                        $('#user_s_date').val(response.current_date_time);
                        /*var selectedOption = $('<option></option>').attr('value', response.customer_id).text(response.customer.first_name + ' ' + response.customer.surname);
                        $('#customer_id').empty();
                        $('#customer_id').append(selectedOption)*/

                        if (response.signature !== '' && response.signature !== null) {
                            let signatureImage = response.signature;
                            let source = "{!! asset('upload/signatures/') !!}";
                            $('#canvas_image_show').attr('src', source + '/' + signatureImage);
                        }
                        if(response.pre_job_complete){
                            preInstallation('disable',response.pre_job_complete);
                        }
                        if(response.job_complete){
                            preInstallation('disable', response.pre_job_complete);
                            JobCompleted('disable',response.job_complete);
                            // jobNotCompleted('disable',response.job_complete);
                        }
                        if(response.job_not_completed){
                            preInstallation('disable', response.pre_job_complete);
                            JobCompleted('disable',response.job_not_completed);
                            jobNotCompleted('disable',response.job_not_completed);
                        }
                        $.each(response, function (id, value) {
                            $('.added-updated-info').show();
                            $('#' + id).val(value);
                            $('#datetime').val(formatDateToYmd(response.datetime));

                            if (response.vehicle.length !== 0) {
                                $.each(response.vehicle, function (objId, objValue) {
                                    $('#vehicle_' + objId).val(objValue);
                                });
                            }

                            if (response.company !== null) {
                                $.each(response.company, function (objId, objValue) {
                                    $('#company_' + objId).val(objValue);
                                });
                            }

                            if (response.customer !== null) {
                                $.each(response.customer, function (objId, objValue) {
                                    $('#customer_' + objId).val(objValue);
                                });
                            }


                            if (response.added_by !== null) {

                                $('#added_by_username').text(capitalizeFirstLetter(response.added_by.username));
                                $('#date_added').text(formatDate(response.date_added));
                                $('#booked_by_username').text(capitalizeFirstLetter(response.booked_by));
                                $('#booked_by_date').text(formatDate(response.date_added));
                            }

                            if (response.updated_by !== null) {
                                $('#updated_by_username').text(capitalizeFirstLetter(response.updated_by.username));
                                $('#date_updated').text(formatDate(response.date_updated));
                                $('#updated_by_status_username').text(capitalizeFirstLetter(response.update_status_by));
                                $('#updated_by_status_date').text(formatDate(response.date_updated));
                            }

                            if (response.not_completed_by !== null) {
                                $('#not_completed_by_username').text(capitalizeFirstLetter(response.not_completed_by));
                                $('#not_completed_by_date').text(formatDate(response.not_completed_date));
                            } else {
                                $('#not_completed_by_section').css('display', 'none');
                            }
                        });

                        document.getElementById('calibration').checked = response.calibration === 1;
                    }
                });
            }

            function preInstallation(type, pre_job_complete)
            {
                if(type == 'disable'){
                    $('#pre_check_notes').prop('disabled', true);
                    $('#pre_c_name').prop('disabled', true);
                    if(pre_job_complete)
                    $('input#pre_job_complete').prop('checked', true);

                    $('#sig-submitBtn').prop('disabled', true);
                    $('input#pre_job_complete').attr("disabled", true);
                }
                else{
                    $('#pre_check_notes').prop('disabled', false);
                    $('#pre_c_name').prop('disabled', false);
                    $('input#pre_job_complete').prop('checked', true);
                    $('#sig-submitBtn').prop('disabled', false);
                    $('input#pre_job_complete').attr("disabled", false);
                }
            }
            function JobCompleted(type, job_complete){
                if(type == 'disable'){
                    $('#c_name').prop('disabled', true);
                    $('#payment_type').prop('disabled', true);
                    if(pre_job_complete)
                        $('input#job_complete').prop('checked', true);

                    $('#sig-submitBtn2').prop('disabled', true);
                    $('input#job_complete').attr("disabled", true);
                }else{
                    $('#c_name').prop('disabled', false);
                    $('#payment_type').prop('disabled', false);
                    if(pre_job_complete)
                    $('input#job_complete').prop('checked', true);

                    $('#sig-submitBtn2').prop('disabled', false);
                    $('input#job_complete').attr("disabled", false);
                }
            }
            function jobNotCompleted(type, job_not_completed){
                if(type == 'disable'){
                    $('#technician_statement').prop('disabled', true);
                    $('#technician_note').prop('disabled', true);
                    if(job_not_completed)
                        $('input#job_not_completed').prop('checked', true);

                    $('input#job_not_completed').attr("disabled", true);

                }else{
                    $('#technician_statement').prop('disabled', false);
                    $('#technician_note').prop('disabled', false);
                    if(job_not_completed)
                        $('input#job_not_completed').prop('checked', true);

                    $('input#job_not_completed').attr("disabled", false);
                }
            }

		});
    </script>
@endsection
