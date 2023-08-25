<?php

namespace App\Services;

use App\Repositories\WhatWindscreenApiRepositoryInterface;

class WhatWindscreenApiService
{

    protected $WhatWindscreenApiRepository;

    public function __construct(WhatWindscreenApiRepositoryInterface $WhatWindscreenApiRepository)
    {
        $this->WhatWindscreenApiRepository = $WhatWindscreenApiRepository;
    }

    public function getById($id)
    {
        return $this->WhatWindscreenApiRepository->get($id);
    }

    public function create($request)
    {
        return $this->WhatWindscreenApiRepository->create($request);
    }

    public function glassPositions()
    {
        return $this->WhatWindscreenApiRepository->glassPositions();
    }
    public function getWhatWindScreenLookupById($lookupId)
    {
        return $this->WhatWindscreenApiRepository->get($lookupId);
    }

}
