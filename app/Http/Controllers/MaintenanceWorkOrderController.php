<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\MaintenanceWorkOrder;
use Exception;
use Illuminate\Http\Request;

class MaintenanceWorkOrderController extends Controller
{
    use Accessible, Paginateable, Searchable;

    public function index()
    {
        try {
            $workOrder = new MaintenanceWorkOrder();
            return response()->json($workOrder->get());

        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function paginationRecord()
    {
        $workOrder = new MaintenanceWorkOrder();
        return response()->json($this->getDataWithPagination($workOrder, 'id', [], '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $equipment = MaintenanceWorkOrder::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($equipment);
    }

    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $workOrder = MaintenanceWorkOrder::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($workOrder);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function show(MaintenanceWorkOrder $maintenanceWorkOrder)
    {
        try {
            return response()->json($maintenanceWorkOrder);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function destroy(MaintenanceWorkOrder $maintenanceWorkOrder)
    {
        try {
            return $maintenanceWorkOrder->delete();
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }


    public function maintenanceWorkOrderInfo()
    {
        try {
            $workOrder = new MaintenanceWorkOrder();
            return response()->json($workOrder->get());
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function getColumns()
    {
        try {
            $workOrder = new MaintenanceWorkOrder();
            $workOrder = $workOrder->getTableColumns();
            $data = [];
            $data["MaintenanceWorkOrder"] = $workOrder;
            return response()->json($data);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    function search(Request $request)
    {
        try {
            $workOrder = new MaintenanceWorkOrder();
            $request = $request->all();
            $queryData = json_decode($request['queryData']);
            $queryData = $queryData[0];
            $sortDirection = $queryData->sortDirection;
            $sortByColumn = $queryData->sortByColumn;
            $pagePerPage = $queryData->pagePerPage;
            unset($request['queryData']);
            unset($request['page']);
            $workOrder = $this->searchQuery($workOrder, $request, 'MaintenanceWorkOrder');
            return response()->json($this->getDataWithPagination($workOrder, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function getNext(MaintenanceWorkOrder $workOrder)
    {
        return $this->nextRecord(new MaintenanceWorkOrder, [], $workOrder->id, 'desc');
    }

    public function getPrevious(MaintenanceWorkOrder $workOrder)
    {
        return $this->previousRecord(new MaintenanceWorkOrder, [], $workOrder->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new MaintenanceWorkOrder, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new MaintenanceWorkOrder, [], 'asc');
    }
}
