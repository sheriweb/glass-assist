<style>
    .table thead th {
        background-color: #FFFFFF;
        padding: 0
    }

    .table > thead {
        font-size: 14px !important;
        text-align: center;
    }

    .fc-col-header-cell {
        width: 125px !important;
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
    }

    .jira-card-head {
        display: flex;
        justify-content: space-between;
    }

    .jira-card .jira-card-id {
        padding: 2px 6px;
        background-color: #F5F5F5;
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
        background-color: #F5F5F5;
        border-radius: 3px;
    }

    .jira-card .jira-card-description {
        margin-bottom: 7px;
        font-size: 10px;
    }

    .jira-card .jira-card-footer {
        background-color: #F5F5F5;
        padding: 2px 6px;
        border-bottom-left-radius: 6px;
        border-bottom-right-radius: 6px;
        font-size: 9px;
    }

    .jira-card {
        float: right;
    }
</style>

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="mb-3">
                <x-pages.header
                        title="Technician Assigned Jobs"></x-pages.header>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="fc-toolbar fc-header-toolbar">
                                <div class="fc-left">
                                    <div class="btn-group">
                                        <a href="{{route('previous-date',['date' => $selectedDate])}}"
                                           class="fc-prev-button btn btn-primary" aria-label="prev">
                                            <span class="fa fa-chevron-left"></span>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{route('next-date',['date'=> $selectedDate])}}"
                                           class="fc-next-button btn btn-primary" aria-label="next">
                                            <span class="fa fa-chevron-right"></span></a>
                                    </div>
                                </div>
                                <div class="fc-center"><h2>Showing Appointments
                                        for {{ date('d/m/Y', strtotime($selectedDate))}}</h2></div>
                                <div class="fc-right">
                                    <div class="btn-group">
                                        <a href="javascript:history.back()"
                                           class="fc-next-button btn btn-primary" aria-label="next">
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <table id="technician_view_table" class="table table-bordered dt-responsive"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                @foreach($technicians as $technician)
                                    <th class="fc-day-header fc-mon fc-past">
                                        <div class="fc-col-header-cell mt-2 mb-2 me-2 d-flex flex-column align-items-center">
                                            <a>
                                                <span class="fc-col-header-cell-day">{{ucwords(strtolower($technician->name))}}</span>
                                                <br/>
                                                <span class="fc-col-header-cell-date text-primary">{{@$technician->vehicleMaintenances->reg}}</span>
                                            </a>
                                            {{--<a class="btn btn-outline-primary mt-1 ms-2 new-booking-buttons font-size-11" id="new-booking-button" data-date="Sat May 27 2023 00:00:00 GMT+0500 (Pakistan Standard Time)" style="display: block;">
                                                Add New Booking
                                            </a>--}}
                                        </div>
                                        <hr style="width: 100%; margin-bottom:5px">
                                        <div class="mt-1 mb-2">
                                        <span class="fc-col-header-cell-date">Total Jobs:
                                            <span class="event-count-22-05-2023 mb-2">
                                                {{ $technician->vehicleHistoriesForDate($selectedDate)->count() }}
                                            </span>
                                        </span>
                                        </div>
                                    </th>
                                @endforeach
                                </thead>
                                <tbody>
                                <tr>
                                    @foreach ($technicians as $technician)
                                        <td>
                                            <table>
                                                @foreach ($technician->vehicleHistoriesForDate($selectedDate)->get() as $item)
                                                    <?php
                                                    $title = "";
                                                    $description = "";
                                                    $carMakeModel = "";
                                                    $footer = "";
                                                    $className = "border-1 m-2 text-wrap rounded p-2";

                                                    $title .= $item->company ? "<i class='fa fa-industry'></i> " . ucwords(
                                                            strtolower($item->company->name)
                                                        ) . "<br/>" : "";
                                                    $title .= $item->customer->first_name ? "<i class='fa fa-user'></i> " . ucwords(
                                                            strtolower($item->customer->first_name)
                                                        ) . " " : "";
                                                    $title .= $item->customer->surname ? ucwords(
                                                            strtolower($item->customer->surname)
                                                        ) . "<br/>" : "";

                                                    $carMakeModel .= $item->vehicle->carMake ? ucwords(
                                                            strtolower($item->vehicle->carMake->name)
                                                        ) . " - " : "";
                                                    $carMakeModel .= $item->vehicle->carModel ? ucwords(
                                                            strtolower($item->vehicle->carModel->name)
                                                        ) . " " : "";
                                                    $carMakeModel .= $item->vehicle->reg_no ? "({$item->vehicle->reg_no})" : "";

                                                    $description .= $item->customer->address_2 ? "<i class='fa fa-location-arrow'></i> " . ucwords(
                                                            strtolower($item->customer->address_2)
                                                        ) . "<br/>" : "";
                                                    $description .= $item->customer->city ? ($description ? "" : "<i class='fa fa-location-arrow'></i> ") . ucwords(
                                                            strtolower($item->customer->city)
                                                        ) . "<br/>" : "";
                                                    $description .= $item->subcat_name ? ucwords(
                                                            strtolower($item->subcat_name)
                                                        ) . "<br/>" : "";
                                                    $description .= $item->subContractor ? "<i class='fa fa-forward'></i> " . ucwords(
                                                            strtolower($item->subContractor->name)
                                                        ) . "<br/>" : "";
                                                    $description .= $item->glassSupplier ? "<i class='fa fa-share'></i> " . ucwords(
                                                            strtolower($item->glassSupplier->name)
                                                        ) . "<br/>" : "";
                                                    $description .= $item->glasssupplier_name == 'calibration' ? "Calibration<br/>" : "";
                                                    $footer .= $item->part_code ? "<i class='fa fa-barcode'></i> " . $item->part_code . "<br/>" : "";
                                                    $footer .= $item->technicianData ? "<i class='fa fa-tools'></i> " . ucwords(
                                                            strtolower($item->technicianData->first_name)
                                                        ) . " " : "";
                                                    $footer .= $item->technicianData ? ucwords(
                                                        strtolower($item->technicianData->surname)
                                                    ) : "";
                                                    ?>
                                                    <tr>
                                                        <td class="jira-card-container">
                                                            <div class="jira-card"
                                                                 style="border: 2px solid {{ $item->statusColor() }}; color: {{ $item->statusColor() }}">
                                                                <div class="jira-card-id">
                                                                    <i class="fa fa-bookmark"></i> {{ $item->id }}
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
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
		$('#technician_view_table').dataTable({
			responsive: false,
			scrollX: true,
			scrollY: true,
			searching: false,
			paging: false,
			info: false,
			ordering: false,
			"oLanguage": {"sZeroRecords": "", "sEmptyTable": ""},
		});
    </script>
    <script>
		function myFunction(id) {
			$.ajax({
				url: '/booking/find/' + id,
				method: 'get',
				success: function (response) {
					$('#job-card-id').text("#" + response.id);
					$('#vehicle_history_id').val(response.id);

					if (response.signature !== '') {
						let signatureImage = response.signature;
						let source = "{!! asset('upload/signatures/') !!}";
						$('.canvas_image_show').attr('src', source + signatureImage);
					}

					$.each(response, function (id, value) {
						$('#' + id).val(value);

						if (response.vehicle.length !== 0) {
							$.each(response.vehicle, function (objId, objValue) {
								$('#vehicle_' + objId).val(objValue);
							});
						}

						if (response.company.length !== 0) {
							$.each(response.company, function (objId, objValue) {
								$('#company_' + objId).val(objValue);
							});
						}

						if (response.customer.length !== 0) {
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
				}
			});

			$('#technician-booking-modal').modal('show');
		}
    </script>
@endsection
