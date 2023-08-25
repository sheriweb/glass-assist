
<div class="{{ isset($simple) ? '' : 'col-lg-6' }} mb-4">
    @if (!empty($label))
        <label for="{{ $name }}">{{ $label }} <b class="text-danger">{{ isset($required) ? '*' : '' }}</b></label>
    @endif
    <textarea class="form-control {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}"
              {{ isset($id) ? 'id='.$id : 'id='.$name }} {!! isset($required) ? 'required' : '' !!}
              {{ isset($disabled) ? 'disabled' : '' }}
              placeholder="{{ $placeholder ?? '' }}" rows="3">{{ old($name) ?: $value ?? '' }}</textarea>

    @if ($errors->has($name))
        <span class="invalid-feedback">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
