<div class="form-group text-center row mt-3 pt-1">
    <div class="{{ isset($large) ? 'col-12' : 'col-4' }}"  {{ isset($disabled) ? 'disabled' : '' }}>
        <button class="btn btn-success w-100 waves-effect waves-light" type="submit">
            {{ $text }}
        </button>
    </div>
</div>
