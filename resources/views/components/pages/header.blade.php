<div class="page-title-box p-0 d-sm-flex align-items-center justify-content-between d-flex justify-content-between
{{isset($customClass) ? $customClass : ''}}">
    <h4 class="mb-sm-0">{{ $title }}</h4>
    <div class="float-right" role="group">
        @if(isset($back))
            <a type="button" class="btn btn-secondary mr-5" href="{{ route($back) }}">Back</a>
        @endif
        {{ $slot }}
    </div>
</div>
