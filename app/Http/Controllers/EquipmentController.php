<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddEquipmentRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Equipment;
use Exception;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public function index()
    {
        $equipment = new Equipment;
        return response()->json($equipment->orderBy('id', 'desc')->get());
    }

    public function paginationRecord()
    {
        $equipment = new Equipment();
        return response()->json($this->getDataWithPagination($equipment, 'id', [], '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $equipment = Equipment::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($equipment);
    }

    public function store(AddEquipmentRequest $request)
    {
        try {

            $equipment = json_decode($request->data, true);
            $equipmentInstance = Equipment::updateOrCreate(['id' => $equipment['id']], $equipment);
            return response()->json($equipmentInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Equipment $equipment)
    {
        return response()->json($equipment);
    }

    public function destroy(Equipment $equipment)
    {
        return $equipment->delete();
    }

    public function getColumns()
    {
        $equipment = new Equipment();
        $equipment = $equipment->getTableColumns();
        $data = [];
        $data['Equipment'] = $equipment;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $equipment = new Equipment;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $equipment = $this->searchQuery($equipment, $request, 'Equipment');
        return response()->json($this->getDataWithPagination($equipment, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
//        return $equipment->orderBy('id', 'desc')->get();
    }

    public function getNext(Equipment $equipment)
    {
        return $this->nextRecord(new Equipment, [], $equipment->id, 'desc');
    }

    public function getPrevious(Equipment $equipment)
    {
        return $this->previousRecord(new Equipment, [], $equipment->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Equipment, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Equipment, [], 'asc');
    }
}
