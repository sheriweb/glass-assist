@php

    use App\Helpers\BasicHelpers;

    $holidaysHead = ['Staff', 'Type', 'Date From', 'Date To', 'Days', 'Details', 'Edit'];

    $staffHead = ['', 'Entitlement', 'Used', 'Remaining'];

@endphp


@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Absence Periods" back="admin">
                <a type="button" class="btn btn-secondary mr-5" href="{{ route('admin.new-manage-staff') }}">
                    Add Staff
                </a>
            </x-pages.header>

            <x-pages.card>
                <div class="accordion mb-5" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                Filter Results
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                             aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <x-forms.form route="{{ route('admin.manage-absence-period') }}" simple>

                                    <div class="col-lg-6 mb-2">
                                        <label for="year">Year</label>
                                        <input class="form-control" type="number" min="1900" max="2099"
                                               name="year" value="{{ $year }}" id="year" step="1" placeholder="Year"/>
                                    </div>

                                    <x-forms.select :options="$staffs" :selected="$staff_id" name="staff_id"
                                              label="Technician: " default/>

                                    @include('shared.absence-type', ['type' => $type])

                                    <x-forms.button text="Filter"/>
                                </x-forms.form>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($staff))
                    <div class="mb-5">
                        <a href="{{ route('admin.edit-manage-staff', $staff->id) }}">
                            {{ $staff->first_name }} {{ $staff->surname }}
                        </a>

                        <x-pages.table :heads="$staffHead" simple>
                            <tr>
                                <th>2016</th>
                                <td>{{ $staff->holiday_entitlement_2016['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2016['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2016['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2017</th>
                                <td>{{ $staff->holiday_entitlement_2017['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2017['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2017['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2018</th>
                                <td>{{ $staff->holiday_entitlement_2018['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2018['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2018['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2019</th>
                                <td>{{ $staff->holiday_entitlement_2019['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2019['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2019['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2020</th>
                                <td>{{ $staff->holiday_entitlement_2020['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2020['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2020['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2021</th>
                                <td>{{ $staff->holiday_entitlement_2021['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2021['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2021['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2022</th>
                                <td>{{ $staff->holiday_entitlement_2022['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2022['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2022['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2023</th>
                                <td>{{ $staff->holiday_entitlement_2023['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2023['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2023['remaining'] }}</td>
                            </tr>
                            <tr>
                                <th>2024</th>
                                <td>{{ $staff->holiday_entitlement_2024['entitlement'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2024['used'] }}</td>
                                <td>{{ $staff->holiday_entitlement_2024['remaining'] }}</td>
                            </tr>
                        </x-pages.table>
                    </div>
                @endif

                <x-pages.table id="holiday_table" :heads="$holidaysHead" simple>
                    @foreach ($holidays as $holiday)
                        <tr>
                            <td>{{ $holiday->name }}</td>
                            <td>{{ $holiday->type }}</td>
                            <td>{{ $holiday->date_from }}</td>
                            <td>{{ $holiday->date_to }}</td>
                            <td>{{ BasicHelpers::getDays($holiday) }}</td>
                            <td>{{ $holiday->details }}</td>
                            <td>
                                <a class="list-inline-item"
                                   href="{{ route('admin.edit-holiday', $holiday->id) }}">
                                    <button class="btn btn-success btn-sm rounded-0" type="button"
                                            data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-pages.table>
            </x-pages.card>

        </div>
    </div>
@endsection

@section('scripts')

    <script>1
        $(document).ready(function () {
            let holidayTable = $('#holiday_table').dataTable({
                responsive: true,
                pageLength: 100,
                lengthMenu: [[100, 50, 25, 10, -1], [100, 50, 25, 10, "All"]],
                searching:true
            });
        })
    </script>

@endsection
