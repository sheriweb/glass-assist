@php

    $types = [
        (object)[
            'id' => 'holiday',
            'name' => 'Holiday'
        ],
        (object)[
            'id' => 'sick_day',
            'name' => 'Sick Day'
        ],
        (object)[
            'id' => 'training',
            'name' => 'Training'
        ],
        (object)[
            'id' => 'other',
            'name' => 'Other'
        ]
    ];

@endphp

<x-forms.select :options="$types" :selected="$type" name="type" label="Type: " default/>

