<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Composite;
use App\Models\Monument;
use App\Models\NonStockProduct;
use App\Models\PoOrder;
use App\Models\PoProduct;
use App\Models\Service;
use App\Models\Simple;
use App\Models\Supplier;
use DB;
use Exception;
use Illuminate\Http\Request;

class PoOrderController extends Controller
{

    use Searchable, Paginateable, Accessible;

    public $relations = ['supplier', 'poProducts.NonStockProduct', 'poProducts.monument.color', 'poProducts.monument.shape', 'poProducts.monument.type', 'poProducts.monument.side', 'poProducts.monument.polish', 'poProducts.monument.specification', 'poProducts.service', 'poProducts.simple',
        'poProducts.composite.compositeProducts.Monument', 'poProducts.Composite.compositeProducts.Service', 'poProducts.Composite.compositeProducts.Simple'];
    public $monumentRelation = ['color', 'shape', 'type', 'side', 'polish', 'specification'];

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchaseOrder = new PoOrder();
        $purchaseOrder = $purchaseOrder->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($purchaseOrder);
    }

    public function paginationRecord()
    {
        $purchaseOrder = new PoOrder();
        return response()->json($this->getDataWithPagination($purchaseOrder, 'id', $this->relations, '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $records = PoOrder::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $productOrder = json_decode($request->data, true);
            $productOrderInstance = PoOrder::updateOrCreate(['id' => $productOrder['id']], $productOrder);
            foreach ($productOrder['po_products'] as $product) {
                $productInstance = PoProduct::updateOrCreate(['id' => $product['id']], $product);
                $productOrderInstance->poProducts()->save($productInstance);
                if (array_key_exists('non_stock_product', $product) && count($product['non_stock_product']) > 0) {

                    $nonStockProduct = NonStockProduct::updateOrCreate(['id' => $product['non_stock_product'][0]['id']], $product['non_stock_product'][0]);
                    $nonStockProduct->poProducts()->sync([$productInstance->id]);
                }
                if (array_key_exists('monument', $product) && count($product['monument']) > 0) {
                    $productInstance->monument()->sync([$product['monument'][0]['id']]);
                }
                if (array_key_exists('service', $product) && count($product['service']) > 0) {
                    $productInstance->service()->sync([$product['service'][0]['id']]);
                }
                if (array_key_exists('simple', $product) && count($product['simple']) > 0) {
                    $productInstance->simple()->sync([$product['simple'][0]['id']]);
                }
                if (array_key_exists('composite', $product) && count($product['composite']) > 0) {
                    $productInstance->composite()->sync([$product['composite'][0]['id']]);
                }
            }
            $productOrderInstance->load($this->relations);
            return response()->json($productOrderInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PoOrder $poOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PoOrder $PoOrder)
    {
        $PoOrder->load($this->relations);
        return response()->json($PoOrder);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\PoOrder $poOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PoOrder $poOrder)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PoOrder $poOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PoOrder $poOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PoOrder $poOrder
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(PoOrder $PoOrder)
    {
        return $PoOrder->delete();
    }

    public function getColumns()
    {
        $purchaseOrder = new PoOrder();
        $supplier = new Supplier();
        $purchaseOrder = $purchaseOrder->getTableColumns();
        $supplier = $supplier->getPOTableColumns();
        $data = [];
        $data['PoOrder'] = $purchaseOrder;
        $data['supplier'] = $supplier;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $purchaseOrder = new PoOrder();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $childTableName = $queryData->childTableName;
        $foreignKey = $queryData->foreignKey;
        $pagePerPage = $queryData->pagePerPage;
        $childClassName = '\App\Models' . $queryData->childClassName;
        $childClassName = str_replace('\\\\', '\\', $childClassName);
        unset($request['queryData']);
        unset($request['page']);
        $purchaseOrder = $this->searchQuery($purchaseOrder, $request, 'PoOrder');
        if ($columnTableName == 'poOrder') {
            return response()->json($this->getDataWithPagination($purchaseOrder, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($purchaseOrder, $this->relations, $childClassName, $sortByColumn, 'po_orders', $foreignKey, $sortDirection, $pagePerPage);
        }
    }

    public function searchProducts(Request $request)
    {
        $keywords = $request->keywords;
        $type = $request->type;
        $type = $type != '' ? $type : 'byNumber';
        try {
            $monument = new Monument();
            $service = new Service();
            $simple = new Simple();
            $composite = new Composite();
            $monument = $monument->with($this->monumentRelation)->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();
            $service = $service->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();
            $simple = $simple->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();
            $composite = $composite->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->with(['compositeProducts.Monument', 'compositeProducts.Service', 'compositeProducts.Simple'])->get();
            $monumentSorted = null;
            $serviceSorted = null;
            $simpleSorted = null;
            $compositeSorted = null;
            if ($type == 'byNumber') {
                $monumentSorted = $this->sortProductAlphaNumeric($monument, 'product_number');
                $serviceSorted = $this->sortProductAlphaNumeric($service, 'product_number');
                $simpleSorted = $this->sortProductAlphaNumeric($simple, 'product_number');
                $compositeSorted = $this->sortProductAlphaNumeric($composite, 'product_number');
            } else {
                $monumentSorted = $this->sortProductAlphaNumeric($monument, 'item_name');
                $serviceSorted = $this->sortProductAlphaNumeric($service, 'item_name');
                $simpleSorted = $this->sortProductAlphaNumeric($simple, 'item_name');
                $compositeSorted = $this->sortProductAlphaNumeric($composite, 'item_name');
            }
            $returnObj = new \stdClass();
            $returnObj->monument = $monument->count() == 0 ? 'No record found' : $monumentSorted;
            $returnObj->service = $service->count() == 0 ? 'No record found' : $serviceSorted;
            $returnObj->simple = $simple->count() == 0 ? 'No record found' : $simpleSorted;
            $returnObj->composite = $composite->count() == 0 ? 'No record found' : $compositeSorted;
            return response()->json($returnObj);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    function updateMonumentInventory(Request $request)
    {
        try {
            $monumentProduct = json_decode($request->data, true);
            $queryUpdated = DB::table('monuments')->where('id', $monumentProduct['poMonumentId'])
                ->increment('total_on_hand', $monumentProduct['poMonumentQuantity']);
            return response()->json($queryUpdated);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }

    }

    public function deleteProduct(PoProduct $product)
    {
        try {
            $product->NonStockProduct()->detach();
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            $product->Composite()->detach();
            return response()->json($product->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getNext(PoOrder $poOrder)
    {
        return $this->nextRecord(new PoOrder, $this->relations, $poOrder->id, 'desc');
    }

    public function getPrevious(PoOrder $poOrder)
    {
        return $this->previousRecord(new PoOrder, $this->relations, $poOrder->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new PoOrder, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new PoOrder, $this->relations, 'asc');
    }
}
