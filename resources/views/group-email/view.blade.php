@extends('master')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <x-pages.header title="" back="group-email" />

            <div class="card">
                <div class="card-body">
                    <p>To: </p>

                    <h2>{{ $groupEmail->subject }}</h2>

                    <p>Group: {{ $groupEmail->type }}</p>

                    <p>{{ $groupEmail->body }}</p>

                    <p>
                        Glass Assist UK Ltd<br />
                        Whitfield House<br />
                        St Johns Rd Durham<br />
                        Meadowfield Ind Est<br />
                        County Durham<br>
                        DH7 8XL<br />
                        <b>Phone: </b> <a class="text-decoration-underline">0800-195-8628</a><br />
                        <b>Email: </b>info@glassassistuk.co.uk<br />
                        <b>Web: </b> www.glassassistuk.co.uk;<br />
                    </p>
                </div>
            </div>


        </div>
    </div>
@endsection
