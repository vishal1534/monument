<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddProductionSandblastRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Order;
use App\Models\ProductionSandblast;
use App\Models\ProductionSandblastList;
use Exception;
use Illuminate\Http\Request;

class ProductionSandblastingController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['sandblastList.order.invoice', 'sandblastList.order.family'];

    public function index()
    {
        $productionSandblasts = new ProductionSandblast();
        $productionSandblasts = $productionSandblasts->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($productionSandblasts);
    }

    public function paginationRecord()
    {
        $records = new ProductionSandblast();
        return response()->json($this->getDataWithPagination($records, 'id', $this->relations, '', '', 'desc'));
    }

    public function jwtStore(AddProductionSandblastRequest $request)
    {
        try {
            $data = $request->all();
            $recordInstance = ProductionSandblast::updateOrCreate(['id' => $data['id']], $data);
            $data['sandblasting_id'] = $recordInstance->id;
            $sandblastInstance = ProductionSandblastList::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($sandblastInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function store(AddProductionSandblastRequest $request)
    {

        try {
            $data = json_decode($request->data, true);
            $recordInstance = ProductionSandblast::updateOrCreate(['id' => $data['id']], $data);
            $entries = 0;

            if (count($data['sandblast_list']) > 0) {
                foreach ($data['sandblast_list'] as $sandblast) {
                    if (count($this->arrayCount($sandblast)) > 0) {
                        $entries++;
                        $sandblastInstance = ProductionSandblastList::updateOrCreate(['id' => $sandblast['id']], $sandblast);
                        $recordInstance->sandblastList()->save($sandblastInstance);
                    }
                }
            }

            $recordInstance->total_entries = $entries;
            $recordInstance->save();
            $recordInstance->load($this->relations);
            return response()->json($recordInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != null;
        });
        return $arrCount;
    }

    public function show($id)
    {
        $productionSandblast = ProductionSandblast::with($this->relations)->find($id);
        $productionSandblast->load($this->relations);
        return response()->json($productionSandblast);
    }

    public function destroy($id)
    {
        $productionSandblast = ProductionSandblast::find($id);
        foreach ($productionSandblast->sandblastList as $item) {
            $item->delete();
        }
        return $productionSandblast->delete();
    }

    public function getColumns()
    {
        $productionSandblast = new ProductionSandblast();
        $data = [];
        $data['Production Sandblast'] = $productionSandblast->getTableColumns();
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $productionSandblast = new ProductionSandblast;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $productionSandblast = $this->searchQuery($productionSandblast, $request, 'ProductionSandblast');
        return response()->json($this->getDataWithPagination($productionSandblast, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
//        return $productionSandblast->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function sandBlastingOrder()
    {
        return $this->productionOrder();
    }

    public function dropDownInfo()
    {
        $records = ProductionSandblast::select('id', 'week_of')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function getNext(ProductionSandblast $sandblast)
    {
        return $this->nextRecord(new ProductionSandblast, $this->relations, $sandblast->id, 'desc');
    }

    public function getPrevious(ProductionSandblast $sandblast)
    {
        return $this->previousRecord(new ProductionSandblast, $this->relations, $sandblast->id);
    }


    public function getFirst()
    {
        return $this->firstRecord(new ProductionSandblast, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new ProductionSandblast, $this->relations, 'asc');
    }
}
