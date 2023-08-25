<div class="row align-items-center">
    <div class="col-md-5">
        <div class="">
            <label for="reg_no">Vehicle Reg</label>
            <input class="form-control" type="text" name="vehicle_registration_number" id="vehicle_registration_number">
            <span class="error_vehicle_registration_number error_reg_no text-danger"></span>
        </div>
        <div id="duplicateError" class="alert-danger mt-2"></div>
    </div>
    <div class="col-md-7 mt-4">
        <button type="button" id="what_windScreen_lookup" class="btn btn-outline-primary my-0 w-20">
              <span class="indicator-label">
                 WhatWindscreen  Lookup
               </span>
            <span id="indicatorProgress" class="indicator-progress d-none">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
             </span>
        </button>
        <button type="button" id="dvlaLookup" class="btn btn-outline-primary my-0 w-20">
              <span class="indicator-label">
                 DVLA Lookup
               </span>
            <span id="indicatorProgress" class="indicator-progress d-none">
                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
             </span>
        </button>
    </div>
</div>

@section('scripts2')
    <script>
		$(document).ready(function ($) {
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

			$('#dvlaLookup').click(function (e) {
				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
					}
				});

				e.preventDefault();

				const data = {
					reg_no: jQuery('#vehicle_registration_number').val()
				};
				var btn = $(this);
				$('.error_reg_no').html('');
				dataIndicator(btn, 'on');
				$.ajax({
					type: 'POST',
					url: '/vehicle/dvla-lookup',
					data: data,
					dataType: 'json',
					success: function (response) {
						dataIndicator(btn, 'off');
						if (response.error === 0) {
							alert(response.message);
						} else if (response.error === 1) {
							if (response.message === 'API key or VRM invalid') {
								alert('Please enter a valid Vehicle Reg');
							} else {
								alert(response.message);
							}
						} else {
							const jsonObj = JSON.parse(response.original.data);
							$("#make_id").val(jsonObj.make_id);
							$("#vehicle_vin_number_id").val(jsonObj.vin);
							$("#vehicle_make").val(jsonObj.make);
							$("#vehicle_model").val(jsonObj.model);
							$("#vehicle_year_manufacture").val(jsonObj.yearOfManufacture);
							$(".argic_no_container_main").addClass('d-none');
							/*$("#vehicle_body_style").val(jsonObj.vehicle_body_style);
							$("#vehicle_registered_date").val(jsonObj.dateOfFirstRegistration);*/
						}
						// if (data.length > 0) {
						// 	jQuery('#duplicateError')
						// 		.addClass('p-2')
						// 		.html('Duplicate Vehicle Detected');
						// }
					},
					error: function (request) {
						dataIndicator(btn, 'off');
						let responseText = jQuery.parseJSON(request.responseText);
						showErrorsByClass(responseText.errors);
					}
				});
			});


		});
    </script>
@endsection
