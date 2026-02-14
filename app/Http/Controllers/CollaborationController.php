<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCollaborationRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Helpers;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Mail\ApprovalMail;
use App\Mail\CollaborationMail;
use App\Mail\CustomerViewMail;
use App\Mail\DepartmentMail;
use App\Models\Collaboration;
use App\Models\CollaborationCollaboratorCheck;
use App\Models\CollaborationImage;
use App\Models\CollaborationTask;
use App\Models\Collaborator;
use App\Models\CollaboratorMail;
use App\Models\CollaboratorType;
use App\Models\Correspondence;
use App\Models\CorrespondenceTask;
use App\Models\Department;
use App\Models\Family;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderLog;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\PaperLocation;
use App\Notifications\TaskNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class CollaborationController extends Controller
{
    use Searchable, Paginateable, FileUpload, Helpers, Accessible;

    public $relations = ['tasks', 'collaboratorMail', 'images.user.role', 'images.rejectedBy.role', 'collaborators.type', 'order.family',
        'order.invoice', 'order.company', 'order.collaboration.tasks.department', 'order.correspondence.tasks',
        'order.products.Monument', 'order.products.Service', 'order.products.Simple', 'order.products.NonStockProduct', 'order.department',
        'order.orderStatus', 'order.orderType', 'order.paperLocation', 'orderLogs.user',
        'order.products.Composite.compositeProducts.Monument', 'order.products.OrderCompositeProduct.Monument', 'order.products.OrderCompositeProduct.Service',
        'order.products.OrderCompositeProduct.Simple', 'order.production', 'order.installation',
        'order.products.Composite.compositeProducts.Service', 'order.products.Composite.compositeProducts.Simple'];

    public function index()
    {
        try {
            $records = new Collaboration();
            if ($this->isAccessible(['resource' => 'Collaboration', 'action' => 'mine'])) {

                //$records = $records->with($this->relations)->where('user_id', Auth::user()->id)->get();
                $records = Collaboration::with($this->relations)
                    ->whereHas('order', function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    })
                    ->get();
            } else {

                $records = $records->with($this->relations)->orderBy('id', 'desc')->get();
            }


            return response()->json($records);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getRecordPagination()
    {
        $collaboration = new Collaboration();
        return response()->json($this->getDataWithPagination($collaboration, 'id', $this->relations, '', '', 'desc'));
    }

    public function customerApproval()
    {
        $collaboration = new Collaboration;
        return $this->getCustomerApproval($collaboration);
    }

    private function getCustomerApproval($collaboration)
    {
        $currentPhoneNumber = Auth::user()->phone_number;
        if (Auth::user()->role->title != $this->userRoleTitle) {
            return $collaboration->with($this->relations)
                ->whereHas('order.family', function ($query) use ($currentPhoneNumber) {
                    $query->where('phone', $currentPhoneNumber);
                })->orderBy('id', 'desc')->get();
        } else {
            return $collaboration->with($this->relations)->orderBy('id', 'desc')->get();
        }
    }

    public function searchCustomerApproval(Request $request)
    {
        $collaboration = new Collaboration;
        $request = $request->all();
        $request = $this->removeParamsFromRequest($request);
        $collaboration = $this->searchQuery($collaboration, $request, 'Collaboration');
        return $this->getCustomerApproval($collaboration);
    }

    private function removeParamsFromRequest($data)
    {
        $data['Order.Invoice'] = $data['Invoice'];
        $data['Order.Family'] = $data['Family'];
        $data['Order.Order_Status'] = $data['Order_Status'];
        $data['Order.Order_Type'] = $data['Order_Type'];
        $data['Order.Paper_Location'] = $data['Paper_Location'];
        unset($data['Invoice']);
        unset($data['Family']);
        unset($data['Order_Status']);
        unset($data['Order_Type']);
        unset($data['Paper_Location']);
        return $data;
    }

    public function store(AddCollaborationRequest $request)
    {
        try {

            $data = json_decode($request->data, true);

            $recordInstance = Collaboration::updateOrCreate(['id' => $data['id']], $data);
            $invoiceDetail = $data['order']['invoice'];
            $checkOrderStatuschanged = Order::updateOrCreate(['id' => $data['order']['id']], $data['order']);
            if (isset($data['order_logs']) && !empty($data['order_logs'])) {
                foreach ($data['order_logs'] as $orderLog) {
                    OrderLog::updateOrCreate(['id' => $orderLog['id']], $orderLog);
                }
            }
            if (isset($data['collaborators']) && !empty($data['collaborators'])) {
                foreach ($data['collaborators'] as $collab) {
                    if (isset($collab['id']) && !empty($collab['id'])) {
                        $createCollaborator = null;
                        $createCollaborator = Collaborator::updateOrCreate(['id' => $collab['id']], $collab);
                        $id = 0;
                        if (isset($collab['collaborator_check']) && !empty($collab['collaborator_check'])) {
                            $id = $collab['collaborator_check'][0]['id'];
                        }
                        CollaborationCollaboratorCheck::updateOrCreate(
                            [
                                'id' => $id
                            ],
                            [
                                'collaboration_id' => $recordInstance->id,
                                'collaborator_id' => $createCollaborator->id,
                                'is_check' => $collab['is_box_checked']
                            ]);
                    }
                    elseif (isset($collab['is_custom']) && $collab['is_custom']){
                        $isCollaborate = $collab['is_box_checked'];
                        Family::where('id',$collab['family_id'])->update(['email_collaborate'=>$isCollaborate]);
                    }
                }
            }
            $familyEmail = null;
            $customerContact = null;
            $invoiceNumber = null;
            $collaborationLink = URL::to('/customer-order-status-list');
            $customerCollaborationLink = URL::to('/customer-collaboration-list');
//            $collaborationLink = URL::to('/collaboration/'.$data['order']['collaboration']['id']);
            if (isset($data['order']['family']) && isset($data['order']['family']['email'])
                && filter_var($data['order']['family']['email'], FILTER_VALIDATE_EMAIL)) {
                $familyEmail = $data['order']['family']['email'];
                $customerContact = $data['order']['family']['contact'];
                $invoiceNumber = $data['order']['invoice']['invoice_number'];
            }
            if ($checkOrderStatuschanged->wasChanged('order_status_id')) {
                if (!empty($familyEmail) && isset($data['order']['family']['update_customer'])) {
                    $this->sendMailForOrderStatusAndTask($familyEmail, $collaborationLink, $customerContact, $invoiceNumber,
                        'Your order status is changed. Please check the below link.',
                        'Order status is updated', 'Order status');
                }
            }
            $invoice = Invoice::where('invoice_number', $invoiceDetail['invoice_number'])->update(['date_promised' => $invoiceDetail['date_promised']]);
            if (!empty($data['order']['collaboration']['tasks'])) {
                foreach ($data['order']['collaboration']['tasks'] as $task) {
                    if (count($this->arrayCount($task)) > 0) {
                        $recordInstance = Collaboration::find($data['order']['collaboration']['id']);
                        $collaborationTask = CollaborationTask::updateOrCreate(['id' => $task['id']], $task);
                        $recordInstance->tasks()->save($collaborationTask);
                        if ($collaborationTask->wasChanged('assigned_to')) {
                            if (!empty($familyEmail) && ($collaborationTask->assigned_to == $familyEmail)) {
                                $this->sendMailForOrderStatusAndTask($familyEmail, $customerCollaborationLink, $customerContact, $invoiceNumber,
                                    'Task Collaboration is updated. Please check the below link.',
                                    'Task Collaboration is updated', 'Task Collaboration');
                            }
                        } else if (empty($task['id'])) {
                            if (!empty($familyEmail) && ($collaborationTask->assigned_to == $familyEmail)) {
                                $this->sendMailForOrderStatusAndTask($familyEmail, $customerCollaborationLink, $customerContact, $invoiceNumber,
                                    'Task Collaboration is created. Please check the below link.',
                                    'Task Collaboration is created', 'Task Collaboration');
                            }
                        }
                        if ($task['id'] == 0 && filter_var($task['assigned_to'], FILTER_VALIDATE_EMAIL)) {
                            $task['order'] = $data['order']['id'];
                            $department = Department::find($task['department_id']);
                            $task['department'] = $department;
                            if (!empty($department->notify)) ;
                            $this->sendNotification($department);
                        }
                    }
                }
            }
            if (!empty($data['order']['correspondence']['tasks'])) {
                foreach ($data['order']['correspondence']['tasks'] as $task) {
                    if (count($this->arrayCount($task)) > 0) {
                        $correspondenceInstance = Correspondence::find($data['order']['correspondence']['id']);
                        $correspondenceTask = CorrespondenceTask::updateOrCreate(['id' => $task['id']], $task);
                        $correspondenceInstance->tasks()->save($correspondenceTask);
                    }
                }
            }

            $recordInstance->save();
            $recordInstance->load($this->relations);
            $recordInstance->collaborator_checks = $this->filterCollaboratorCheck($recordInstance->id);
            return response()->json($recordInstance);
        } catch (QueryException $e) {
            return response()->json($e);
        }
    }

    /*private function sendMailForOrderStatusAndTask($familyEmail, $collaborationLink, $customerContact, $invoiceNumber, $message, $messageOne, $messageTwo)
    {
        $taskParam['mps_collaboration_link'] = $collaborationLink;
        $taskParam['name'] = $customerContact;
        $taskParam['order'] = $invoiceNumber;
        $taskParam['message'] = $message;
        $taskParam['message_one'] = $messageOne;
        $taskParam['message_two'] = $messageTwo;
        Mail::to($familyEmail)->send(new OrderStatusUpdated($taskParam));
    }*/

    public function sendNotification($department)
    {

        Notification::send($department, new TaskNotification($department));

    }

    private function filterCollaboratorCheck($collaborationId)
    {
        $collaborator = Collaborator::with(['type', 'collaboratorCheck' => function ($query) use ($collaborationId) {
            $query->where('collaboration_id', $collaborationId);
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

    public function show(Collaboration $collaboration)
    {
        if (($this->isAccessible(['resource' => 'Collaboration', 'action' => 'mine']) && $collaboration->order->user_id != Auth::user()->id))
            return response()->json(["message" => "Sorry, You don't have an access"], 403);

        $collaboration->load($this->relations);
        $collaboration->collaborator_checks = $this->filterCollaboratorCheck($collaboration->id);
        return response()->json($collaboration);
    }

    public function deleteLogs(Request $request)
    {
        $data = json_decode($request->data, true);
        OrderLog::whereCollaborationIdAndId($data['collaboration'], $data['logToDelete'])->delete();
        return response()->json(["success" => ["Order Log deleted"]], 200);
    }

    public function destroy(Collaboration $collaboration)
    {

        return $collaboration->delete();
    }

    public function getColumns()
    {

        $collaboration = new Collaboration();
        $invoice = new Invoice();
        $collaboration = $collaboration->getTableColumns();
        $invoice = $invoice->getTableColumns();
        $order = new Order();
        $order = $order->getCollabColumns();
        $family = new Family();
        $family = $family->getOrderFamilyColumns();
        $orderStatus = new OrderStatus();
        $orderStatus = $orderStatus->getOrderStatusColumn();
        $orderType = new OrderType();
        $orderType = $orderType->getTableColumn();
        $paperLocation = new PaperLocation();
        $paperLocation = $paperLocation->getTableColumns();

        $data = [];
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['order'] = $order;
        $data['collaboration'] = $collaboration;
        $data['order_status'] = $orderStatus;
        $data['order_type'] = $orderType;
        $data['paper_location'] = $paperLocation;
        return response()->json($data);
    }

    public function search(Request $request)
    {

        $record = new Collaboration;
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
        $request = $this->removeParamsFromRequest($request);
        $record = $this->searchQuery($record, $request, 'Collaboration');

        if ($columnTableName == 'collaboration') {
            return response()->json($this->getDataWithPagination($record, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($record, $this->relations, $childClassName, $sortByColumn, 'collaborations', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($record, $this->relations, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'order', 'collaborations', 'order_id', 'order_id', $pagePerPage);
        } else if ($columnTableName == 'idNotInChildOrParentTable') {
            return $this->idNotInParentNorChildSort($record, $this->relations, $sortDirection, 'collaborations', $pagePerPage, $sortByColumn, $childTableName, $foreignKey);
        }

        return response()->json($this->getDataWithPagination($record, 'id', $this->relations, '', '', $sortDirection, $pagePerPage));

        if ($this->isAccessible(['resource' => 'Collaboration', 'action' => 'mine'])) {

            //$records = $records->with($this->relations)->where('user_id', Auth::user()->id)->get();
            $record = $this->searchQuery($record, $request, 'Collaboration');
            return $record->with($this->relations)
                ->whereHas('order', function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
                ->get();
        } else {

            $record = $this->searchQuery($record, $request, 'Collaboration');
            return $record->with($this->relations)->orderBy('id', 'desc')->get();
        }

    }

    public function deleteTask(CollaborationTask $task)
    {
        try {

            return response()->json($task->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function collaboratorTypes()
    {
        $collaboratorType = new CollaboratorType();
        $collaborator = new Collaborator();
        $collaboratorType = $collaboratorType->orderBy('id', 'desc')->get();
        $collaborator = $collaborator->with('type')->get();
        return compact('collaboratorType', 'collaborator');
    }

    public function getCollaboratorTypes(Request $request)
    {
        $request = $request->all();
        $collaborationId = $request['collaboration_id'];
        $collaboratorType = new CollaboratorType();
        $collaboratorType = $collaboratorType->orderBy('id', 'desc')->get();
        $collaborator = $this->filterCollaboratorCheck($collaborationId);
        return compact('collaboratorType', 'collaborator');
    }

    public function saveCollaborator(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $validator = Validator::make($data, [
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $collaboration = Collaboration::find($data['collaboration_id']);
            $collaboratorType = CollaboratorType::find($data['type_id']);

            $collaborator = Collaborator::updateOrCreate(['id' => $data['id']], $data);
            $collaboratorType->collaborators()->save($collaborator);
            $collaboration->collaborators()->save($collaborator);

            $collaborator->load(['type']);
            return response()->json($collaborator);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function mobileUploadImage(Request $request)
    {
        try {
            $data = $request->all();
            $collaboration = Collaboration::find($data['id']);
            $filename = md5($data['filename'] . time());
            //  Image Upload
            $base64_string = $data["image"];
            $outputfile = storage_path("app/public/collaboration/" . $filename . ".png");
            $filehandler = fopen($outputfile, 'wb');
            fwrite($filehandler, base64_decode($base64_string));
            fclose($filehandler);
            // Image Upload Ends
            $collaborationImage = new CollaborationImage();
            $collaborationImage->name = $filename;
//            $collaborationImage->size = $file->size;
            $collaborationImage->path = 'images/collaboration/' . $filename . '.png';
            $collaborationImage->status = "uploads";
            $collaborationImage->sent_mail = 0;
            $collaborationImage->save();
            $collaboration->images()->save($collaborationImage);

            return response()->json("success");

        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function uploadImage(Request $request)
    {

        try {
            $data = json_decode($request->data, true);
            $collaboration = Collaboration::find($data['collaboration']);
            if ($request->hasFile('image_file')) {

                $collaborationImage = new CollaborationImage();
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'collaboration/';
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
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }

    }

    public function updateImage(Request $request)
    {
        try {

            $data = json_decode($request->data, true);

            $collaborationImage = CollaborationImage::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($collaborationImage->load(['user', 'rejectedBy.role', 'orderLogs.user']));

        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteFile(Request $request)
    {
        try {

            $image = CollaborationImage::find($request->id);
            if (!str_contains($image->path, 'approval-monument')) {
                if (file_exists($image->path))
                    unlink($image->path);
            }
            $image->delete();
            return response()->json(OrderLog::orderBy('created_at', 'desc')->with('user')->first());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function sendMail(Request $request)
    {

        try {
            $collaboratorMail = new CollaboratorMail();
            $data = json_decode($request->data, true);
            //$obj = $data['sendTo'][0];
            //dd($obj);
            $collaborationID = null;
            $rules = [
                'email' => 'required|email'
            ];

            $params['message'] = $data['message'];
            $params['order'] = $data['order'];
            $params['link'] = $data['link'];
            $sentByName = Auth::user()->name;
            $sendDate = Carbon::now();

            if ($params['link']) {
                $collaborationID = Crypt::encryptString($data['collaboration']);
                $params['redirect_link'] = URL::to('/upload-files/' . $collaborationID);
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
                $collaboratorArray['collaboration_id'] = $user['collaboration_id'];

                $collaboratorMail::create($collaboratorArray);
            }
            $collaborators = CollaboratorMail::where('collaboration_id', $data['collaboration'])->get();
            return response()->json(['status' => 'sent', 'totalRecords' => $collaborators]);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e->getMessage());
        }

    }

    public function sendApprovalMail(Request $request)
    {

        try {
            $data = json_decode($request->data, true);
            $currentUserId = Auth::user()->id;
            $collaborationID = $data['collaboration'];
            $rules = [
                'email' => 'required|email'
            ];

            $params['message'] = $data['message'];
            $params['order'] = $data['order'];
            $params['link'] = $data['link'];

            if ($params['link']) {
                if (!isset($data['redirect'])) {
                    $params['redirect_link'] = URL::to($data['link']);
                    $params['mps_collaboration_link'] = URL::to('/collaboration/' . $collaborationID);
                }
            }
            foreach ($data['sendTo'] as $user) {
                $params['name'] = $user['first_name'];
                $validator = Validator::make($user, $rules);
                if ($validator->fails())
                    return response()->json($validator->errors()->all());
                Mail::to($user['email'])->send(new ApprovalMail($params));
                OrderLog::create([
                    'user_id' => $currentUserId,
                    'collaboration_id' => $collaborationID ?? '',
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

    public function sendCustomerViewMail(Request $request)
    {

        try {
            $data = json_decode($request->data, true);

            $rules = [
                'email' => 'required|email'
            ];

            $params['message'] = $data['message'];
            $params['order'] = $data['order'];
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

    public function sendDepartmentMail($data)
    {

        try {
            $params['message'] = $data['task'];
            $params['order'] = $data['order'];
            $params['name'] = $data['assigned_to'];
            Mail::to($data['assigned_to'])->send(new DepartmentMail($params));
            return response()->json('sent');
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e->getMessage());
        }

    }

    public function encodeDecodeData(Request $request)
    {
        $data = json_decode($request->data, true);

        if ($data['type'] == 'encrypt')
            $str = Crypt::encryptString($data['str']);
        else
            $str = Crypt::decryptString($data['str']);

        return $str;
    }

    public function getNext(Collaboration $collaboration)
    {
        $collaboration = Collaboration::with($this->relations)->where('id', '<', $collaboration->id)->orderBy('id', 'desc')->first();
        $collaboration->collaborator_checks = $this->filterCollaboratorCheck($collaboration->id);
        return response()->json($collaboration);
    }

    public function getPrevious(Collaboration $collaboration)
    {
        $collaboration = Collaboration::with($this->relations)->where('id', '>', $collaboration->id)->first();
        $collaboration->collaborator_checks = $this->filterCollaboratorCheck($collaboration->id);
        return response()->json($collaboration);
    }

    public function getFirst()
    {
        $collaboration = Collaboration::with($this->relations)->orderBy('id', 'desc')->first();
        $collaboration->collaborator_checks = $this->filterCollaboratorCheck($collaboration->id);
        return response()->json($collaboration);
    }

    public function getLast()
    {
        $collaboration = Collaboration::with($this->relations)->orderBy('id', 'asc')->first();
        $collaboration->collaborator_checks = $this->filterCollaboratorCheck($collaboration->id);
        return response()->json($collaboration);
    }

    public function getDropDownRecord()
    {
        $collaboration = Collaboration::select('id', 'order_id')
            ->collaborationdetail()
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($collaboration);
    }
}
