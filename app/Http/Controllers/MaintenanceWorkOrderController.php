<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCollaborationRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Mail\CollaborationMail;
use App\Http\Traits\FileUpload;
use App\Mail\ApprovalMail;
use App\Mail\CustomerViewMail;
use App\Models\CollaboratorMail;
use App\Models\Department;
use App\Models\Family;
use App\Models\MaintenanceWorkOrder;
use App\Models\WorkOrderCollaborationCollaboratorCheck;
use App\Models\WorkOrderCollaborationImage;
use App\Models\WorkOrderCollaborationTask;
use App\Models\WorkOrderCollaborator;
use App\Models\WorkOrderCollaboratorMail;
use App\Models\WorkOrderLog;
use App\Models\WorkOrderProduct;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class MaintenanceWorkOrderController extends Controller
{
    use Accessible, Paginateable, Searchable, FileUpload;
    public $relations = ['tasks', 'collaboratorMail', 'images.user.role', 'images.rejectedBy.role', 'collaborators.type', 'orderLogs.user', 'collaboratorChecks', 'collaboratorChecks.type', 'products'];

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
            $res = $maintenanceWorkOrder->load([
                "tasks",
                "images",
                "collaboratorMail",
                "orderLogs",
                "collaboratorChecks",
                "products"
            ]);

            $all_collabs = WorkOrderCollaborator::all();
            $res["collaborators"] = $all_collabs;
            return response()->json($res);
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

    public function store_data(AddCollaborationRequest $request)
    {
        try {

            $data = $request->all();
            // $data = json_decode($request->data, true);

            $recordInstance = MaintenanceWorkOrder::updateOrCreate(['id' => $data['id']], $data);

            if (isset($data['collaborator_checks']) && !empty($data['collaborator_checks'])) {
                foreach ($data['collaborator_checks'] as $collab) {

                    if (isset($collab['is_custom']) && $collab['is_custom']) {
                        $isCollaborate = $collab['is_check'];
                        Family::where('id', $collab['family_id'])->update(['email_collaborate' => $isCollaborate]);
                    } else {
                        WorkOrderCollaborationCollaboratorCheck::updateOrCreate(
                            [
                                'id' => $collab['id']
                            ],
                            [
                                'work_order_id' => $recordInstance->id,
                                'collaborator_id' => $collab['collaborator_id'],
                                'is_check' => $collab['is_check']
                            ]
                        );
                    }
                }
            }

            $familyEmail = null;
            $customerContact = null;
            $invoiceNumber = null;
            $collaborationLink = URL::to('/customer-order-status-list');
            $customerCollaborationLink = URL::to('/customer-collaboration-list');

            /**
             * Collaboration Tasks............
             */
            $recordInstance = MaintenanceWorkOrder::find($data['id']);
            foreach ($data['tasks'] as $task) {
                $collaborationTask = WorkOrderCollaborationTask::updateOrCreate(['id' => $task['id']], $task);
                $recordInstance->tasks()->save($collaborationTask);

                if (empty($task['id'])) {
                    if (!empty($collaborationTask->assigned_to)) {
                        $this->sendMailForOrderStatusAndTask(
                            $collaborationTask->assigned_to,
                            $customerCollaborationLink,
                            $customerContact,
                            $invoiceNumber,
                            'Work order task collaboration is created. Please check the below link.',
                            'Work Order Task Collaboration is created',
                            'Work Order Task Collaboration'
                        );
                    }
                } else {
                    if (($collaborationTask->assigned_to)) {
                        $this->sendMailForOrderStatusAndTask(
                            $collaborationTask->assigned_to,
                            $customerCollaborationLink,
                            $customerContact,
                            $invoiceNumber,
                            'Work order task collaboration is updated. Please check the below link.',
                            'Work Order Task Collaboration is updated',
                            'Work Order Task Collaboration'
                        );
                    }
                }

                if ($task['id'] == 0 && filter_var($task['assigned_to'], FILTER_VALIDATE_EMAIL)) {
                    $department = Department::find($task['department_id']);
                    $task['department'] = $department;
                    if (!empty($department->notify));
                    $this->sendNotification($department);
                }
            }

            /**
             * Products.........
             */
            foreach ($data['products'] as $product) {
                $collaborationTask = WorkOrderProduct::updateOrCreate(['id' => $product['id']], $product);

                if (empty($product['id'])) {
                    if (!empty($collaborationTask->assigned_to)) {
                        $this->sendMailForOrderStatusAndTask(
                            $collaborationTask->assigned_to,
                            $customerCollaborationLink,
                            $customerContact,
                            $invoiceNumber,
                            'Work order task collaboration is created. Please check the below link.',
                            'Work Order Task Collaboration is created',
                            'Work Order Task Collaboration'
                        );
                    }
                } else {
                    if (($collaborationTask->assigned_to)) {
                        $this->sendMailForOrderStatusAndTask(
                            $collaborationTask->assigned_to,
                            $customerCollaborationLink,
                            $customerContact,
                            $invoiceNumber,
                            'Work order task collaboration is updated. Please check the below link.',
                            'Work Order Task Collaboration is updated',
                            'Work Order Task Collaboration'
                        );
                    }
                }

                if ($product['id'] == 0 && filter_var($product['assigned_to'], FILTER_VALIDATE_EMAIL)) {
                    $department = Department::find($product['department_id']);
                    $product['department'] = $department;
                    if (!empty($department->notify));
                    $this->sendNotification($department);
                }
            }

            $recordInstance->save();
            $recordInstance->load($this->relations);
            $recordInstance->collaborator_checks = $this->filterCollaboratorCheck($recordInstance->id);
            return response()->json($recordInstance);
        } catch (\QueryException $e) {
            return response()->json($e);
        }
    }

    public function sendMail(Request $request)
    {

        try {
            $collaboratorMail = new WorkOrderCollaboratorMail();
            $data = $request->all();
            // $data = json_decode($request->data, true);
            //$obj = $data['sendTo'][0];
            //dd($obj);
            $collaborationID = null;
            $rules = [
                'email' => 'required|email'
            ];
            $params['message'] = $data['message'];
            $params['work_order_id'] = $data['work_order_id'];
            $params['link'] = $data['link'];
            $sentByName = Auth::user()->name;
            $sendDate = Carbon::now();

            if ($params['link']) {
                $work_order_id = Crypt::encryptString($data['work_order_id']);
                $params['redirect_link'] = URL::to('/upload-files/' . $work_order_id);
            }

            foreach ($data['sendTo'] as $user) {
                $collaboratorArray = [];
                $params['name'] = $user['first_name'];
                $validator = Validator::make($user, $rules);

                if ($validator->fails())
                    return response()->json($validator->errors()->all());
                Mail::to($user['email'])->send(new CollaborationMail($params));

                $collaboratorArray['date'] = $sendDate;
                $collaboratorArray['sent_by'] = $sentByName;
                $collaboratorArray['send_to'] = $params['name'];
                $collaboratorArray['content'] = $params['message'];
                $collaboratorArray['attachment'] = $params['link'];
                $collaboratorArray['work_order_id'] = $user['work_order_id'];

                $collaboratorMail::create($collaboratorArray);
            }
            $collaborators = WorkOrderCollaboratorMail::where('work_order_id', $data['work_order_id'])->get();
            return response()->json(['status' => 'sent', 'totalRecords' => $collaborators]);
        } catch (Exception $e) {
            Log::info("Error occur: " . $e->getMessage());
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function sendNotification($department)
    {

        Notification::send($department, new TaskNotification($department));
    }

    public function uploadImage(Request $request)
    {

        try {
            $data = json_decode($request->data, true);
            $collaboration = MaintenanceWorkOrder::find($data['work_order_id']);
            if ($request->hasFile('image_file')) {

                $collaborationImage = new WorkOrderCollaborationImage();
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'maintenanceWorkOrder/';
                $uploadObj->module = 'collaboration';
                $file = $this->upload($uploadObj);
                $collaborationImage->name = $file->filenameWithExt;
                $collaborationImage->uploaded_by = Auth::user()->name;
                $collaborationImage->user_id = Auth::user()->id;
                $collaborationImage->size = $file->size;
                $collaborationImage->path = 'images/' . $uploadObj->path . $file->filenameToStore;
                $collaborationImage->status = $data['uploaded_from'];
                $collaborationImage->sent_mail = 0;

                $collaborationImage->save();
                $collaboration->images()->save($collaborationImage);
                return response()->json($collaborationImage->load(['orderLogs.user']));
            }
        } catch (Exception $e) {
            Log::info("Error occur: " . $e->getMessage());
            // ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function updateImage(Request $request)
    {
        try {
            $data = $request->all();
            // $data = json_decode($request->data, true);
            $collaborationImage = WorkOrderCollaborationImage::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($collaborationImage->load(['user', 'rejectedBy.role', 'orderLogs.user']));
        } catch (Exception $e) {
            Log::info("Error occur: " . $e->getMessage());
            return response()->json($e);
            ProcessException::dispatch($e->getMessage());
        }
    }

    public function sendCustomerViewMail(Request $request)
    {

        try {
            $data = $request->all();
            // $data = json_decode($request->data, true);

            $rules = [
                'email' => 'required|email'
            ];

            $params['message'] = $data['message'];
            $params['work_order_id'] = $data['work_order_id'];
            $params['link'] = $data['link'];

            if ($params['link'])
                $params['redirect_link'] = URL::to($data['link']);

            foreach ($data['sendTo'] as $user) {
                $params['name'] = $user['first_name'];
                $validator = Validator::make($user, $rules);
                if ($validator->fails())
                    return response()->json($validator->errors()->all());
                Mail::to($user['email'])->send(new CustomerViewMail($params));
            }

            return response()->json('sent');
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e->getMessage());
        }
    }

    public function deleteFile(Request $request)
    {
        try {

            $image = WorkOrderCollaborationImage::find($request->id);
            if (!str_contains($image->path, 'approval-monument')) {
                if (file_exists($image->path))
                    unlink($image->path);
            }
            $image->delete();
            return response()->json(WorkOrderLog::orderBy('created_at', 'desc')->with('user')->first());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function sendApprovalMail(Request $request)
    {

        try {
            $data = $request->all();
            // $data = json_decode($request->data, true);
            $currentUserId = Auth::user()->id;
            $work_order_id = $data['work_order_id'];
            $rules = [
                'email' => 'required|email'
            ];

            $params['message'] = $data['message'];
            $params['work_order_id'] = $data['work_order_id'];
            $params['link'] = $data['link'];

            if ($params['link']) {
                if (!isset($data['redirect'])) {
                    $params['redirect_link'] = URL::to($data['link']);
                    $params['mps_collaboration_link'] = URL::to('/maintenanceWorkOrder/' . $work_order_id);
                }
            }
            foreach ($data['sendTo'] as $user) {
                $params['name'] = $user['first_name'];
                $validator = Validator::make($user, $rules);
                if ($validator->fails())
                    return response()->json($validator->errors()->all());
                Mail::to($user['email'])->send(new ApprovalMail($params));
                WorkOrderLog::create([
                    'user_id' => $currentUserId,
                    'work_order_id' => $work_order_id ?? '',
                    'log' => 'Email sent to ' . $user['first_name'],
                    'notes' => $params['message'],
                    'date' => date('m/d/Y', strtotime(now()))
                ]);
            }

            return response()->json('sent');
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e->getMessage());
        }
    }

    private function filterCollaboratorCheck($collaborationId)
    {
        $collaborator = WorkOrderCollaborator::with(['type', 'workOrderCollaborators' => function ($query) use ($collaborationId) {
            $query->where('collaborator_id', $collaborationId);
        }])
            ->get();
        return $collaborator->each(function ($collaborator) {
            if (!isset($collaborator->collaboratorCheck[0])) {
                $collaborator->is_box_checked = 0;
            }
            if (isset($collaborator->collaboratorCheck[0])) {
                $collaborator->is_box_checked = $collaborator->collaboratorCheck[0]['is_check'];
            }
        });
    }

    public function deleteTask(WorkOrderCollaborationTask $task)
    {
        try {
            return response()->json($task->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }
}
