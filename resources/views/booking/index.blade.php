@extends('master')

@section('content')
    <style>
        .fc-row .fc-bg {
            z-index: 1;
        }

        .jira-card-container {
            padding: 10px 10px 0 10px;
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

        .jira-card .close-icon {
            float: right;
        }

        .jira-card .jira-card-calendar-type {
            font-weight: bold;
            text-transform: capitalize;
            margin-top: 5px;
        }

        .fc-event {
            text-align: left;
            background-color: inherit;
        }

        .fc-title {
            white-space: normal;
        }

        .fc-daygrid-day {
            margin-bottom: 0;
        }

        .existing_customer_visibility {
            display: none;
        }

        .new_customer_visibility {
            display: block;
        }

        .fc-more {
            font-size: 15px !important;
        }

        .fc-popover.fc-more-popover {
            max-height: 500px;
            overflow-y: auto;
        }

        .event-card {
            background-color: #ffffff;
            color: #333;
            border: 4px solid;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 5px;
        }

        .event-title {
            font-weight: bold;
        }

        .partition {
            margin: 5px 0;
            border-bottom: 1px solid #ccc;
        }

        .modal-xl {
            max-width: 100%;
            margin: 30px 100px;
        }

        .modal-content {
            display: flex;
            flex-direction: column;
        }

        .modal-body {
            flex-grow: 1;
            max-height: 560px;
        }

        .sticky-bottom {
            position: sticky;
            bottom: 0;
            background-color: white;
        }

        .result-item {
            display: flex;
            justify-content: space-between;
        }

        .result-item .column {
            max-width: 33%;
            width: 32%;
            display: block;
            text-align: left;
            padding: 0px 10px;
        }

        #select2-company_id-results li:first-child {
            position: -webkit-sticky; /* For Safari and iOS Safari */
            position: sticky;
            top: 0; /* Stick to the top of the container */
            z-index: 1; /* Ensure the sticky element appears above other content */
            background-color: white;
            color: black;
        }

        #select2-company_id-results .column.column-heading {
            font-weight: bolder;
            font-size: 14px;

        }
        .hr_line{
            color: #0a1832!important;
        }
        .success {
            color: black;
            padding: 10px;
            font-size: 16px;
            background-color: #ffffcc;
            border-left: 8px solid #ffeb3b;
        }
        div#sq-co p .point{
            opacity:0;
        }

        div#sq-co p .point.one {
            -webkit-animation: fadeIn 1s linear 0s infinite alternate;
            animation: fadeIn 1s linear 0s infinite alternate;
        }
        div#sq-co p .point.two {
            -webkit-animation: fadeIn 1s linear 0.5s infinite alternate;
            animation: fadeIn 1s linear 0.5s infinite alternate;
        }
        div#sq-co p .point.three {
            -webkit-animation: fadeIn 1s linear 1s infinite alternate;
            animation: fadeIn 1s linear 1s infinite alternate;
        }
        div#sq-co p{
            color:black;
            font-size:24px;
            font-weight: bold;
            margin-bottom:10px;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
                border-radius:0;
            }
            100% {
                opacity: 1;
                border-radius:50px;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
                border-radius:0;
            }
            100% {
                opacity: 1;
                border-radius:50px;
            }
        }

        @keyframes rotateR {
            from {
                transform: rotate(0deg);

            }
            to {
                transform: rotate(360deg);

            }
        }

        @-webkit-keyframes rotateR {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        .lds-spinner {
            position: absolute !important;
            top: 50% !important;
            left: 50%  !important;;
            transform: translate(-50%, -50%)  !important;;
        }
        .pre_loader_main.overlay {
            position: absolute;
            top: 67px;
            left: 0;
            width: 100%;
            height: 90%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            pointer-events: all;
        }
    </style>
    <div class="page-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb-3">
                <x-pages.header title="Vehicle Booking - {{ $type }}">
                    @if($type == 'local')
                        <a type="submit" href="{{route('technician-view')}}" class="btn btn-dark mt-1 ms-2">Technician
                            View</a>
                    @endif
                    <x-booking-modal></x-booking-modal>
                </x-pages.header>

                <div class="float-right" role="group" aria-label="Basic example">
                    <form method="post" class="d-flex flex-row align-items-center"
                          action="{{ route('booking.calendar', $type) }}">
                        @csrf

                        <label for="date" class="m-1">Date:</label>
                        <input class="form-control" type="date" name="date" id="date" required value="{{ $date }}">

                        <button class="btn btn-success w-50 waves-effect waves-light" style="margin-left: 10px"
                                type="submit">
                            Search
                        </button>
                    </form>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-xl-2" style="width: 220px">
                    <div class="card h-100">
                        <div class="unallocated-column card-body">
                            <a class="btn btn-outline-primary mt-1 ms-2 new-unallocated-booking-button font-size-11"
                               id="new-booking-button" data-date="${date}">
                                Add New Booking
                            </a>
                            <div>
                                @foreach($unallocatedBookings as $unallocatedBooking)
                                    <br/>
                                    <div class="external-events jira-card draggable-card ui-draggable ui-draggable-handle"
                                         style="border: 3px solid {{ $unallocatedBooking['borderColor'] }}; border-radius: 5px; color: {{ $unallocatedBooking['textColor'] }}"
                                         id="{{ $unallocatedBooking['id'] }}"
										 data-calendar-type="{{ $unallocatedBooking['extendedProps']['calendarType'] }}">
                                        <div class="jira-card-id">
                                            <i class="fa fa-bookmark"></i> {{ $unallocatedBooking['id'] }}
                                            <div class="close-icon">✖</div>
                                        </div>

                                        @if ($unallocatedBooking['title'])
                                            <div class="jira-card-header">
                                                <div class="jira-card-title">
                                                    {!! $unallocatedBooking['title'] !!}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($unallocatedBooking['extendedProps']['carMakeModel'])
                                            <div class="jira-card-info">
                                                <div class="jira-card-info-item">
                                                    {!! $unallocatedBooking['extendedProps']['carMakeModel'] !!}
                                                </div>
                                            </div>
                                        @endif

                                        @if ($unallocatedBooking['description'])
                                            <div class="jira-card-description">
                                                {!! $unallocatedBooking['description'] !!}
                                            </div>
                                        @endif

                                        @if ($unallocatedBooking['extendedProps']['footer'])
                                            <div class="jira-card-footer">
                                                {!! $unallocatedBooking['extendedProps']['footer'] !!}
                                            </div>
                                        @endif

                                        @if ($unallocatedBooking['extendedProps']['calendarType'])
                                            <div class="jira-card-calendar-type"
                                                 style="color: {{ $unallocatedBooking['borderColor'] }}; padding-bottom: 10px">
												<span style="float: left">
													{!! strtoupper($unallocatedBooking['extendedProps']['calendarType']) !!}
                                            	</span>
												<span style="float: right">
													{!! strtoupper($unallocatedBooking['extendedProps']['addedDate']) !!}
                                            	</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-10">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div id="loader" class="position-absolute" style="top: 10%; left: 50%"></div>
                            <div id="bookings-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h3 style="margin-left: 10px">Map</h3>
                <div id="map" style="height: 500px;"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
		let calendar;
		const type = {!! json_encode($type) !!};
		const date = {!! json_encode($date) !!};
		let eventCounts = {};
		let coordinates = [];
		let coordinatesDrawInterval;
		let coordinatesCheckInterval;
		let unallocatedBookingClicked = false;
		let bookingModelIsOpen = false;
        let whatWindScreenApiCAllInterval;
        let  resultEuroCode = null;

		$('.external-events').each(function () {
			const event = {};
			event.id = this.id;
			event.calendarType = $(this).attr('data-calendar-type');

			$(this).draggable({
				zIndex: 999,
				revert: true,
				revertDuration: 0,
				helper: 'clone',
				appendTo: 'body',
				containment: 'window',
				start: function (e, ui) {
					$(this).data('event', event);
				},
			});
		});


		window.addEventListener('load', function () {
			eventCounts = {};
			coordinates = [];

			const calendarEl = document.getElementById('bookings-calendar');
			calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {center: 'dayGridMonth, dayGridWeek, dayGridDay'}, // buttons for switching between views
				header: {
					left: "prev,next today",
					center: "title",
					right: "dayGridMonth, dayGridWeek, dayGridDay, listMonth"
				},
				defaultView: "dayGridWeek",
				firstDay: 1,
				initialDate: date === '' ? Date.now() : date,
				editable: true,
				dayMaxEvents: true, // allow "more" link when too many events
				navLinks: true,
				nowIndicator: true,
				themeSystem: "bootstrap",
				plugins: ["bootstrap", "interaction", "dayGrid", "timeGrid"],
				views: {
					dayGridMonth: { // name of view
						titleFormat: {year: 'numeric', month: '2-digit', day: '2-digit'},
						eventLimit: 2 // adjust to 6 only for timeGridWeek/timeGridDay
					}
				},
				events: '/booking/' + type.toLowerCase().replace(' ', '-'),
				displayEventTime: false,
				columnHeaderHtml: function (date) {
					const today = new Date(); // Get the current date
					const dayName = date.toLocaleDateString('en-US', {weekday: 'long'});
					const dayNumber = date.getDate();
					const isCurrentDay = date.toDateString() === today.toDateString(); // Check if the date is the current day
					const highlightClass = isCurrentDay ? 'text-primary fw-bold' : '';
					const currentDate = formatCurrentDateOnly(date);
					const showEventCount = calendar.view.type !== 'dayGridMonth'; // Check if the view is not dayGridMonth

					return `
					<div class="fc-col-header-cell mt-2 mb-2 d-flex flex-column align-items-center">
						<span class="fc-col-header-cell-day ${highlightClass}">${dayName}</span>
						${showEventCount ? `<span class="fc-col-header-cell-date ${highlightClass}">${dayNumber}</span>
						<a class="btn btn-outline-primary mt-1 ms-2 new-booking-buttons font-size-11" id="new-booking-button" data-date="${date}">
							Add New Booking
						</a>
						<hr style="width: 100%; margin-bottom: 5px" ${highlightClass}"/>
						<span class="fc-col-header-cell-date ${highlightClass}">Total Jobs: <span class="event-count event-count-${currentDate}">0</span></span>` : ''}
					</div>
				  `;
				},
				loading: function (isLoading, view) {
					if (isLoading) {
						$('#loader').html('<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
					} else {
						$('#loader').empty();
					}
				},
				eventRender: function (info, element) {
					const event = info.event;

					if (calendar.view.type === 'dayGridMonth') {
						const cardElement = document.createElement('div');
						cardElement.classList.add('jira-card');

						if (event.extendedProps.isHoliday) {
							const holidayElement = document.createElement('div');
							holidayElement.classList.add('jira-card-id');
							holidayElement.innerHTML = event.title;
							cardElement.appendChild(holidayElement);
							info.el.innerHTML = '';
							info.el.appendChild(cardElement);

							return;
						} else {
							const eventDate = formatDateOnly(event.start);
							if (eventCounts[eventDate]) {
								eventCounts[eventDate]++;
								$('.event-count-' + eventDate).html(eventCounts[eventDate]);
							} else {
								eventCounts[eventDate] = 1;
								$('.event-count-' + eventDate).html(eventCounts[eventDate]);
							}
						}

						const idElement = document.createElement('div');
						idElement.classList.add('jira-card-id');
						idElement.innerHTML = "<i class='fa fa-bookmark'></i> " + event.id;
						cardElement.appendChild(idElement);

						const removeBookingButton = document.createElement('div');
						removeBookingButton.classList.add('close-icon');
						removeBookingButton.innerHTML = '&#10006;';
						removeBookingButton.addEventListener('click', function (e) {
							e.stopPropagation();
							e.preventDefault();

							deleteJobCard(event.id, false);
						});
						idElement.appendChild(removeBookingButton);

						const headerElement = document.createElement('div');
						headerElement.classList.add('jira-card-header');

						const titleElement = document.createElement('div');
						titleElement.classList.add('jira-card-title');
						titleElement.innerHTML = event.title;
						headerElement.appendChild(titleElement);

						cardElement.appendChild(headerElement);

						if (event.extendedProps.carMakeModel !== "") {
							const infoElement = document.createElement('div');
							infoElement.classList.add('jira-card-info');
							infoElement.innerHTML =
								'<div class="jira-card-info-item"><i class="fa fa-car"></i> ' + event.extendedProps.carMakeModel + '</div>';
							cardElement.appendChild(infoElement);
						}

						const descriptionElement = document.createElement('div');
						descriptionElement.classList.add('jira-card-description');
						descriptionElement.innerHTML = event.extendedProps.description;
						cardElement.appendChild(descriptionElement);

						if (event.extendedProps.footer !== "") {
							const footerElement = document.createElement('div');
							footerElement.classList.add('jira-card-footer');
							footerElement.innerHTML = event.extendedProps.footer;
							cardElement.appendChild(footerElement);
						}

						info.el.innerHTML = '';
						info.el.appendChild(cardElement);
					} else {
						// Create a container element for the card
						const containerElement = document.createElement('div');
						containerElement.classList.add('jira-card-container');
						containerElement.style.color = event.textColor;

						const cardElement = document.createElement('div');
						cardElement.classList.add('jira-card');
						cardElement.classList.add('draggable-card');
						cardElement.style.border = `4px solid ${event.borderColor}`;

						if (type === "zenith") {
							cardElement.style.backgroundColor = `${event.borderColor}`;
							cardElement.style.color = `#ffffff`;
						} else if (type === "national") {
							cardElement.style.color = `${event.borderColor}`;
							cardElement.style.border = `2px solid ${event.borderColor}`;
						}

						cardElement.style.borderRadius = "5px";

						if (event.extendedProps.isHoliday) {
							const holidayElement = document.createElement('div');
							holidayElement.classList.add('jira-card-id');
							holidayElement.innerHTML = event.title;

							if (type === "zenith") {
								holidayElement.style.backgroundColor = `${event.borderColor}`;
								holidayElement.style.color = `#ffffff`;
							}

							cardElement.appendChild(holidayElement);
							info.el.innerHTML = '';

							containerElement.appendChild(cardElement);

							const dateCell = document.querySelector('.fc-day-grid-container .fc-day[data-date="' + event.start.toISOString().slice(0, 10) + '"]');

							if (dateCell) {
								// Append the new <td> element to the date cell
								dateCell.appendChild(containerElement);
							}

							return;
						} else {
							const eventDate = formatDateOnly(event.start); // Extract the date from the start property
							if (eventCounts[eventDate]) {
								eventCounts[eventDate]++;
								$('.event-count-' + eventDate).html(eventCounts[eventDate]);
							} else {
								eventCounts[eventDate] = 1;
								$('.event-count-' + eventDate).html(eventCounts[eventDate]);
							}
						}

						const idElement = document.createElement('div');
						idElement.classList.add('jira-card-id');
						idElement.innerHTML = "<i class='fa fa-bookmark'></i> " + event.id;

						if (type === "zenith") {
							idElement.style.backgroundColor = `${event.borderColor}`;
						}

						cardElement.appendChild(idElement);

						const removeBookingButton = document.createElement('div');
						removeBookingButton.classList.add('close-icon');
						removeBookingButton.innerHTML = '&#10006;';
						removeBookingButton.addEventListener('click', function (e) {
							e.stopPropagation();
							e.preventDefault();

							deleteJobCard(event.id, false);
						});
						idElement.appendChild(removeBookingButton);

						const headerElement = document.createElement('div');
						headerElement.classList.add('jira-card-header');

						const titleElement = document.createElement('div');
						titleElement.classList.add('jira-card-title');
						titleElement.innerHTML = event.title;
						headerElement.appendChild(titleElement);

						cardElement.appendChild(headerElement);

						if (event.extendedProps.carMakeModel !== "") {
							const infoElement = document.createElement('div');
							infoElement.classList.add('jira-card-info');
							infoElement.innerHTML =
								'<div class="jira-card-info-item"><i class="fa fa-car"></i> ' + event.extendedProps.carMakeModel + '</div>';

							if (type === "zenith") {
								infoElement.style.backgroundColor = `${event.borderColor}`;
							}

							cardElement.appendChild(infoElement);
						}

						const descriptionElement = document.createElement('div');
						descriptionElement.classList.add('jira-card-description');
						descriptionElement.innerHTML = event.extendedProps.description;
						cardElement.appendChild(descriptionElement);

						if (event.extendedProps.footer !== "") {
							const footerElement = document.createElement('div');
							footerElement.classList.add('jira-card-footer');
							footerElement.innerHTML = event.extendedProps.footer;

							if (type === "zenith") {
								footerElement.style.backgroundColor = `${event.borderColor}`;
							}

							cardElement.appendChild(footerElement);
						}

						info.el.innerHTML = '';
						info.el.remove();

						$(cardElement).draggable({
							zIndex: 999,
							revert: true,
							revertDuration: 0,
							helper: 'clone',
							appendTo: 'body',
							containment: 'window',
							start: function (e, ui) {
								$(this).data('event', event);
							},
						});

						cardElement.addEventListener('click', function () {
							if (!event.extendedProps.isHoliday) {
								ajaxForLoadBookingModal(event);
							}
						});

						containerElement.appendChild(cardElement);

						const dateCell = document.querySelector('.fc-day-grid-container .fc-day[data-date="' + event.start.toISOString().slice(0, 10) + '"]');

						if (dateCell) {
							dateCell.appendChild(containerElement);
						}
					}

					if (event.extendedProps.customer !== "") {
						coordinates.push(event.extendedProps.coordinate)
					}
				},
				viewSkeletonRender: function (info) {
					updateAddBookingButtons(info.view);
				},
				view: function (info) {
					updateAddBookingButtons(info.view);
				},
				eventAfterAllRender: function (view) {
				},
				drop: function (info) {
					changeBookingDate(info.event.id, formatDateOnly(info.event.start))
				},
			});

			calendar.render();

			const originalRefetchEvents = calendar.refetchEvents;
			calendar.refetchEvents = function () {
				originalRefetchEvents.apply(this, arguments);
				$('.jira-card-container').remove();
				eventCounts = {};
				coordinates = [];
			};

			$('.fc-week .fc-day').droppable({
				accept: '.draggable-card',
				tolerance: 'pointer',
				drop: function (event, ui) {
					const droppedCard = ui.draggable;
					const droppedEvent = droppedCard.data().event;
					const newStartDate = new Date($(this).attr('data-date') + " 09:00:00");

					if (droppedEvent.calendarType != undefined && droppedEvent.calendarType !== type) {
						var currentCalendar = droppedEvent.calendarType;
						var confirmationMessage =
							"Current Job is assigned to " +
							currentCalendar +
							" calendar -\n" +
							"Are you sure you wish to move it to " +
							type +
							" calendar?";

						if (confirm(confirmationMessage)) {
							changeBookingDate(type, droppedEvent.id, formatDateOnly(newStartDate));
							droppedCard.remove();
							calendar.refetchEvents();
						}
					} else {
						changeBookingDate(type, droppedEvent.id, formatDateOnly(newStartDate));
						droppedCard.remove();
						calendar.refetchEvents();
					}
				}
			});

			$('.unallocated-column').droppable({
				accept: '.draggable-card',
				tolerance: 'pointer',
				drop: function (event, ui) {
					const droppedCard = ui.draggable;
					const droppedEvent = droppedCard.data().event;

					changeBookingDate(type, droppedEvent.id, null);
					location.reload();
					droppedCard.remove();
					calendar.refetchEvents();
				}
			});

			$(document).on('click', '.fc-prev-button', function () {
				updateAddBookingButtons(calendar.view);
			});

			$(document).on('click', '.fc-next-button', function () {
				updateAddBookingButtons(calendar.view);
			});

			$(document).on('click', '.fc-today-button', function () {
				updateAddBookingButtons(calendar.view);
			});

			// Function to handle the "New Booking" button click
			function handleAddNewBookingButtonClick(event) {
				event.stopPropagation(); // Stop the event from propagating to the calendar
				event.preventDefault(); // Prevent the default behavior of the button click event
                preLoader('off');
                removeWhatWindScreenLookupTable();
                $('.argic_no_message').addClass('d-none');
                $('.argic_no_container_main ').addClass('d-none');
				$(".booking-form")[0].reset();

				const selectedDate = $(this).data('date');
                $('.argic_no_container_main').addClass('d-none');
				$('#booking-modal').modal('show');
				$('#vehicle_history_id').val("");
				$("#make_id").val((""));
				$("#vehicle_vrn_number").val("");
				$("#vehicle_vin_number_id").val("");
				$("#vehicle_make").val("");
				$("#vehicle_model").val("");
				$("#vehicle_year_manufacture").val("");
				$('#argic_no').val("");
				$('#windscreen_lookup_id').val("");
				$('#status').val(1);
				$('#datetime').val(formatDateToYmdNew(selectedDate));
				$('#time_allocated').val("09:00");
				$('.added-updated-info').hide();
				$('#job-card-id').text("");
				$('#customer_id').val([]).trigger('change');
				$('#same_as_company').prop('checked', false);
			}

			function updateAddBookingButtons(view) {
				const addBookingButtons = document.querySelectorAll('.new-booking-buttons');

				if (view.type !== 'dayGridMonth') {
					addBookingButtons.forEach(function (button) {
						button.style.display = 'block';
						button.addEventListener('click', handleAddNewBookingButtonClick);
					});

					eventCounts = {};
					coordinates = [];

					$('.fc-row .fc-content-skeleton').css('z-index', '0');
					$('.fc-row .fc-bg').css('z-index', '1');
				} else {
					addBookingButtons.forEach(function (button) {
						button.style.display = 'none';
						button.removeEventListener('click', handleAddNewBookingButtonClick);
					});

					$('.fc-row .fc-content-skeleton').css('z-index', '1');
					$('.fc-row .fc-bg').css('z-index', '0');
				}

				coordinatesDrawInterval = setInterval(drawCoordinates, 1000);
			}

			function loadMakeModel(make_id, selectedValue) {
				$.ajax({
					type: 'GET',
					url: `/vehicle/get-car-model/` + make_id,
					success: function (data) {
						const selectElement = $('#vehicle_model_id');
						selectElement.empty();

						data.map(carModel => {
							selectElement.append(new Option(carModel.name, carModel.id));
						});

						selectElement.val(selectedValue.toString());
					},
					error: function (error) {
						console.log(error);
					}
				});
			}

			$('#postcode_lookup').getAddress({
				api_key: 'mvhiKI9IJ0-qdfZ0orhoIw32032',
				output_fields: {
					line_1: '#address_1',
					line_2: '#address_2',
					post_town: '#city',
					postcode: '#postcode'
				},
				input_label: 'Please enter a postcode',
				input_class: 'form-control w-50 me-2',
				button_label: 'Postcode Lookup',
				button_class: 'btn btn-outline-primary postcode_lookup'
			});

			function deepClone(obj, hash = new WeakMap()) {
				if (Object(obj) !== obj || obj instanceof Function) {
					return obj;
				}

				if (hash.has(obj)) {
					return hash.get(obj);
				}

				const clone = Array.isArray(obj) ? [] : {};

				hash.set(obj, clone);

				for (let key in obj) {
					if (Object.prototype.hasOwnProperty.call(obj, key)) {
						clone[key] = deepClone(obj[key], hash);
					}
				}

				return clone;
			}
		});

		function changeBookingDate(type, vehicleHistoryId, date) {
			$.ajax({
				type: "GET",
				url: "/booking/change-date/" + type + "/" + vehicleHistoryId + "/" + date,
				success: function () {
					calendar.refetchEvents();
				}
			});
		}

		function deleteJobCard(vehicleHistoryId, isModal) {
			if (window.confirm('Are you sure you want to remove this booking?')) {
				$.ajax({
					type: "GET",
					url: "/booking/remove/" + vehicleHistoryId,
					success: function () {
						if (isModal) {
							$("#job-card-popup").dialog("close");
						}

						calendar.refetchEvents();
					}
				});
			}
		}

		$('.external-events').on('click', function () {
			unallocatedBookingClicked = true;
			ajaxForLoadBookingModal(this);
		});

		// Function to handle the "New Booking" button click
		function handleUnallocatedAddNewBookingButtonClick(event) {
			unallocatedBookingClicked = true;
			event.stopPropagation(); // Stop the event from propagating to the calendar
			event.preventDefault(); // Prevent the default behavior of the button click event
            $('.argic_no_message').addClass('d-none');
            $('.argic_no_container_main').addClass('d-none');
            removeWhatWindScreenLookupTable()
			$(".booking-form")[0].reset();

			const selectedDate = $(this).data('date');
			$('#booking-modal').modal('show');
			$('#vehicle_history_id').val("");
			$("#make_id").val((""));
			$("#vehicle_vrn_number").val("");
			$("#vehicle_vin_number_id").val("");
			$("#vehicle_make").val("");
			$("#vehicle_model").val("");
			$("#vehicle_year_manufacture").val("");
			$('#argic_no').val("");
			$('#windscreen_lookup_id').val("");
			$('#status').val(1);
			$('#datetime').val(formatDateToYmdNew(selectedDate));
			$('#time_allocated').val("09:00");
			$('.added-updated-info').hide();
			$('#job-card-id').text("");
			$('#customer_id').val([]).trigger('change');
			$('#same_as_company').prop('checked', false);
		}

		$('.new-unallocated-booking-button').on('click', handleUnallocatedAddNewBookingButtonClick);

		function ajaxForLoadBookingModal(event) {
            $('.argic_no_message').addClass('d-none');
            $('.argic_no_container_main').addClass('d-none');
            removeWhatWindScreenLookupTable();
            resetWWLookupForm();
            preLoader('on');
			$.ajax({
				url: '/booking/find/' + event.id,
				method: 'get',
				success: function (response) {
				    console.log(response)
					if (response.vehicle.make_id !== null && response.vehicle.make_id !== 0) {
						loadMakeModel(response.vehicle.make_id, response.vehicle.model_id);
					}

                    $('#vehicle_registration_number').val(response.vehicle_reg);
                    $('#vehicle_vin_number_id').val(response.vin_number);
                    $('#vehicle_make').val(response.vehicle_make);
                    $('#vehicle_year_manufacture').val(response.vehicle_year_manufacture);
                    $('#vehicle_model').val(response.vehicle_model);
                    if(response.glass_position){
                        $('#glass_position_id').val(response.glass_position);
                    }
                    
                    if(response.windscreen_lookup_id){
                        getWhatWindscreenLookupById(response.windscreen_lookup_id);
                    }

					$('#job-card-id').text("#" + response.id);
					$('#vehicle_history_id').val(response.id);

					// $("#vehicle_registration_number").val("");


					/*var selectedOption = $('<option></option>').attr('value', response.customer_id).text(response.customer.first_name + ' ' + response.customer.surname);
                    $('#customer_id').empty();
                    $('#customer_id').append(selectedOption)*/

					if (response.signature !== '' && response.signature !== null) {
						let signatureImage = response.signature;
						let source = "{!! asset('upload/signatures/') !!}";
						$('#canvas_image_show').attr('src', source + '/' + signatureImage);
					}

					$.each(response, function (id, value) {
						$('.added-updated-info').show();
						$('#' + id).val(value);

						if (response.datetime != null) {
							$('#datetime').val(formatDateToYmd(response.datetime));
						}

						if (response.vehicle.length !== 0) {
							$.each(response.vehicle, function (objId, objValue) {
								$('#vehicle_' + objId).val(objValue);
							});
						}

						if (response.company !== null) {
							$.each(response.company, function (objId, objValue) {
								$('#company_' + objId).val(objValue).change();
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
                    if(response.windscreen_lookup_id == null || response.windscreen_lookup_id == ''){
                        preLoader('off');
                    }
                    bookingModelIsOpen = true;
                    whatWindScreenApiCAllInterval = setInterval(function (){
                        checkBookingModel(response.windscreen_lookup_id, resultEuroCode);
                    }, 5000);
				}
			});

			$('#booking-modal').modal('show');
		}
        $('#booking-modal').on('hidden.bs.modal', function (e) {
            bookingModelIsOpen = false;
        })
        function checkBookingModel(lookupId, euroCode) {
            if (bookingModelIsOpen && euroCode === null) {
                getWhatWindscreenLookupById(lookupId);
            } else {
                clearInterval(whatWindScreenApiCAllInterval);
            }
        }
        function getWhatWindscreenLookupById(lookupId)
        {
            $.ajax({
                url: '{{ route('get.windscreen.lookup') }}',
                data:{lookupId:lookupId},
                success:function (res){

                    if(res.status == 200){

                        $('#vehicle_registration_number').val(res.data.vehicleReg);
                        $('#vehicle_vin_number_id').val(res.data.vehicleVIN);
                        $('#vehicle_make').val(res.data.vehicleMake);
                        $('#vehicle_model').val(res.data.vehicleModel);
                        $('#vehicle_year_manufacture').val(res.data.vehicleYear);
                        $('#glass_position_id').val(res.data.glassItem).change();
                        if(res.data.statusDesc == 'Validated'){
                            $('#argic_no').val(res.data.resultEuroCode);
                            $('#part_code').val(res.data.resultEuroCode);
                            resultEuroCode = res.data.resultEuroCode
                            $('.argic_no_container_main').removeClass('d-none');
                            $('.argic_no_message').addClass('d-none');
                        }else{
                            $('.argic_no_container_main').addClass('d-none');
                            $('#argic_no_message_status').html(res.data.statusDesc)
                            $('.argic_no_message').removeClass('d-none');
                        }
                        getWhatWindScreenLookupTable(res.data);
                    }
                    preLoader('off');
                }
            })
        }
        function resetWWLookupForm()
        {
            const data = {
                vehicle_registration_number: '',
                vrn_number: '',
                vin_number: '',
                vehicle_make: '',
                vehicle_model: '',
                vehicle_year_manufacture: '',
                glass_position: '',
                argic_no: '',
            };
            resetWWLookupFormByName(data);
            removeFromErrorsByObjectByClass(data);
        }
    </script>

    <script>
		let map;
		let markersLayer;

		$(document).ready(function () {
			map = L.map('map', {
				center: [54.6114622, -2.7621163],
				zoom: 8
			});

			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				maxZoom: 19,
				attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
			}).addTo(map);

			markersLayer = L.layerGroup().addTo(map);
		});

		let markers = [];
		let intervalClearFlag = true;
		coordinatesCheckInterval = setInterval(checkCoordinates, 1000);

		function checkCoordinates() {
			if (coordinates.length > 0) {
				clearInterval(coordinatesCheckInterval);
				openMap(coordinates, false, false);
			}
		}

		function drawCoordinates() {
			if (coordinates.length > 0) {
				clearInterval(coordinatesDrawInterval);
				openMap(coordinates, false, false);
			}
		}

		function openMap(key = false, isIndividual = true, isTech = true) {
			if (coordinates) {
				markersLayer.clearLayers();
				let results;

				if (isIndividual) {
					results = coordinates.filter(coordinate => {
						if (isTech) {
							return coordinate.tech_id === key;
						} else {
							return coordinate.datetime === key;
						}
					});

					$('#new_map').html("<div id='map'></div>");
				} else {
					results = coordinates;
				}

				const orangeIcon = L.icon({
					iconUrl: '/assets/images/pin-m-fb8128.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				const redIcon = L.icon({
					iconUrl: '/assets/images/pin-ff0000.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				const greenIcon = L.icon({
					iconUrl: '/assets/images/pin-m-37D837.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				const yellowIcon = L.icon({
					iconUrl: '/assets/images/pin-m-28abfb1.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				const blueIcon = L.icon({
					iconUrl: '/assets/images/pin-m-28abfb.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				const blackIcon = L.icon({
					iconUrl: '/assets/images/pin-m-000000.png',
					iconSize: [30, 70],
					iconAnchor: [15, 35],
					popupAnchor: [0, -35]
				});

				results.forEach(result => {
					if (result['lat'] !== null && result['lng'] !== null) {
						let html = '';

						if (result['datetime']) {
							html += result['datetime'] + "<br/>";
						}
						if (result['companyName']) {
							html += result['companyName'] + "<br/>";
						}
						if (result['customerFirstName']) {
							html += result['customerFirstName'] + " ";
						}
						if (result['customerSurname']) {
							html += result['customerSurname'] + "<br/>";
						}
						if (result['postcode']) {
							html += result['postcode'] + "<br/>";
						}
						if (result['regNo']) {
							html += result['regNo'] + "<br/>";
						}
						if (result['subContractor']) {
							html += result['subContractor'] + "<br/>";
						}
						if (result['calendarType'] === 'local') {
							if (result['technicianFirstName']) {
								html += result['technicianFirstName'] + " ";
							}
							if (result['technicianSurname']) {
								html += result['technicianSurname'];
							}
						}

						let mapIcon;

						if (result['status'] === 3) {
							mapIcon = greenIcon;
						} else if (result['status'] === 7) {
							mapIcon = yellowIcon;
						} else if (result['status'] === 6) {
							mapIcon = blueIcon;
						} else if (result['status'] === 8) {
							mapIcon = blackIcon;
						} else if (result['status'] === 1) {
							mapIcon = redIcon;
						} else {
							mapIcon = orangeIcon;
						}

						const marker = L.marker([result['lng'], result['lat']], {icon: mapIcon})
							.bindPopup(html)
							.addTo(markersLayer);

						markers.push(marker);
					}
				});
			}
		}

		/*function removeMarkers() {
			markers.forEach(function(marker) {
				marker.remove(); // Remove marker from the map
			});

			markers = [];
		}*/
    </script>
@endsection
