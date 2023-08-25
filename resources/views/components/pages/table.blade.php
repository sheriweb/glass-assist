@if(isset($simple))
    <table id="{{ $id ?? 'datatable' }}" class="table table-bordered dt-responsive bg-white rounded"
           style="border-collapse: collapse; border-spacing: 0; width: 100%;">

        <thead>
        <tr>
            @foreach($heads as $head)
                <th scope="col">{{ $head }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        {{ $slot }}
        </tbody>

    </table>
@else
    <x-pages.card>
        <table id="{{ $id ?? 'datatable' }}" class="table table-bordered dt-responsive bg-white rounded"
               style="border-collapse: collapse; border-spacing: 0; width: 100%;">

            <thead>
            <tr>
                @foreach($heads as $head)
                    <th scope="col">{{ $head }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            {{ $slot }}
            </tbody>

        </table>
    </x-pages.card>
@endif
