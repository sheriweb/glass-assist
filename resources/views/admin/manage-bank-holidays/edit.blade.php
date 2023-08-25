@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="Edit Bank Holiday" back="admin.manage-bank-holiday" />

            <x-forms.form route="{{ route('admin.edit-manage-bank-holiday', $bankHoliday->id) }}">
                @method('PUT')

                <x-forms.input name="date_from" type="datetime-local" label="Date From" :value="$bankHoliday->date_from"
                         required/>

                <x-forms.input name="date_to" type="datetime-local" label="Date To" :value="$bankHoliday->date_to" required/>

                <x-forms.input name="details" label="Details" :value="$bankHoliday->details"/>

                <x-forms.button text="Update"/>
            </x-forms.form>

        </div>
    </div>
@endsection
