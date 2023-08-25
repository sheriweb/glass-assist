<div class="{{ isset($simple) ? 'col-lg-12' : 'col-lg-6' }} mb-2">
    <label id='select-label' for="{{ $name }}">{{ $label }} <b class="text-danger">{{ isset($required) ? '*' : '' }}</b></label>
        <select class="form-select js-data-example-ajax {{ $errors->has($name) ? ' is-invalid' : '' }}"
            name="{{ $name }}" {{ isset($id) ? 'id='.$id : 'id='.$name }}
        {{ isset($disabled) ? 'disabled' : '' }}
            {!! isset($required) ? 'required' : '' !!}>
        @if(isset($default))
            <option value="" selected>-- select --</option>
        @endif

        @foreach($options as $option)
            <option value="{{ $option->id }}"
                    {!! isset($selected) && $option->id == $selected ? 'selected' : '' !!}>{{ $option->name }}</option>
        @endforeach
    </select>

    {{ $slot }}

    @if ($errors->has($name))
        <span class="invalid-feedback">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
