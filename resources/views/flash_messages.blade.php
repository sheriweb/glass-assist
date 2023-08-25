<script>
    @if(Session::has('message'))
	const type = "{{ Session::get('alert-type', 'info') }}"
	switch (type) {
		case 'info':
			toastr.info(" {{ Session::get('message') }} ");
			break;
		case 'success':
			toastr.success(" {{ Session::get('message') }} ");
			break;
		case 'warning':
			toastr.warning(" {{ Session::get('message') }} ");
			break;
		case 'error':
			toastr.error(" {{ Session::get('message') }} ");
			break;
	}
    @endif

    function showMessage(response) {
	    if (response["alert-type"] === "success") {
		    toastr.success(response.message);
	    } else if (response["alert-type"] === "error") {
		    toastr.error(response.message);
	    } else if (response["alert-type"] === "warning") {
		    toastr.warning(response.message);
	    } else {
		    toastr.info(response.message);
	    }
    }
</script>

