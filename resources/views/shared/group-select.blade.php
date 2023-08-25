@php
    $groupHeads = ['Name', 'Select'];
@endphp

<div class="my-3">
    <h3>Groups</h3>

    <x-pages.table :heads="$groupHeads" id="groupDataTable" simple>
        @foreach($groups as $group)
            <tr>
                <td>{{ $group->name }}</td>
                <td>
                    @if(isset($customer))
                        @foreach($customer->groups as $vg)
                            <input class="form-check-input" type="checkbox" id="flexCheckChecked"
                                   name="group_id"
                                   value="{{ $group->id }}" {!! $vg->id == $group->id ? 'checked' : '' !!}>
                        @endforeach
                    @else
                        <input class="form-check-input" type="checkbox" id="flexCheckChecked" value="{{ $group->id }}"
                               name="group_id{{ $loop->index + 1 }}">
                    @endif
                </td>
            </tr>
        @endforeach
    </x-pages.table>
</div>
