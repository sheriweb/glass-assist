<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PDF</title>

    <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
</head>
<style>
    body {
        font-family: Roboto, system-ui, sans-serif;
        font-size: 81.25%;
    }
</style>

<body>

<main>
    <div class="header">
        <table style="width: 100%;">
            <tr>
                <td colspan="6">I.C.I.S. Software Ltd</td>
                <td colspan="6">Tel: 0845 094 9713</td>
            </tr>
            <tr>
                <td colspan="6">Maingate, Kingsway North</td>
                <td colspan="6">E-mail: admin@icis.co.uk</td>
            </tr>
            <tr>
                <td colspan="6">Team Valley, Gateshead.</td>
                <td colspan="6">Company No: 08509765</td>
            </tr>
            <tr>
                <td colspan="6">NE11 0NQ.</td>
                <td colspan="6">VAT No: 161367807</td>
            </tr>
        </table>

        <h1>Invoice Details</h1>

        <table cellspacing="0" cellpadding="5" style="width: 100%;">
            <tr>
                <th style="border:1px solid #ddd;">Your Address</th>
                <th style="border:1px solid #ddd;">Invoice Date</th>
                <th style="border:1px solid #ddd;">Invoice Number</th>
            </tr>
            <tr>
                <td style="border:1px solid #ddd;">
                    {{ $order->user->address_1 }}<br>
                    {{ $order->user->address_2 }}<br>
                    {{ $order->user->city }}<br>
                    {{ $order->user->country }}
                    {{ $order->user->postcode }}
                </td>
                <td style="border:1px solid #ddd;">
                    {{ $order->date_added }}
                </td>
                <td style="border:1px solid #ddd;">IV{{ $order->id }}</td>
            </tr>
        </table>

        <h2>Description</h2>

        <table cellspacing="0" cellpadding="5" style="width: 100%;">
            <tr>
                <th style="border:1px solid #ddd; width:55%; text-align:left;">Description</th>
                <th style="border:1px solid #ddd; width:15%; text-align:right;">Unit Price</th>
                <th style="border:1px solid #ddd; width:15%; text-align:right;">Quantity</th>
                <th style="border:1px solid #ddd; width:15%; text-align:right;">Price</th>
            </tr>
            <tr>
                <td style="border:1px solid #ddd; text-align:left;">' . $item_description . '</td>
                <td style="border:1px solid #ddd; text-align:right;">&pound;' . $amt_without_vat . '</td>
                <td style="border:1px solid #ddd; text-align:right;">1</td>
                <td style="border:1px solid #ddd; text-align:right;">&pound;' . $amt_without_vat . '</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <th style="border:1px solid #ddd; text-align:right;">Sub Total</th>
                <td style="border:1px solid #ddd; text-align:right;">&pound;' . $amt_without_vat . '</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <th style="border:1px solid #ddd; text-align:right;">VAT</th>
                <td style="border:1px solid #ddd; text-align:right;">&pound;' . $vat . '</td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <th style="border:1px solid #ddd; text-align:right;">Total</th>
                <td style="border:1px solid #ddd; text-align:right;">&pound;' . $amt_with_vat . '</td>
            </tr>
        </table>
    </div>
</main>


</body>
</html>
