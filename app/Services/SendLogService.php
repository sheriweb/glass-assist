<?php

namespace App\Services;

use App\Repositories\SentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SendLogService
 * @package App\Services
 */
class SendLogService
{
    /**
     * SentRepositoryInterface depend injection.
     *
     * @var SentRepositoryInterface
     */
    private $sentRepository;

    public function __construct(SentRepositoryInterface $sentRepository)
    {
        $this->sentRepository = $sentRepository;
    }

    /**
     * @param null $searchValue
     * @return int
     */
    public function getSentLogsCount($searchValue = null): int
    {
        if ($searchValue) {
            return $this->sentRepository->whereLikeCount('recipient', $searchValue);
        }

        return $this->sentRepository->counts();
    }

    /**
     * @param $columnName
     * @param $columnSortOrder
     * @param $searchValue
     * @param $start
     * @param $rowPerPage
     * @return Builder[]|Collection
     */
    public function getSentLogs(
        $columnName,
        $columnSortOrder,
        $searchValue,
        $start,
        $rowPerPage
    ) {
        return $this->sentRepository->paginate(
            $columnName,
            $columnSortOrder,
            $searchValue,
            $start,
            $rowPerPage,
            'recipient',
            'sent'
        );
    }
}
