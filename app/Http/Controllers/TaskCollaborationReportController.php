<?php

namespace App\Http\Controllers;

use App\Http\Traits\Searchable;
use App\Models\CollaborationTask;
use App\Models\CorrespondenceTask;
use Illuminate\Http\Request;

class TaskCollaborationReportController extends Controller
{
    use Searchable;

    public function index()
    {
        $taskCollaboration = new CollaborationTask;
        $taskCollaboration = $taskCollaboration->taskcollaboration()
            ->orderBy(function ($query)
            {
                $query->select('invoice_number')
                    ->from('invoices')
                    ->join('orders',  'invoices.order_id', '=', 'orders.' . 'id')
                    ->join('collaborations', 'orders' . '.id', '=', 'collaborations.' . 'order_id')
                    ->whereColumn('orders.' . 'id', '=',  'invoices.order_id')
                    ->whereColumn('collaborations.' . 'order_id', '=', 'orders' . '.id')
                    ->whereColumn('collaboration_tasks' . '.collaboration_id', '=', 'collaborations.id')
                    ->orderBy('invoice_number', 'asc')
                    ->limit(1);
            }, 'asc')->paginate(10);
        return response()->json($taskCollaboration);
    }

    public function printAllRecord()
    {
        $tasks = CollaborationTask::taskcollaboration()
            ->orderBy('id', 'asc')
            ->get();
        return response()->json($tasks);
    }

    public function printCorrespondenceRecord()
    {
        $tasks = CorrespondenceTask::taskcorrespondence()
            ->orderBy('id', 'asc')
            ->get();
        return response()->json($tasks);
    }

    public function correspondanceTask()
    {
        $tasks = CorrespondenceTask::taskcorrespondence()
            ->orderBy('id', 'asc')
            ->paginate(10);
        return response()->json($tasks);
    }

    public function getColumns()
    {
        $taskCollaboration = new CollaborationTask();
        $taskCollaboration = $taskCollaboration->getTaskCollaborationColumn();
        $invoice = ['invoice_number'];
        $invoice = array_values($invoice);
        $family = ['name_on_stone'];
        $family = array_values($family);
        $department = ['title'];
        $department = array_values($department);
        $data = [];
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['CollaborationTask'] = $taskCollaboration;
        $data['department'] = $department;
        return response()->json($data);

    }

    public function taskColumns()
    {
        $tasks = new CorrespondenceTask();
        $tasks = $tasks->getTaskCorrespondence();
        $invoice = ['invoice_number'];
        $invoice = array_values($invoice);
        $family = ['name_on_stone'];
        $family = array_values($family);
        $data = [];
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['CorrespondenceTask'] = $tasks;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $taskCollaboration = new CollaborationTask;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $foreignKey = $queryData->foreignKey;
        $pagePerPage = $queryData->pagePerPage;
        $childTableName = $queryData->childTableName;
        $type = $queryData->paginateOrGet;
        $childClassName = '\App\Models' . $queryData->childClassName;
        $childClassName = str_replace('\\\\', '\\', $childClassName);
        $request['Collaboration.Order.Invoice'] = $request['Invoice'];
        $request['Collaboration.Order.Family'] = $request['Family'];
        unset($request['queryData']);
        unset($request['page']);
        unset($request['Invoice']);
        unset($request['Family']);
        $taskCollaboration = $this->searchQuery($taskCollaboration, $request, 'CollaborationTask');
        switch ($columnTableName) {
            case 'collaborationTask' :
                $taskCollaboration = $taskCollaboration->taskcollaboration()
                    ->orderBy($sortByColumn, $sortDirection)
                    ->when($type == 'addpaginate', function ($query) use ($pagePerPage) {
                        return $query->paginate($pagePerPage);
                    }, function ($query) {
                        return $query->get();
                    });
                break;
            case 'idInParentTable' :
                $taskCollaboration = $taskCollaboration->taskcollaboration()
                    ->orderBy(
                        $childClassName::select($sortByColumn)
                            ->whereColumn('id', 'collaboration_tasks' . '.' . $foreignKey)
                            ->orderBy($sortByColumn, $sortDirection), $sortDirection
                    )
                    ->when($type == 'addpaginate', function ($query) use ($pagePerPage) {
                        return $query->paginate($pagePerPage);
                    }, function ($query) {
                        return $query->get();
                    });
                break;
            case 'idNotInChildOrParentTable' :
                $taskCollaboration = $taskCollaboration->taskcollaboration()
                    ->orderBy(function ($query)
                    use ($sortDirection, $sortByColumn, $childTableName) {
                        $query->select($sortByColumn)
                            ->from($childTableName)
                            ->join('orders', $childTableName . '.order_id', '=', 'orders.' . 'id')
                            ->join('collaborations', 'orders' . '.id', '=', 'collaborations.' . 'order_id')
                            ->whereColumn('orders.' . 'id', '=', $childTableName . '.order_id')
                            ->whereColumn('collaborations.' . 'order_id', '=', 'orders' . '.id')
                            ->whereColumn('collaboration_tasks' . '.collaboration_id', '=', 'collaborations.id')
                            ->orderBy($sortByColumn, $sortDirection)
                            ->limit(1);
                    }, $sortDirection)
                    ->when($type == 'addpaginate', function ($query) use ($pagePerPage) {
                        return $query->paginate($pagePerPage);
                    }, function ($query) {
                        return $query->get();
                    });
                break;
        }
        return response()->json($taskCollaboration);

    }

    public function taskSearch(Request $request)
    {
        $taskCorrespondance = new CorrespondenceTask;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        $childTableName = $queryData->childTableName;
        $type = $queryData->paginateOrGet;
        $request['Correspondence.Order.Invoice'] = $request['Invoice'];
        $request['Correspondence.Order.Family'] = $request['Family'];
        unset($request['queryData']);
        unset($request['page']);
        unset($request['Invoice']);
        unset($request['Family']);
        $taskCorrespondance = $this->searchQuery($taskCorrespondance, $request, 'CorrespondenceTask');
        switch ($columnTableName) {
            case 'correspondenceTask' :
                $taskCorrespondance = $taskCorrespondance->taskcorrespondence()
                    ->orderBy($sortByColumn, $sortDirection)
                    ->when($type == 'addpaginate', function ($query) use ($pagePerPage) {
                        return $query->paginate($pagePerPage);
                    }, function ($query) {
                        return $query->get();
                    });
                break;
            case 'idNotInChildOrParentTable' :
                $taskCorrespondance = $taskCorrespondance->taskcorrespondence()
                    ->orderBy(function ($query)
                    use ($sortDirection, $sortByColumn, $childTableName) {
                        $query->select($sortByColumn)
                            ->from($childTableName)
                            ->join('orders', $childTableName . '.order_id', '=', 'orders.' . 'id')
                            ->join('correspondences', 'orders' . '.id', '=', 'correspondences.' . 'order_id')
                            ->whereColumn('orders.' . 'id', '=', $childTableName . '.order_id')
                            ->whereColumn('correspondences.' . 'order_id', '=', 'orders' . '.id')
                            ->whereColumn('correspondence_tasks' . '.correspondence_id', '=', 'correspondences.id')
                            ->orderBy($sortByColumn, $sortDirection)
                            ->limit(1);
                    }, $sortDirection)
                    ->when($type == 'addpaginate', function ($query) use ($pagePerPage) {
                        return $query->paginate($pagePerPage);
                    }, function ($query) {
                        return $query->get();
                    });
                break;
        }
        return response()->json($taskCorrespondance);
    }
}
