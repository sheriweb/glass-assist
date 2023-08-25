@if(Auth::check())
    <div class="vertical-menu">
        <div data-simplebar class="h-100">
            <div id="sidebar-menu" class="vertical-collpsed">
                <ul class="metismenu list-unstyled" id="side-menu">
                    @if(Auth::user()->access_level !== 5)
                        <li>
                            <a href="{{ route('dashboard') }}" class="waves-effect">
                                <i class="ri-dashboard-line"></i><span
                                        class="badge rounded-pill bg-success float-end"></span>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Bookings</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('booking.calendar', 'local') }}">Local</a></li>
                                <li><a href="{{ route('booking.calendar', 'national') }}">National</a></li>
                                <li><a href="{{ route('booking.calendar', 'zenith') }}">Zenith</a></li>
                                <li><a href="{{ route('booking.calendar', 'acc-insurance') }}">ACC Insurance</a></li>
                                <li><a href="{{ route('booking.calendar', 'academy') }}">Academy</a></li>
                                <li><a href="{{ route('booking.calendar', 'quote') }}">Quote</a></li>
                                <li><a href="{{ route('booking.calendar', 'warranty-local') }}">Warranty Local</a></li>
                                <li><a href="{{ route('booking.calendar', 'warranty-national') }}">Warranty National</a>
                                </li>
                                <li><a href="{{ route('booking.all-bookings') }}">All Bookings</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-users"></i>
                                <span>Customers</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('customer') }}">Customers</a></li>
                                <li><a href="{{ route('customer.companies') }}">Companies</a></li>
                                <li><a href="{{ route('customer.glass-suppliers') }}">Glass Supliers</a></li>
                                <li><a href="{{ route('customer.sub-contractors') }}">Sub Contractors</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('vehicle') }}" class="waves-effect">
                                <i class="fas fa-car"></i>
                                <span>Vehicles</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-car-side"></i>
                                <span>GA Vehicles</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('vehicle-management') }}">Vehicles Management</a></li>
                                <li><a href="{{ route('vehicle-maintenance') }}">MOT / Service</a></li>
                                <li><a href="{{ route('vehicle-event') }}">Event Management</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-newspaper"></i>
                                <span>GA Assets</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="{{ route('ga-asset.asset-categories') }}"
                                           class="has-arrow waves-effect {{ request()->is('asset-categories') ? 'active' : '' }}">Assets
                                            Categories</a>
                                        <ul class="sub-menu" id="assetCategories" aria-expanded="true">
                                        </ul>
                                    </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('group-email') }}"
                               class="waves-effect {{ request()->is('/group-email') ? 'active' : '' }}">
                                <i class="fas fa-mail-bulk"></i>
                                <span>Groups Email</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('send-log') }}"
                               class=" waves-effect {{ request()->is('send-log') ? 'active' : '' }}">
                                <i class="fa fa-pen"></i>
                                <span>Send Log</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="fas fa-trash"></i>
                                <span>Archive</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li><a href="{{ route('archive.customers') }}">Customers</a></li>
                                <li><a href="{{ route('archive.assets') }}">Assets</a></li>
                                <li><a href="{{ route('archive.categories') }}">Assets Categories</a></li>
                                <li><a href="{{ route('archive.vehicles') }}">Vehicles</a></li>
                                <li><a href="{{ route('archive.groups') }}">Groups</a></li>
                                <li><a href="{{ route('archive.vehicle-maintenance-events') }}">Vehicle Maintenance
                                        Events</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('admin') }}" class=" waves-effect">
                                <i class="ri-admin-fill"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
<script>
	window.addEventListener("load", (event) => {
		$.ajax({
			url: '/asset-categories',
			contentType: 'application/json',
			type: 'GET',
            data:{sidebar:true},
			success: function (result, status) {
				if (status === 'success') {
					result?.map(category => {
						const li = document.createElement('li');
						const a = document.createElement('a');

						a.href = `/asset/category/${category.id}/index`;
						a.innerText = category.name;

						li.appendChild(a);

						$('#assetCategories').append(li);
					});
				}
			},
			error: function (xhr, status, error) {
				console.log(error);
			}
		});
	});
</script>
