<div class="{{ isset($simple) ? '' : 'col-lg-6 mb-4' }}">
    <div {{ $attributes->merge(['class' => 'custom-control custom-checkbox']) }} >
        <input type="checkbox" class="custom-control-input {{ $errors->has($name) ? ' is-invalid' : '' }}" name="{{ $name }}"
               {!! isset($checked) == 1 ? 'checked' : '' !!}
            {{ isset($disabled) ? 'disabled' : '' }}
               {{ isset($id) ? 'id='.$id : 'id='.$name }}>
        @if (!empty($label))
            <label class="form-label ms-1" for="{{ $name }}">{{ $label }}</label>
        @endif
    </div>

    @if ($errors->has($name))
        <span class="invalid-feedback">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
