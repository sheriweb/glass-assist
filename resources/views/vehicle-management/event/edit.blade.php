@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Vehicle Event" back="vehicle-event"/>

            <x-forms.form route="{{ route('vehicle-event.edit',$vehicleMaintenanceEvent->id) }}"
                          enctype="multipart/form-data">
                @method('PUT')

                <x-forms.input label="Start Date" name="start_date" :value="$vehicleMaintenanceEvent->start_date"/>
                <x-forms.input type="hidden" label="" name="vehicle_event_maintenance_id"
                               :value="$vehicleMaintenanceEvent->vehicle_maintenance_id"/>

                <x-forms.input label="End Date" name="end_date" :value="$vehicleMaintenanceEvent->end_date"/>

                <x-forms.input label="Schedule Time" name="schedule_time"
                               :value="$vehicleMaintenanceEvent->schedule_time"/>

                <x-forms.input label="Service Type" name="service_type"
                               :value="$vehicleMaintenanceEvent->service_type"/>

                <x-forms.input label="Note" name="note" :value="$vehicleMaintenanceEvent->note"/>

                <x-forms.input label="Cost" name="cost" :value="$vehicleMaintenanceEvent->cost"/>

                <x-forms.input label="Invoice Ref." name="invoice_ref" :value="$vehicleMaintenanceEvent->invoice_ref"/>

                {{--<x-forms.checkbox label="Event Completed" name="event_completed"
                                  :checked="$vehicleMaintenanceEvent->event_completed"/>--}}

                <label>Event Completed</label>&nbsp;&nbsp;&nbsp;
                <input type="checkbox"
                       name="event_completed" {{ ($vehicleMaintenanceEvent->event_completed == 1 ? ' checked' : '') }} />
                <br>

                <label>Attach File</label>
                <input type="file" style="width: 50%" name="file_name[]" class="col-lg-4 col-md-2 form-control" multiple >

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection
