<div class="{{ isset($simple) ? '' : 'col-lg-6' }} mb-2">
    @if ($label)
        <label for="{{ $name }}">{{ $label }} <b class="text-danger">{{ isset($required) ? '*' : '' }}</b></label>
    @endif
    <input class="form-control {{ $errors->has($name) ? ' is-invalid' : '' }}"
           type="{{ $type ?? 'text' }}" {{ isset($readonly) ? 'readonly' : '' }}
           name="{{ $name }}" {{ isset($id) ? 'id='.$id : 'id='.$name }}
           {!! isset($required) ? 'required' : '' !!}
           {{ isset($disabled) ? 'disabled' : '' }}
           value="{{ old($name) ?: $value ?? '' }}" placeholder="{{ $placeholder ?? $label }}"/>

    {{ $slot }}
    <span class="error_{{$name}} text-danger"></span>
    @if ($errors->has($name))
        <span class="invalid-feedback">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
