<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>Glass Assist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Glass Assist" name="description"/>
    <meta content="3 Amigos" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <!-- Insert the blade containing the TinyMCE configuration and source script -->
    <x-head.tinymce-config></x-head.tinymce-config>
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
    <link href="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/@fullcalendar/core/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/@fullcalendar/daygrid/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/@fullcalendar/bootstrap/main.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/libs/@fullcalendar/timegrid/main.min.css') }}" type="text/css">
    <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css"/>
    {{--<link href="{{asset('assets/css/style.css')}}" id="app-style" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" type="text/css"/>
    <link href="{{asset('css/app.css')}}" id="app-style" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
          type="text/css">
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />--}}
    <link href="{{ asset('/assets/css/leaflet.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('assets/libs/jquery/jquery.min.js')}}" async></script>
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-selection--single {
            display: block;
            border-radius: 0.25rem;
            padding-top: 5px;
            font-size: .9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #505d69;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__clear{
            background: transparent !important;
            border: none;
            right: 18px;
        }
        #booking-modal .adjust-width{
            display: grid;
        }
    </style>
</head>

<body data-topbar="dark"  class="vertical-collpsed">
<div id="layout-wrapper">
    @include('layout.header')
    @include('layout.sidebar')
    <div class="main-content">
        @yield('content')
        @include('layout.footer')
    </div>
</div>
<script src="{{asset('assets/js/global.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
{{--<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>--}}
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/leaflet.js')}}"></script>

<!-- Required datatable js -->
<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<!-- Buttons examples -->
<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

<script src="{{asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
{{--<script src="{{asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}" defer></script>
<script src="{{asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}" defer></script>
<script src="{{asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}" defer></script>
<script src="{{asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}" defer></script>--}}

<!-- Buttons examples -->
{{--<script src="{{asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/libs/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/libs/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')}}"></script>

<script src="{{asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('assets/libs/datatables.net-select/js/dataTables.select.min.js')}}"></script>--}}
{{--<script src="{{asset('assets/js/pages/dashboard.init.js')}}"></script>--}}
<script src="{{asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{ asset('assets/libs/moment/min/moment.min.js') }}"></script>

<script src="{{ asset('assets/libs/jquery-ui-dist/jquery-ui.min.js') }}"></script>

<script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="https://cdn.tiny.cloud/1/dt81amx0dx540eoh6lbvqzj3ql12yyhxyrmoylriusset3x6/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
<script src="https://cdn.getaddress.io/scripts/jquery.getAddress-4.0.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.4/signature_pad.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/numeric/1.2.6/numeric.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	tinymce.init({
		selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
		plugins: 'table lists',
		toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | code | table'
	});
</script>

<!-- plugin js -->
<script src="/assets/libs/moment/min/moment.min.js"></script>
<script src="/assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
<script src="/assets/libs/@fullcalendar/core/main.min.js"></script>
<script src="/assets/libs/@fullcalendar/bootstrap/main.min.js"></script>
<script src="/assets/libs/@fullcalendar/daygrid/main.min.js"></script>
<script src="/assets/libs/@fullcalendar/timegrid/main.min.js"></script>
<script src="/assets/libs/@fullcalendar/interaction/main.min.js"></script>

<script>


	function formatAMPM(date) {
		let hours = date.getHours();
		let minutes = date.getMinutes();
		const ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0' + minutes : minutes;
		return hours + ':' + minutes + ' ' + ampm;
	}

	function formatDate(d) {
		const date = new Date(d);
		let year = date.getFullYear();
		let months = date.getMonth();
		let days = date.getDate();
		let hours = date.getHours();
		let minutes = date.getMinutes();
		const ampm = hours >= 12 ? 'pm' : 'am';
		hours = hours % 12;
		hours = hours ? hours : 12; // the hour '0' should be '12'
		minutes = minutes < 10 ? '0' + minutes : minutes;
		return days + '/' + months + '/' + year + ' ' + hours + ':' + minutes + ' ' + ampm;
	}

	function formatDateOnly(d) {
		const date = new Date(d);
		const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
		return date.toLocaleDateString('en-GB', options).replace(/\//g, '-');
	}

	function formatDateToYmdNew(d) {
		const date = new Date(d);
		const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
		const formattedDate = date.toLocaleDateString('en-GB', options);
		return formattedDate.split('/').reverse().join('-');
	}

	function formatDateToYmd(d) {
		const date = new Date(d);
		const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
		const formattedDate = date.toLocaleDateString('en-GB', options);
		return formattedDate.split('/').reverse().join('-');
	}

	function formatCurrentDateOnly(d) {
		const date = new Date(d);
		const options = {timeZone: 'Europe/London', year: 'numeric', month: '2-digit', day: '2-digit'};
		return date.toLocaleDateString('en-GB', options).replace(/\//g, '-');
	}

	function formatTimeOnly(date) {
		const hours = String(date.getHours()).padStart(2, '0');
		const minutes = String(date.getMinutes()).padStart(2, '0');
		const ampm = hours >= 12 ? 'pm' : 'am';
		return `${hours}:${minutes}:${ampm}`;
	}

	function capitalizeFirstLetter(text) {
		if (text !== null) {
			return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
		}
	}
</script>
@stack('selectScripts')
@yield('scripts')
@yield('scripts2')
@yield('scripts3')
@yield('scripts4')
@yield('scripts5')
@yield('scripts6')
@yield('scripts7')
@include('flash_messages')
</body>
</html>
