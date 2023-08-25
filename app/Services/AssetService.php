<?php

namespace App\Services;

use App\Repositories\AssetRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\CategoryTypeRepositoryInterface;
use Ramsey\Uuid\Type\Integer;

/**
 * Class AssetService
 * @package App\Services
 */
class AssetService
{
    /**
     * CategoryRepositoryInterface depend injection.
     *
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * AssetRepositoryInterface depend injection.
     *
     * @var AssetRepositoryInterface
     */
    private $assetRepository;

    /**
     * CategoryTypeRepositoryInterface depend injection.
     *
     * @var CategoryTypeRepositoryInterface
     */
    private $categoryTypeRepository;

    public function __construct(
        CategoryRepositoryInterface     $categoryRepository,
        AssetRepositoryInterface        $assetRepository,
        CategoryTypeRepositoryInterface $categoryTypeRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->assetRepository = $assetRepository;
        $this->categoryTypeRepository = $categoryTypeRepository;
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function getCategories(array $columns)
    {
        return $this->categoryRepository->all($columns);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function getAssets(array $columns)
    {
        return $this->assetRepository->all($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function getCategoryTypes(array $columns)
    {
        return $this->categoryTypeRepository->all($columns);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function editCategory($id, array $data)
    {
        return $this->categoryRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function editAsset($id, array $data)
    {
        return $this->assetRepository->update($data, $id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAssetById($id)
    {
        return $this->assetRepository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function addCategoryType(array $data)
    {
        return $this->categoryTypeRepository->insert($data);
    }

    /**
     * @param $categoryId
     * @return mixed
     */
    public function getAssetByCategoryId($categoryId)
    {
        return $this->assetRepository->allWhere(['*'],['category_id' => $categoryId],['categoryType']);
    }
}
