<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddDepartmentRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Department;
use Exception;

class DepartmentController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public function index()
    {
        $department = new department;
        return response()->json($department->get());
    }

    public function paginationRecord()
    {
        $department = new Department();
        return response()->json($this->getDataWithPagination($department, 'id', [], '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $department = Department::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($department);
    }

    public function departmentInfo()
    {
        if (!$this->isAccessibleorClient(['resource' => 'Setting', 'action' => 'read']))
            return response()->json(["message" => "Sorry, You don't have an access"], 403);
        $department = new Department();
        return response()->json($department->get());
    }

    public function store(AddDepartmentRequest $request)
    {
        try {
            $department = json_decode($request->data, true);
            $departmentInstance = department::updateOrCreate(['id' => $department['id']], $department);
            return response()->json($departmentInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Department $department)
    {
        return response()->json($department);
    }

    public function destroy(Department $department)
    {
        return $department->delete();
    }

    public function getColumns()
    {
        $department = new Department;
        $department = $department->getTableColumns();
        $data = [];
        $data['department'] = $department;
        return response()->json($data);
    }

    public function search(AddDepartmentRequest $request)
    {
        $department = new Department;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $department = $this->searchQuery($department, $request, 'Department');
        return response()->json($this->getDataWithPagination($department, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
    }

    public function getNext(Department $department)
    {
        return $this->nextRecord(new Department, [], $department->id, 'desc');
    }

    public function getPrevious(Department $department)
    {
        return $this->previousRecord(new Department, [], $department->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Department, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Department, [], 'asc');
    }
}
