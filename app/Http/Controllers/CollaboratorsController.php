<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Collaborator;
use App\Models\CollaboratorType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollaboratorsController extends Controller
{
    use Searchable, Accessible, Paginateable, FileUpload;

    public $relations = ['type'];

    public function index()
    {
        $records = new Collaborator();
        $records = $records->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($this->getFullName($records));
    }

    private function getFullName($dataObject)
    {
        foreach ($dataObject as $key => $value) {
            $dataObject[$key]['full_name'] = $value->first_name . ' ' . $value->last_name;
        }
        return $dataObject;
    }

    public function paginationRecord()
    {
        $records = new Collaborator();
        $records = $this->getDataWithPagination($records, 'email', $this->relations, '', '', 'asc');
        $items = $records->getCollection();
        $items = $this->getFullName($items);
        $records->setCollection($items);
        return response()->json($records);
    }

    public function dropDownInfo()
    {
        $records = Collaborator::select('id', 'email')
            ->orderBy('email', 'asc')
            ->get();
        return response()->json($records);
    }

    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $validator = Validator::make($data, [
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $recordInstance = Collaborator::updateOrCreate(['id' => $data['id']], $data);

            $recordInstance->save();
            $recordInstance->load($this->relations);
            return response()->json($recordInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Collaborator $collaborator)
    {
        $collaborator->load($this->relations);
        return response()->json($collaborator);
    }

    public function destroy(Collaborator $collaborator)
    {

        return $collaborator->delete();
    }

    public function getColumns()
    {
        $collaborators = new Collaborator();
        $collaboratorsType = new CollaboratorType();
        $collaborators = $collaborators->getTableColumns();
        $collaboratorsType = $collaboratorsType->getTableColumns();

        $data = [];
        array_unshift($collaborators, 'full_name');
        $data['collaborators'] = $collaborators;
        $data['type'] = $collaboratorsType;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $record = new Collaborator();
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
        $collaboration = $this->searchQuery($record, $request, 'Collaborators');
        if ($columnTableName == 'collaborators') {
            $collaboration = $this->getDataWithPagination($collaboration, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInParentTable') {
            $collaboration = $collaboration->with($this->relations)->orderBy(
                $childClassName::select($sortByColumn)
                    ->whereColumn('id', 'collaborators.' . $foreignKey)
                    ->orderBy($sortByColumn, $sortDirection), $sortDirection
            )->paginate($pagePerPage);
        }
        $items = $collaboration->getCollection();
        $items = $this->getFullName($items);
        $collaboration->setCollection($items);
        return response()->json($collaboration);
    }

    public function getCollaboratorType()
    {
        $collaboratorType = new CollaboratorType();
        return response()->json($collaboratorType->select('id', 'title', 'store_id')->orderBy('title', 'asc')->get());
    }

    public function saveCollaboratorType(Request $request)
    {
        $data = json_decode($request->data, true);
        $collaboratorType = CollaboratorType::updateOrCreate(['id' => $data['id']], $data);
        $collaboratorType->save();
        return response()->json($collaboratorType);
    }

    public function deleteCollaboratorType(CollaboratorType $collaboratorType)
    {
        return $collaboratorType->delete();
    }

    public function getNextPrevious(Collaborator $collaborator)
    {
        return $this->nextPreviousRecord(new Collaborator, $this->relations, $collaborator->id);
    }

}
