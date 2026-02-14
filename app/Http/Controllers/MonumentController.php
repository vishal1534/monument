<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\CostPSqureFeet;
use App\Models\Country;
use App\Models\Monument;
use App\Models\MonumentFile;
use App\Models\MonumentImage;
use App\Models\MonumentInventory;
use App\Models\MonumentPolish;
use App\Models\ProductColor;
use App\Models\ProductEngrave;
use App\Models\ProductFreight;
use App\Models\ProductInstallation;
use App\Models\ProductPolish;
use App\Models\ProductShape;
use App\Models\ProductSide;
use App\Models\ProductSpecification;
use App\Models\ProductType;
use App\Models\Service;
use App\Models\Simple;
use Exception;
use Illuminate\Http\Request;

class MonumentController extends Controller
{
    use FileUpload, Searchable, Accessible, Paginateable;

    public $relations = ['specification', 'polish', 'engrave', 'freight', 'color', 'shape', 'side', 'monumentPolish', 'type',
        'files', 'images', 'monumentInventory', 'installation', 'saleHistory.monumentInvoice.order.family', 'saleHistory.monumentInvoice.order.company'];

    public function index()
    {
        $monuments = new Monument();
        return response()->json($monuments->with($this->relations)->orderBy('product_number', 'desc')->get());
    }

    public function getRecordPagination()
    {
        $monuments = new Monument();
        $estimator = request()->estimator;
        $direction = 'asc';
        if ($estimator == 'monument') {
            $monuments = $this->getMonumentPagination($monuments, $direction, 'product_number', '', '', 10);
        } else {
            $monuments = $this->getPriceEstimatorPaginate($monuments, $direction, 'product_number', 10);
        }
        return response()->json($monuments);
    }

    private function getMonumentPagination($monuments, $direction, $sortByColumn, $tableName, $sumColumnName, $perPage)
    {
        return $monuments->select('*', $sortByColumn)
            ->selectRaw("$sortByColumn * 1 as pd")
            ->with($this->relations)
            ->withSum($tableName, $sumColumnName)
            ->orderBy('pd', $direction)
            ->orderBy($sortByColumn, $direction)
            ->whereNull('price_estimator')
            ->orWhere('price_estimator', '=', '')
            ->paginate($perPage);
    }

    private function getPriceEstimatorPaginate($monuments, $direction, $sortByColumn, $perPage)
    {
        return $monuments->select('*', $sortByColumn)
            ->selectRaw("$sortByColumn * 1 as pd")
            ->with($this->relations)
            ->orderBy('pd', $direction)
            ->orderBy($sortByColumn, $direction)
            ->whereNotNull('price_estimator')
            ->paginate($perPage);
    }

    public function reportInfo()
    {
        $monuments = new Monument();
        $simpleController = new SimpleController();
        $ServiceController = new ServiceController();
        $simple = new Simple();
        $service = new Service();
        $simple = $simple->withSum('products', 'amount')->with($simpleController->relation)->orderBy('product_number', 'desc')->get()->toArray();
        $service = $service->withSum('products', 'amount')->with($ServiceController->relation)->orderBy('product_number', 'desc')->get()->toArray();
        $monuments = $monuments->withSum('products', 'amount')->with($this->relations)->whereNull('price_estimator')->orWhere('price_estimator', '=', '')->orderBy('product_number', 'desc')->get()->toArray();
        $productCollection = array_merge_recursive($monuments, $service, $simple);
        return response()->json($productCollection);
    }

    public function show($monument)
    {
        try {
            $estimator = request()->estimator;
            $model = Monument::class;
            if ($estimator == 'price-estimator' || $estimator == 'price-estimator-list') {
                $monument = $model::whereNotNull('price_estimator')->whereId($monument)->first();
                $monument->load($this->relations);
            } elseif ($estimator == 'monuments' || $estimator == 'monuments-list' || $estimator == 'product-catalog-list') {
                $monument = $model::whereNull('price_estimator')->whereId($monument)->first();
                $monument->load($this->relations);
            }
            return response()->json($monument);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function store(AddMonumentRequest $request)
    {
        $monument = json_decode($request->data, true);
        if (!isset($monument['price_estimator']) && empty($monument['price_estimator'])) {
            if (($monument['id'] == 0)) {
                if ($this->isProductNumberExist($monument['product_number'])) {
                    return response()->json(["errorInfo" => ["Duplicate entry '" . $monument['product_number'] . "' for key 'product_number'"]], 200);
                }
            } else {
                $className = Monument::class;
                if ($this->productNoForUpdate($className, $monument['id'], $monument['product_number']))
                    return response()->json(["errorInfo" => ["Duplicate entry '" . $monument['product_number'] . "' for key 'product_number'"]], 200);
            }
        }
        try {
            $monumentInventory = null;
            $specification = $monument['specification'];
            $polish = $monument['polish'];
            $engrave = $monument['engrave'];
            $freight = $monument['freight'];
            $installation = $monument['installation'];
            if (isset($monument['monument_inventory'])) {
                $monumentInventory = $monument['monument_inventory'];
                unset($monument['monument_inventory']);
            }
            unset($monument['specification'], $monument['polish'], $monument['engrave'], $monument['freight'], $monument['installation']);
            $monumentInstance = Monument::updateOrCreate(['id' => $monument['id']], $monument);
            if (!empty($monumentInventory) && sizeof($monumentInventory) > 0) {
                foreach ($monumentInventory as $key => $value) {
                    $inventory = [];
                    $inventory['id'] = $monumentInventory[$key]['id'];
                    $inventory['qty_add_or_remove'] = $monumentInventory[$key]['qty_add_or_remove'];
                    $inventory['by_whom'] = $monumentInventory[$key]['by_whom'];
                    if ($value['id'] != 0) {
                        $inventory['total'] = $monumentInventory[$key]['total'];
                    }
                    if ($value['id'] == 0) {
                        $className = MonumentInventory::class;
                        $total = $this->getTotal($className, 'monument_id', $monumentInstance->id);
                        $inventory['total'] = $value['qty_add_or_remove'] + $total;
                        $inventory['date'] = $this->changeDateFormat($monumentInventory[$key]['date']);
                        if ($monumentInstance->total_added == null) {
                            $monumentInstance->total_added = $value['qty_add_or_remove'];
                            $monumentInstance->save();
                        } else {
                            $monumentInstance->increment('total_added', $value['qty_add_or_remove']);
                        }
                    }
                    $monumentInstance->monumentInventory()->updateOrCreate(['id' => $inventory['id']], $inventory);
                    unset($inventory);
                }
            }
            $monumentInstance->specification()->updateOrCreate(['id' => $specification['id']], $specification);
            if ($request->hasFile('doc_images')) {
                foreach ($request->doc_images as $file) {
                    // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just extension
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    // Filename to store
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $file->storeAs('public/monuments', $filenameToStore);
                    // Store in DB
                    $document = new MonumentImage();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $monumentInstance->images()->save($document);
                }
            }
            if (count($this->arrayCount($polish)) > 0)
                $monumentInstance->polish()->updateOrCreate(['id' => $polish['id']], $polish);
            if (count($this->arrayCount($engrave)) > 0)
                $monumentInstance->engrave()->updateOrCreate(['id' => $engrave['id']], $engrave);
            if (count($this->arrayCount($freight)) > 0)
                $monumentInstance->freight()->updateOrCreate(['id' => $freight['id']], $freight);
            if (count($this->arrayCount($installation)) > 0)
                $monumentInstance->installation()->updateOrCreate(['id' => $installation['id']], $installation);
            if ($request->hasFile('doc_files')) {
                foreach ($request->doc_files as $file) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $file->storeAs('public/monuments', $filenameToStore);
                    $document = new MonumentFile();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $monumentInstance->files()->save($document);
                }
            }
            if (!isset($monument['price_estimator']) && empty($monument['price_estimator']))
                $monumentInstance->total_on_hand = $monumentInstance->total_added - $monumentInstance->total_sold;
            $monumentInstance->save();
            $monumentInstance->load($this->relations);
            return response()->json($monumentInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != 0 && $item != null;
        });
        return $arrCount;
    }

    public function destroy(Monument $monument)
    {

        /*$monument->specification()->delete();
        $monument->polish()->delete();
        $monument->freight()->delete();
        $monument->engrave()->delete();
        $monument->installation()->delete();
//        $monument->documents()->delete();

        if(isset($monument->image)){
            $imagePath = "images/monuments/".$monument->image;
            if (file_exists($imagePath))
                unlink($imagePath);
        }*/

        //dd($monument->load(['products']));
        $monument->products()->delete();
        $monument->compositeProducts()->delete();
        return $monument->delete();
    }

    public function getColumns()
    {
        $preFix = request()->route()->getPrefix();
        $monument = new Monument;
        $specification = new ProductSpecification;
        $polish = new ProductPolish;
        $engrave = new ProductEngrave;
        $freight = new ProductFreight;
        $installation = new ProductInstallation;
        $type = new ProductType;
        $color = new ProductColor;
        $side = new ProductSide;
        $shape = new ProductShape;
//        \DB::enableQueryLog();
        $monument = $monument->getTableColumns();
        /* $queries = \DB::getQueryLog();
         dd($queries);
         exit();*/
        $specification = $specification->getTableColumns();
        $polish = $polish->getTableColumns();
        $engrave = $engrave->getTableColumns();
        $freight = $freight->getTableColumns();
        $installation = $installation->getTableColumns();
        $type = $type->getTableColumns();
        $color = $color->getTableColumns();
        $side = $side->getTableColumns();
        $shape = $shape->getTableColumns();
        $data = [];
        $data['monument'] = $monument;
        $data['specification'] = $specification;
        $data['polish'] = $polish;
        $data['engrave'] = $engrave;
        $data['freight'] = $freight;
        $data['installation'] = $installation;
        $data['type'] = $type;
        $data['color'] = $color;
        $data['side'] = $side;
        $data['shape'] = $shape;
        return response()->json($data);
    }

    public function search(AddMonumentRequest $request)
    {
        $monument = new Monument;
        $request = $request->all();
        $sortDirection = 'asc';
        $sortByColumn = 'product_number';
        $columnTableName = 'monument';
        $foreignKey = null;
        $childClassName = null;
        $childTableName = null;
        $sortDirection = $request['sortDirection'];
        $sortByColumn = $request['sortByColumn'];
        $columnTableName = $request['columnTableName'];
        $foreignKey = $request['foreignKey'];
        $childClassName = '\App\Models' . $request['childClassName'];
        $childTableName = $request['childTableName'];
        $pagePerPage = $request['pagePerPage'];
        unset($request['childTableName']);
        unset($request['childClassName']);
        unset($request['foreignKey']);
        unset($request['columnTableName']);
        unset($request['sortByColumn']);
        unset($request['sortDirection']);
        unset($request['page']);
        unset($request['pagePerPage']);
        $monument = $this->searchQuery($monument, $request, 'Monument');
        $sortDirection = trim($sortDirection, '"');
        $childClassName = str_replace('\\\\', '\\', $childClassName);
        switch ($columnTableName) {
            case 'monument' :
                $monument = $this->getMonumentPagination($monument, $sortDirection, $sortByColumn, 'products', 'amount', $pagePerPage);
                break;
            case 'idInParentTable' :
                $monument = $this->sortByRelatedTable($monument, $childClassName, $sortByColumn, 'monuments', $foreignKey, $sortDirection, $pagePerPage);
                break;
            case 'idInChildTable' :
                $monument = $this->sortByRelationalTable($monument, $childClassName, $sortByColumn, 'monument', $childTableName, 'monument_id', 'monuments', 'id', $sortDirection, $pagePerPage);
                break;
            case 'estimator' :
                $monument = $this->getPriceEstimatorPaginate($monument, $sortDirection, $sortByColumn, $pagePerPage);
                break;
            case 'idInLinkedTable' :
                $monument = $this->priceEstimatorRelatedTable($monument, $childClassName, $sortByColumn, 'monuments', $foreignKey, $sortDirection, $pagePerPage);
                break;
            case 'idInSubTable' :
                $monument = $this->priceEstimatorRelationalTable($monument, $childClassName, $sortByColumn, 'monument', $childTableName, 'monument_id', 'monuments', 'id', $sortDirection, $pagePerPage);
                break;
        }
        return response()->json($monument);
    }

    private function sortByRelatedTable($model, $childClassName, $sortByColumn, $tableName, $foreignKey, $sortDirection, $perPage)
    {
        return $model->with($this->relations)->orderBy(
            $childClassName::select($sortByColumn)
                ->whereColumn('id', $tableName . '.' . $foreignKey)
                ->orderBy($sortByColumn, $sortDirection), $sortDirection
        )
            ->whereNull('price_estimator')
            ->orWhere('price_estimator', '=', '')
            ->paginate($perPage);
    }

    private function sortByRelationalTable($model, $childClassName, $sortByColumn, $parentRelation, $childTableName, $parentForeignId, $parentTable, $id, $sortDirection, $perPage)
    {
        return $model->with($this->relations)->orderBy(
            $childClassName::select($sortByColumn)
                ->with($parentRelation)
                ->whereColumn($childTableName . '.' . $parentForeignId, $parentTable . '.' . $id)
                ->orderBy($sortByColumn, $sortDirection)
                ->limit(1), $sortDirection
        )
            ->whereNull('price_estimator')
            ->orWhere('price_estimator', '=', '')
            ->paginate($perPage);
    }

    private function priceEstimatorRelatedTable($model, $childClassName, $sortByColumn, $tableName, $foreignKey, $sortDirection, $perPage)
    {
        return $model->with($this->relations)->orderBy(
            $childClassName::select($sortByColumn)
                ->whereColumn('id', $tableName . '.' . $foreignKey)
                ->orderBy($sortByColumn, $sortDirection), $sortDirection
        )
            ->whereNotNull('price_estimator')
            ->paginate($perPage);
    }

    private function priceEstimatorRelationalTable($model, $childClassName, $sortByColumn, $parentRelation, $childTableName, $parentForeignId, $parentTable, $id, $sortDirection, $perPage)
    {
        return $model->with($this->relations)->orderBy(
            $childClassName::select($sortByColumn)
                ->with($parentRelation)
                ->whereColumn($childTableName . '.' . $parentForeignId, $parentTable . '.' . $id)
                ->orderBy($sortByColumn, $sortDirection)
                ->limit(1), $sortDirection
        )
            ->whereNotNull('price_estimator')
            ->paginate($perPage);
    }

    public function monumentSearch(AddMonumentRequest $request)
    {
        $monument = new Monument;
        $request = $request->all();
        $monument = $this->searchQuery($monument, $request, 'Monument');
        return $monument->withSum('products', 'amount')->with($this->relations)->whereNull('price_estimator')->orWhere('price_estimator', '=', '')->orderBy('id', 'desc')->get();
    }

    public function toggleComponent(Request $request)
    {
        try {
            $monument = Monument::find($request->id);
            if ($monument[$request->type]) {
                $monument[$request->type]->delete();
            }
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function refineQuery($queryObj)
    {
        if ($queryObj->field->value != '') {
            if ($queryObj->field->operator == '...') {
                $values = explode("...", $queryObj->field->value);
                $queryObj->query = $queryObj->query->whereBetween($queryObj->field->column, [(int)$values[0], (int)$values[1]]);
            } else {
                // If no operator provided, set to equal
                if ($queryObj->field->operator == '') {
                    $queryObj->field->operator = 'like';
                }
                if (is_numeric($queryObj->field->value)) {
                    if ($queryObj->field->operator == 'like')
                        $queryObj->field->operator = '=';
                    elseif ($queryObj->field->operator == 'not like')
                        $queryObj->field->operator = '!=';
                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, +$queryObj->field->value); // (+) here is used for type cast (converting string to int)
                } else if (strlen($queryObj->field->value) > 1 && strtotime($queryObj->field->value)) {
                    if ($queryObj->field->operator == 'like')
                        $queryObj->field->operator = '=';
                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value);
                } else {
                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, "%" . $queryObj->field->value . "%");
                }
            }
        }
        return $queryObj->query;
    }

    public function monumentInfo()
    {
        $colors = ProductColor::select('id', 'color_title')->get();
        $types = ProductType::select('id', 'type_title')->get();
        $sides = ProductSide::select('id', 'side_title')->get();
        $shapes = ProductShape::select('id', 'shape_title')->get();
        $countries = Country::select('id', 'country_title')->get();
        $monumentPolish = MonumentPolish::select('id', 'product_polish_title')->get();
        $costPSqureFeet = CostPSqureFeet::select('id', 'granite_description', 'granite_sq_ft_price')->get();
        return compact('colors', 'types', 'sides', 'shapes', 'countries', 'monumentPolish', 'costPSqureFeet');
    }

    public function deleteFile($id)
    {
        try {
            $file = MonumentFile::findOrFail($id);
            $file_path = "images/monuments/" . $file->file;
            if (file_exists($file_path))
                unlink($file_path);
            return response()->json($file->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteImage($id)
    {
        try {
            $file = MonumentImage::findOrFail($id);
            $file_path = "images/monuments/" . $file->file;
            if (file_exists($file_path))
                unlink($file_path);
            return response()->json($file->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getNextPrevious(Monument $monument)
    {
        return $this->nextPreviousRecord(new Monument, $this->relations, $monument->id);
    }

    public function getDropDown()
    {
        $estimator = request()->estimator;
        if ($estimator == 'monuments') {
            $monument = Monument::select('id', 'product_number')->whereNull('price_estimator')->orWhere('price_estimator', '=', '')->get();
        } elseif ($estimator == 'price-estimator') {
            $monument = Monument::select('id', 'product_number', 'item_name')->whereNotNull('price_estimator')->get();
        }
        return response()->json($monument);

    }

}
