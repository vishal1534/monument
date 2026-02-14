<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddSupplierRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public function index()
    {
        $supplier = new Supplier;
        return response()->json($supplier->orderBy('id', 'desc')->get());
    }

    public function paginationRecord()
    {
        $supplier = new Supplier();
        return response()->json($this->getDataWithPagination($supplier, 'id', [], '', '', 'desc'));
    }

    public function store(AddSupplierRequest $request)
    {
        try {
            $supplier = json_decode($request->data, true);
            $supplierInstance = Supplier::updateOrCreate(['id' => $supplier['id']], $supplier);
            return response()->json($supplierInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Supplier $supplier)
    {
        return response()->json($supplier);
    }

    public function destroy(Supplier $supplier)
    {
        return $supplier->delete();
    }

    public function getColumns()
    {
        $supplier = new Supplier();
        $supplier = $supplier->getTableColumns();
        $data = [];
        $data['Supplier'] = $supplier;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $supplier = new Supplier;
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
        $supplier = $this->searchQuery($supplier, $request, 'Supplier');
        return response()->json($this->getDataWithPagination($supplier, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
    }

    public function getNext(Supplier $supplier)
    {
        return $this->nextRecord(new Supplier, [], $supplier->id, 'desc');
    }

    public function getPrevious(Supplier $supplier)
    {
        return $this->previousRecord(new Supplier, [], $supplier->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Supplier, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Supplier, [], 'asc');
    }

    public function dropDownInfo()
    {
        $records = Supplier::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }
}
