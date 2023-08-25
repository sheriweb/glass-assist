@props([
'options' => [],
'selected' => null,
'name' => null,
'label' =>null,
'optionValue' => null,
'optionName'=> null,
'addClasses'=> null,
'dataAttributes' => []
])
<div class="{{ ($addClasses != null) ? $addClasses : 'col-lg-6' }} mb-2">
    @if (isset($label))
        <label for="{{ $name }}">{{ $label }} <b class="text-danger">{{ isset($required) ? '*' : '' }}</b></label>
    @endif
    <select
        {{ $attributes->merge(['class' => 'select2 form-control select2-selection--single' . ($errors->has($name) ? ' is-invalid' : '')]) }}
        name="{{ $name }}" {{ isset($id) ? 'id='.$id : 'id='.$name }}
    >
        <option value=""></option>
        @if(empty(!$dataAttributes))
            <option value="headings" data-name="headings" disabled>headings</option>
        @endif
        @foreach ($options as $key => $value)
            <option value="{{ $value[$optionValue] }}"
                    @foreach($dataAttributes as $dataAttribute)
                        data-{{$dataAttribute}}="{{$value[$dataAttribute]}}"
                @endforeach
                {{ $selected == $value[$optionValue] ? 'selected' : '' }}>
                {{ $value[$optionName] }}
            </option>
        @endforeach
    </select>
    @if ($errors->has($name))
        <span class="invalid-feedback">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
