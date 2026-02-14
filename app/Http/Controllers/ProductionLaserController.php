<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddProductionLaserRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\ProductionLaser;
use App\Models\ProductionLaserList;
use Exception;
use Illuminate\Http\Request;

class ProductionLaserController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['laserList.order.invoice', 'laserList.order.family'];

    public function index()
    {
        $productionLasers = new ProductionLaser();
        $productionLasers = $productionLasers->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($productionLasers);
    }

    public function paginationRecord()
    {
        $records = new ProductionLaser();
        return response()->json($this->getDataWithPagination($records, 'id', $this->relations, '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $records = ProductionLaser::select('id', 'week_of')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function laserOrder()
    {
        return $this->productionOrder();
    }

    public function jwtStore(AddProductionLaserRequest $request)
    {
        try {
            $data = $request->all();
            $recordInstance = ProductionLaser::updateOrCreate(['id' => $data['id']], $data);
            $data['laser_id'] = $recordInstance->id;
            $laserInstance = ProductionLaserList::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($laserInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function store(AddProductionLaserRequest $request)
    {
        try {
            $data = json_decode($request->data, true);

            $recordInstance = ProductionLaser::updateOrCreate(['id' => $data['id']], $data);
            $entries = 0;

            if (count($data['laser_list']) > 0) {
                foreach ($data['laser_list'] as $laser) {

                    if (count($this->arrayCount($laser)) > 0) {
                        $entries++;
                        $laserInstance = ProductionLaserList::updateOrCreate(['id' => $laser['id']], $laser);
                        $recordInstance->laserList()->save($laserInstance);
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
        $productionLaser = ProductionLaser::with($this->relations)->find($id);
        $productionLaser->load($this->relations);
        return response()->json($productionLaser);
    }

    public function destroy($id)
    {
        $productionLaser = ProductionLaser::find($id);

        foreach ($productionLaser->laserList as $item) {
            $item->delete();
        }

        return $productionLaser->delete();
    }

    public function getColumns()
    {
        $productionLaser = new ProductionLaser();

        $data = [];
        $data['Production Laser'] = $productionLaser->getTableColumns();
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $productionLaser = new ProductionLaser;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $productionLaser = $this->searchQuery($productionLaser, $request, 'ProductionLaser');
        return response()->json($this->getDataWithPagination($productionLaser, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
    }

    public function getNext(ProductionLaser $laser)
    {
        return $this->nextRecord(new ProductionLaser, $this->relations, $laser->id, 'desc');
    }

    public function getPrevious(ProductionLaser $laser)
    {
        return $this->previousRecord(new ProductionLaser, $this->relations, $laser->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new ProductionLaser, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new ProductionLaser, $this->relations, 'asc');
    }
}
