@php
    $heads = ['Job No', 'Date Job Added', 'Date Booked For', 'Reg', 'Company', 'Customer Name', 'Address Line 1', 'Post Code', 'Booking Agent', 'Job Status', 'Invoice Status', 'View'];
@endphp

@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="All Bookings">
                <button type="button" class="btn btn-secondary mr-5">Export</button>
                <button type="button" class="btn btn-secondary">Duplicate</button>
            </x-pages.header>

            <x-pages.table :heads="$heads" id="allBookingsTable"></x-pages.table>
			<x-booking-modal></x-booking-modal>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
		$(document).ready(function () {
			$('#allBookingsTable').DataTable({
				pageLength: 500,
				lengthMenu: [[500, 100, 50, 25, 10, -1], [500, 100, 50, 25, 10, "All"]],
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('booking.all-bookings') }}",
					dataType: "json",
					type: "GET",
				},
				language: {
					processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
				},
				columns: [
					{data: 'id'},
					{data: 'date_added'},
					{data: 'datetime'},
					{data: 'reg_no'},
					{data: 'company_name'},
					{data: 'customer_name'},
					{data: 'address_1'},
					{data: 'postcode'},
					{data: 'booked_by'},
					{data: 'status'},
					{data: 'is_invoiced'},
					{data: 'view'},
				]
			});
		});

		$(document).on('click', '.view-booking', function () {
			const id = this.id;
			$.ajax({
				url: '/booking/find/' + id,
				method: 'get',
				success: function (response) {
					if (response.vehicle.make_id !== null && response.vehicle.make_id !== 0) {
						loadMakeModel(response.vehicle.make_id, response.vehicle.model_id);
					}

					$('#job-card-id').text("#" + response.id);
					$('#vehicle_history_id').val(response.id);

					if (response.signature !== '' && response.signature !== null) {
						let signatureImage = response.signature;
						let source = "{!! asset('upload/signatures/') !!}";
						$('#canvas_image_show').attr('src', source + '/' + signatureImage);
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

			$('#booking-modal').modal('show');
		});
    </script>
@endsection
