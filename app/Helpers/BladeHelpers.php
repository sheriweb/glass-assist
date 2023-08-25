<?php

namespace App\Helpers;

use Carbon\Carbon;
use DateInterval;
use DateTime;

class BladeHelpers
{
    /**
     * @param string $date
     * @param int $day
     * @return string
     */
    public static function getDayFromDate(string $date, int $day): string
    {
        return date('D', strtotime('+' . $day . ' day', strtotime($date)))
            ?: Carbon::now()->toDateTimeLocalString();
    }

    /**
     * @param string $datetime
     * @param int $day
     * @return string
     */
    public static function getDateFromDatetime(string $datetime, int $day = 0): string
    {
        return date('Y/m/d', strtotime('+' . $day . ' day', strtotime($datetime)))
            ?: Carbon::now()->toDateTimeLocalString();
    }

    /**
     * @param string $first
     * @param string $last
     * @param int $day
     * @return bool
     */
    public static function checkDatesEqual(string $first, string $last, int $day): bool
    {
        return date('Y/m/d', strtotime($first))
            === date('Y/m/d', strtotime('+' . $day . ' day', strtotime($last)));
    }

    /**
     * @param $data
     * @return array
     */
    public static function showBankHolidays($data): array
    {
        $events = [];
        foreach ($data as $k => $item) {
            $title = "Bank Holiday";
            $color = "#0f9cf3";

            //$title .= $item->details ? " - {$item->details}" : "";
            $start = new DateTime($item->date_from);
            $end = new DateTime($item->date_to);

            while ($start <= $end) {
                $event = [
                    'start'         => $start->add(new DateInterval('P1D'))->format('Y-m-d'),
                    'end'           => $start->format('Y-m-d'),
                    'title'         => "<i class='fa fa-tree'></i> " . ucwords(strtolower($title)),
                    'extendedProps' => [
                        'isHoliday' => true
                    ],
                    'textColor'     => $color,
                    'borderColor'   => $color
                ];

                $events[] = $event;
                $start->modify('+1 day');
            }
        }

        return $events;
    }

    /**
     * @param $data
     * @return array
     */
    public static function showStaffHolidays($data): array
    {
        $events = [];
        $arrayData = [];
        $color = "#0f9cf3";

        foreach ($data as $k => $item) {
            $title = "";

            switch ($item->type) {
                case 'holiday':
                    $title = 'Holiday - ';
                    break;
                case 'sick_day':
                    $title = 'Sick Day - ';
                    break;
                case 'training':
                    $title = 'Training - ';
                    break;
                case 'other':
                    $title = 'Other - ';
                    break;
            }

            if ($item->staff) {
                if ($item->ampm != '') {
                    $title .= $item->staff->first_name . ' ' . $item->staff->surname . ' (' . strtoupper(
                            $item->ampm
                        ) . ')' . "";
                } else {
                    $title .= ($item->staff->first_name ?? "") . ' ' . ($item->staff->surname ?? "");
                }

                $start = new DateTime($item->date_from);
                $end = new DateTime($item->date_to);

                while ($start <= $end) {
                    $eventDate = $start->format('Y-m-d');
                    $eventTitle = ucwords(strtolower($title));

                    if (isset($events[$eventDate])) {
                        $events[$eventDate] .= "<i class='fa fa-tree'></i> " . ucwords(strtolower($eventTitle)) . "<br/>";
                    } else {
                        $events[$eventDate] = "<i class='fa fa-tree'></i> " . ucwords(strtolower($eventTitle)) . "<br/>";
                    }

                    $start->modify('+1 day');
                }
            }
        }

        foreach ($events as $date => $title) {
            $event = [
                'start'         => date('Y-m-d H:i:s', strtotime($date . ' +6 hours')),
                'title'         => $title,
                'extendedProps' => [
                    'isHoliday' => true
                ],
                'textColor'     => $color,
                'borderColor'   => $color
            ];

            $arrayData[] = $event;
        }

        return $arrayData;
    }

    /**
     * @param $data
     * @return array
     */
    public static function convertData($data): array
    {
        $arrayData = [];
        foreach ($data as $k => $item) {
            $title = "";
            $description = "";
            $carMakeModel = "";
            $footer = "";
            $className = "border-1 m-2 text-wrap rounded p-2";

            $title .= $item->company ? "<i class='fa fa-industry'></i> " . ucwords(
                    strtolower($item->company->name)
                ) . "<br/>" : "";
            $title .= $item->customer->first_name ? "<i class='fa fa-user'></i> " . ucwords(
                    strtolower($item->customer->first_name)
                ) . " " : "";
            $title .= $item->customer->surname ? ucwords(strtolower($item->customer->surname)) . "<br/>" : "";

            $carMakeModel .= $item->vehicle->carMake ? ucwords(strtolower($item->vehicle->carMake->name)) . " - " : "";
            $carMakeModel .= $item->vehicle->carModel ? ucwords(strtolower($item->vehicle->carModel->name)) . " " : "";

            if (trim($carMakeModel) == '') {
                $carMakeModel .= $item->manual_make_model ? ucwords(strtolower($item->manual_make_model)) . " " : "";
            }

            $carMakeModel .= $item->vehicle->reg_no ? "({$item->vehicle->reg_no})" : "";

            $description .= $item->customer->address_2 ? "<i class='fa fa-location-arrow'></i> " . ucwords(
                    strtolower($item->customer->address_2)
                ) . "<br/>" : "";
            $description .= $item->customer->city ? ($description ? "" : "<i class='fa fa-location-arrow'></i> ") . ucwords(
                    strtolower($item->customer->city)
                ) . "<br/>" : "";
            $description .= $item->subcat_name ? ucwords(strtolower($item->subcat_name)) . "<br/>" : "";
            $description .= $item->subContractor ? "<i class='fa fa-forward'></i> " . ucwords(
                    strtolower($item->subContractor->name)
                ) . "<br/>" : "";
            $description .= $item->glassSupplier ? "<i class='fa fa-share'></i> " . ucwords(
                    strtolower($item->glassSupplier->name)
                ) . "<br/>" : "";
            $description .= $item->glasssupplier_name == 'calibration' ? "Calibration<br/>" : "";
            $footer .= $item->part_code ? "<i class='fa fa-barcode'></i> " . $item->part_code . "<br/>" : "";
            $footer .= $item->technicianData ? "<i class='fa fa-tools'></i> " . ucwords(
                    strtolower($item->technicianData->first_name)
                ) . " " : "";
            $footer .= $item->technicianData ? ucwords(strtolower($item->technicianData->surname)) : "";

            $color = $item->statusColor();

            $arrayData[$k]['id'] = $item->id;
            $arrayData[$k]['title'] = $title;
            $arrayData[$k]['className'] = $className;
            $arrayData[$k]['textColor'] = $item->status === 8 ? "#dddddd" : "#0a1b32";
            $arrayData[$k]['borderColor'] = $color;
            $arrayData[$k]['start'] = date('Y-m-d 09:00:00', strtotime($item->datetime));
            $arrayData[$k]['description'] = $description;
            $arrayData[$k]['extendedProps']['carMakeModel'] = $carMakeModel;
            $arrayData[$k]['extendedProps']['footer'] = $footer;
            $arrayData[$k]['extendedProps']['calendarType'] = $item->calendar;
            $arrayData[$k]['extendedProps']['addedDate'] = date('d M', strtotime($item->date_added));
            $arrayData[$k]['extendedProps']['isHoliday'] = false;

            if ($item->customer) {
                $arrayData[$k]['extendedProps']['coordinate']['lat'] = $item->customer->lat;
                $arrayData[$k]['extendedProps']['coordinate']['lng'] = $item->customer->lng;
                $arrayData[$k]['extendedProps']['coordinate']['postcode'] = $item->customer->postcode;
                $arrayData[$k]['extendedProps']['coordinate']['customerFirstName'] = $item->customer ? $item->customer->first_name . " " : "";
                $arrayData[$k]['extendedProps']['coordinate']['customerSurname'] = $item->customer ? $item->customer->surname : "";
                $arrayData[$k]['extendedProps']['coordinate']['companyName'] = $item->company ? $item->company->name : "";
                $arrayData[$k]['extendedProps']['coordinate']['regNo'] = $item->reg_no;
                $arrayData[$k]['extendedProps']['coordinate']['status'] = $item->status;
                $arrayData[$k]['extendedProps']['coordinate']['datetime'] = date('d/m/Y', strtotime($item->datetime));
                $arrayData[$k]['extendedProps']['coordinate']['subContractor'] = $item->subContractor ? $item->subContractor->name : "";

                if ($item->technicianData) {
                    $arrayData[$k]['extendedProps']['coordinate']['technicianFirstName'] = $item->technicianData->first_name ? ucwords(strtolower($item->technicianData->first_name)) . " " : "";
                    $arrayData[$k]['extendedProps']['coordinate']['technicianSurname'] = $item->technicianData->surname ? ucwords(strtolower($item->technicianData->surname)) : "";
                }
            }
        }

        return $arrayData;
    }

    /**
     * @return array
     */
    public static function selectColor(): array
    {
        $colors = [
            'white'         => 'White',
            'snow'          => 'Snow',
            'honeydew'      => 'Honeydew',
            'mintcream'     => 'MintCream',
            'azure'         => 'Azure',
            'aliceblue'     => 'AliceBlue',
            'ghostwhite'    => 'GhostWhite',
            'whitesmoke'    => 'WhiteSmoke',
            'seashell'      => 'Seashell',
            'beige'         => 'Beige',
            'oldlace'       => 'OldLace',
            'floralwhite'   => 'FloralWhite',
            'ivory'         => 'Ivory',
            'antiquewhite'  => 'AntiqueWhite',
            'linen'         => 'Linen',
            'lavenderblush' => 'LavenderBlush',
            'mistyrose'     => 'MistyRose',

            'pink'            => 'Pink',
            'lightpink'       => 'LightPink',
            'hotpink'         => 'HotPink',
            'deeppink'        => 'DeepPink',
            'palevioletred'   => 'PaleVioletRed',
            'mediumvioletred' => 'MediumVioletRed',

            'lightsalmon' => 'LightSalmon',
            'salmon'      => 'Salmon',
            'darksalmon'  => 'DarkSalmon',
            'lightcoral'  => 'LightCoral',
            'indianred'   => 'IndianRed',
            'crimson'     => 'Crimson',
            'firebrick'   => 'FireBrick',
            'darkred'     => 'DarkRed',
            'red'         => 'Red',

            'orangered'  => 'OrangeRed',
            'tomato'     => 'Tomato',
            'coral'      => 'Coral',
            'darkorange' => 'DarkOrange',
            'orange'     => 'Orange',

            'yellow'               => 'Yellow',
            'lightyellow'          => 'LightYellow',
            'lemonchiffon'         => 'LemonChiffon',
            'lightgoldenrodyellow' => 'LightGoldenrodYellow',
            'papayawhip'           => 'PapayaWhip',
            'moccasin'             => 'Moccasin',
            'peachpuff'            => 'PeachPuff',
            'palegoldenrod'        => 'PaleGoldenrod',
            'khaki'                => 'Khaki',
            'darkkhaki'            => 'DarkKhaki',
            'gold'                 => 'Gold',

            'cornsilk'       => 'Cornsilk',
            'blanchedalmond' => 'BlanchedAlmond',
            'bisque'         => 'Bisque',
            'navajowhite'    => 'NavajoWhite',
            'wheat'          => 'Wheat',
            'burlywood'      => 'BurlyWood',
            'tan'            => 'Tan',
            'rosybrown'      => 'RosyBrown',
            'sandybrown'     => 'SandyBrown',
            'goldenrod'      => 'Goldenrod',
            'darkgoldenrod'  => 'DarkGoldenrod',
            'peru'           => 'Peru',
            'chocolate'      => 'Chocolate',
            'saddlebrown'    => 'SaddleBrown',
            'sienna'         => 'Sienna',
            'brown'          => 'Brown',
            'maroon'         => 'Maroon',

            'darkolivegreen'    => 'DarkOliveGreen',
            'olive'             => 'Olive',
            'olivedrab'         => 'OliveDrab',
            'yellowgreen'       => 'YellowGreen',
            'limegreen'         => 'LimeGreen',
            'lime'              => 'Lime',
            'lawngreen'         => 'LawnGreen',
            'chartreuse'        => 'Chartreuse',
            'greenyellow'       => 'GreenYellow',
            'springgreen'       => 'SpringGreen',
            'mediumspringgreen' => 'MediumSpringGreen',
            'lightgreen'        => 'LightGreen',
            'palegreen'         => 'PaleGreen',
            'darkseagreen'      => 'DarkSeaGreen',
            'mediumaquamarine'  => 'MediumAquamarine',
            'mediumseagreen'    => 'MediumSeaGreen',
            'seagreen'          => 'SeaGreen',
            'forestgreen'       => 'ForestGreen',
            'green'             => 'Green',
            'darkgreen'         => 'DarkGreen',

            'aqua'            => 'Aqua',
            'cyan'            => 'Cyan',
            'lightcyan'       => 'LightCyan',
            'paleturquoise'   => 'PaleTurquoise',
            'aquamarine'      => 'Aquamarine',
            'turquoise'       => 'Turquoise',
            'mediumturquoise' => 'MediumTurquoise',
            'darkturquoise'   => 'DarkTurquoise',
            'lightseagreen'   => 'LightSeaGreen',
            'cadetblue'       => 'CadetBlue',
            'darkcyan'        => 'DarkCyan',
            'teal'            => 'Teal',

            'lightsteelblue' => 'LightSteelBlue',
            'powderblue'     => 'PowderBlue',
            'lightblue'      => 'LightBlue',
            'skyblue'        => 'SkyBlue',
            'lightskyblue'   => 'LightSkyBlue',
            'deepskyblue'    => 'DeepSkyBlue',
            'dodgerblue'     => 'DodgerBlue',
            'cornflowerblue' => 'CornflowerBlue',
            'steelblue'      => 'SteelBlue',
            'royalblue'      => 'RoyalBlue',
            'blue'           => 'Blue',
            'mediumblue'     => 'MediumBlue',
            'darkblue'       => 'DarkBlue',
            'navy'           => 'Navy',
            'midnightblue'   => 'MidnightBlue',

            'lavender'        => 'Lavender',
            'thistle'         => 'Thistle',
            'plum'            => 'Plum',
            'violet'          => 'Violet',
            'orchid'          => 'Orchid',
            'fuchsia'         => 'Fuchsia',
            'magenta'         => 'Magenta',
            'mediumorchid'    => 'MediumOrchid',
            'mediumpurple'    => 'MediumPurple',
            'blueviolet'      => 'BlueViolet',
            'darkviolet'      => 'DarkViolet',
            'darkorchid'      => 'DarkOrchid',
            'darkmagenta'     => 'DarkMagenta',
            'purple'          => 'Purple',
            'indigo'          => 'Indigo',
            'darkslateblue'   => 'DarkSlateBlue',
            'rebeccapurple'   => 'RebeccaPurple',
            'slateblue'       => 'SlateBlue',
            'mediumslateblue' => 'MediumSlateBlue',

            '#EEEEEE'        => 'LighterGrey',
            'gainsboro'      => 'Gainsboro',
            'lightgrey'      => 'LightGrey',
            'silver'         => 'Silver',
            'darkgray'       => 'DarkGray',
            'gray'           => 'Gray',
            'dimgrey'        => 'DimGrey',
            'lightslategray' => 'LightSlateGray',
            'slategray'      => 'SlateGray',
            'darkslategray'  => 'DarkSlateGray',
            '#333333'        => 'DarkerGrey',
            'black'          => 'Black'
        ];

        $results = [];

        foreach ($colors as $key => $value) {
            $results[] = (object)[
                'id'   => $key,
                'name' => $value
            ];
        }

        return $results;
    }
}
