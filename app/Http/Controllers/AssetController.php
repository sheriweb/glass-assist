<?php

namespace App\Http\Controllers;

use App\Helpers\BasicHelpers;
use App\Helpers\StaticMessages;
use App\Services\AssetService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class AssetController extends Controller
{
    /**
     * @var AssetService
     */
    private $assetService;

    /**
     * Create a new controller instance.
     *
     * @param AssetService $assetService
     */
    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     * @throws ValidationException
     */

    public function index()
    {
        return view('ga-asset.category.index');
    }
    public function editAsset(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $payload = $validator->validated();

            if ($request->hasFile('image')) {
                $payload['image'] = BasicHelpers::upload($request);
            }

            if ($request->hasFile('file_name')) {
                $payload['file_name'] = BasicHelpers::upload($request, 'file_name');
            }

            $this->assetService->editAsset($id, $payload);

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $asset = $this->assetService->getAssetById($id);
        $types = $this->assetService->getCategoryTypes(['id', 'name']);

        return view('ga-asset.asset.edit', [
            'asset' => $asset,
            'types' => $types
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|JsonResponse
     */
    public function assetCategories(Request $request)
    {
        $categories = $this->assetService->getCategories(['id', 'name', 'type_id']);
        if($request->has('sidebar')){
            return $categories;
        }
        if ($request->ajax()) {
            return Datatables::of($categories)
                ->addIndexColumn()
                ->addColumn('type', function ($row){
                   return $row->categoryType ? $row->categoryType->name : '';
                })
                ->addColumn('action', function($row){
                    $editRoute = route('ga-asset.edit-asset-categories', $row->id);
                    return '<a class="list-inline-item" href="' . $editRoute . '">
                            <button class="btn btn-success btn-sm rounded-0" type="button"
                                    data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('ga-asset.category.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'string', Rule::notIn(['---'])],
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws ValidationException
     */
    public function addAssetCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $this->assetService->addCategory($request->all());

            return redirect()->route('ga-asset.asset-categories')
                ->with([
                    'message' => StaticMessages::$SAVED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $types = $this->assetService->getCategoryTypes(['*']);

        return view('ga-asset.category.new', [
            'types' => $types
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     * @throws ValidationException
     */
    public function editAssetCategory(Request $request, $id)
    {
        if ($request->isMethod('put')) {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->with([
                        'message' => StaticMessages::$INVALID_REQUEST,
                        'alert-type' => StaticMessages::$ALERT_TYPE_ERROR
                    ])
                    ->withErrors($validator->errors())
                    ->withInput();
            }

            $this->assetService->editCategory($id, $validator->validated());

            return redirect()->back()
                ->with([
                    'message' => StaticMessages::$UPDATED,
                    'alert-type' => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $category = $this->assetService->getCategoryById($id);
        $types = $this->assetService->getCategoryTypes(['*']);

        return view('ga-asset.category.edit', [
            'category' => $category,
            'types' => $types
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function asset()
    {
        $assets = $this->assetService->getAssets(['*']);

        return view('ga-asset.asset.index', [
            'assets' => $assets
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function addAssetCategoryType(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->assetService->addCategoryType($request->except('_token'));

            return redirect()->route('ga-asset.new-asset-categories')

                ->with([
                    'message'      => StaticMessages::$SAVED,
                    'alert-type'   => StaticMessages::$ALERT_TYPE_SUCCESS
                ]);
        }

        $types = $this->assetService->getCategoryTypes(['*']);

        return view('ga-asset.category-type.new', [
            'types' => $types
        ]);
    }

    public function assetIndex($assetCategoryId)
    {
        $category = $this->assetService->getCategoryById($assetCategoryId);
        $types = $this->assetService->getCategoryTypes(['*']);
        $categoryName = $category ? $category->name : '' ;
        $headerTitle = 'CATEGORY - '. $categoryName .' - ASSET LIST';
        return view('ga-asset.asset.index',compact('assetCategoryId','headerTitle','types'));
    }

    public function assetList(Request $request,$assetCategoryId)
    {
        $assets = $this->assetService->getAssetByCategoryId( (integer) $assetCategoryId);
        if ($request->ajax()) {
            return Datatables::of($assets)
                ->addIndexColumn()
                ->addColumn('type', function ($row){
                    return $row->categoryType ? $row->categoryType->name : '';
                })
                ->addColumn('action', function($row){
                    $editRoute = route('ga-asset.edit-asset-categories', $row->id);
                    return '<a class="list-inline-item" href="' . $editRoute . '">
                            <button class="btn btn-success btn-sm rounded-0" type="button"
                                    data-toggle="tooltip"
                                    data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>
                        </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('ga-asset.asset.index',compact('assetCategoryId'));
    }
}
