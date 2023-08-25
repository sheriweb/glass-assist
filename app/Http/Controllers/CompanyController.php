<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepositoryInterface;
use App\Traits\ViewTrait;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    use ViewTrait;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;

    /**
     * @param CompanyRepositoryInterface $companyRepository
     */
    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function detail(int $id): JsonResponse
    {
        $company = $this->companyRepository->find($id);

        return response()->json($company);
    }
}
