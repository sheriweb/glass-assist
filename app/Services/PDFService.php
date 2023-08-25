<?php

namespace App\Services;

use App\Repositories\OrderRepositoryInterface;

/**
 * Class PDFService
 * @package App\Services
 */
class PDFService
{
    /**
     * OrderRepositoryInterface depend injection.
     *
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOrder($id)
    {
        return $this->orderRepository->find($id);
    }

    public static function get_service_type($items)
    {
        $sql = "select group_concat(left(upper(name),3)) as items
                    from items
                    where id in (".$items.")
                    and `status` = 1
                    and user_id = :user_id;";
        $params = array('user_id'=>$_SESSION['account_id']);
        $result = Database::select_row($sql,$params);
        return $result['items'];
    }
}
