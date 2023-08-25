{{--
<div class="{{ isset($simple) ? '' : 'col-lg-6' }}">
    <label>Model <b class="text-danger">*</b></label>
    <select class="form-select" name="model_id" required id="modelId"
            aria-label="Company Name Select">
        <option selected>---</option>
    </select>
</div>
--}}


@section('scripts3')
    <script>
	    $(document).ready(function ($) {
            $('#vehicle_make_id').change(function (e) {
	            loadMakeModel(e.target.value);
            });
        });

	    function loadMakeModel(make_id)
        {
	        $.ajax({
		        type: 'GET',
		        url: `/vehicle/get-car-model/` + make_id,
		        success: function (data) {
			        $('#vehicle_model_id').empty();

			        data.map(carModel => {
				        $('#vehicle_model_id').append(new Option(carModel.name, carModel.id));
			        });
		        },
		        error: function (error) {
			        console.log(error);
		        }
	        });
        }
    </script>
@endsection
