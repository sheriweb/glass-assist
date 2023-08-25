<?php

namespace App\Http\Controllers;

use App\Services\WhatWindscreenApiService;
use Illuminate\Http\Request;

class WhatWindscreenApiController extends Controller
{
    /**
     * @var WhatWindscreenApiService
     */
    private $whatWindscreenApiService;

    public function __construct(WhatWindscreenApiService $whatWindscreenApiService)
    {
        $this->whatWindscreenApiService = $whatWindscreenApiService;
    }
    public function getGlassPositions()
    {
       return  $this->whatWindscreenApiService->glassPositions();
    }
    public function getWhatWindScreenLookup(Request $request)
    {
        return  $this->whatWindscreenApiService->getWhatWindScreenLookupById($request->lookupId);
    }
}
