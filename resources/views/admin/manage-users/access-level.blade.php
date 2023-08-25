@php

    $accessLevel = [
        (object)[
            'id' => 2,
            'name' => 'Manager'
        ],
        (object)[
            'id' => 3,
            'name' => 'User'
        ],
        (object)[
            'id' => 5,
            'name' => 'Technician'
        ],
        (object)[
            'id' => 4,
            'name' => 'Lookup'
        ],
    ];

@endphp

<x-forms.select label="Access Level" name="access_level" :selected="$access_level"
          :options="$accessLevel"/>
