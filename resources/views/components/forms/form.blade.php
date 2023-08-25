@if(!isset($simple))
    <x-pages.card>
        <form class="booking-form form-horizontal" method="POST"
              {!! isset($media) ? 'accept-charset="utf-8" enctype="multipart/form-data"' : '' !!}
              action="{{ $route }}"
                id = {{ isset($formId) ? 'technician-booking-form' : ''}}
                >
            @csrf

            {{ $slot }}
        </form>
    </x-pages.card>
@else
    <form class="booking-form form-horizontal" method="POST"
          {!! isset($media) ? 'accept-charset="utf-8" enctype="multipart/form-data"' : '' !!}
          action="{{ $route }}"
          id = {{ isset($formId) ? 'technician-booking-form' : ''}}
    >
        @csrf

        {{ $slot }}
    </form>
@endif
