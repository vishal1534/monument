<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddProductionRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Cemetery;
use App\Models\Collaboration;
use App\Models\CollaborationTask;
use App\Models\Correspondence;
use App\Models\CorrespondenceTask;
use App\Models\Family;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\PaperLocation;
use App\Models\Production;
use App\Models\ProductionInstallation;
use App\Models\ProductionOrder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class ProductionController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['order.installation', 'order.orderStatus', 'order.orderType', 'order.paperLocation', 'order.invoice', 'order.family', 'order.company', 'order.collaboration.tasks',
        'order.correspondence.tasks', 'order.cemetery', 'order.porcelain', 'order.orderInstallation', 'order.memorialProduction', 'order.approvalMonument',
        'order.products.Monument', 'order.products.Service', 'order.products.Simple',
        'order.products.Composite', 'order.products.NonStockProduct',
        'order.products.OrderCompositeProduct.Monument', 'order.products.OrderCompositeProduct.Service', 'order.products.OrderCompositeProduct.Simple',
        'order.products.Composite.compositeProducts.Monument', 'order.products.Composite.compositeProducts.Service', 'order.products.Composite.compositeProducts.Simple'
    ];

    public function index()
    {
        $productions = new Production();
        $productions = $productions->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($productions);
    }

    public function getRecordPagination()
    {
        $production = new Production();
        return response()->json($this->getDataWithPagination($production, 'id', $this->relations, '', '', 'desc'));
    }

    public function customerOrderStatus()
    {
        $production = new Production;
        return $this->getCustomerOrderStatus($production);
    }

    private function getCustomerOrderStatus($production)
    {
        $currentPhoneNumber = Auth::user()->phone_number;
        if (Auth::user()->role->title != $this->userRoleTitle) {
            return $production->with($this->relations)
                ->whereHas('order.family', function ($query) use ($currentPhoneNumber) {
                    $query->where('phone', $currentPhoneNumber);
                })->orderBy('id', 'desc')->get();
        } else {
            return $production->with($this->relations)->orderBy('id', 'desc')->get();
        }

    }

    public function searchCustomerOrderStatus(Request $request)
    {
        $production = new Production;
        $request = $request->all();
        $request = $this->removeParamsFromRequest($request);
        $production = $this->searchQuery($production, $request, 'Production');
        return $this->getCustomerOrderStatus($production);
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

    public function store(AddProductionRequest $request)
    {
        try {
            $data = json_decode($request->data, true);

            $productionInstance = Production::updateOrCreate(['id' => $data['id']], $data);
//            $data['order']['cemetery']['store_id'] = Auth::user()->store_id;
            $cemeteryID = Cemetery::updateOrCreate(['id' => $data['order']['cemetery']['id']], $data['order']['cemetery']);
            $data['order']['cemetery_id'] = $cemeteryID->id;
            $checkOrderStatuschanged = Order::updateOrCreate(['id' => $data['order']['id']], $data['order']);
            Installation::updateOrCreate(['id' => $data['order']['installation']['id']], $data['order']['installation']);
            Invoice::where('invoice_number', $data['order']['invoice']['invoice_number'])->update(['date_promised' => $data['order']['invoice']['date_promised']]);

            if (!empty($data['order']['collaboration']['tasks'])) {
                foreach ($data['order']['collaboration']['tasks'] as $task) {
                    if (count($this->arrayCount($task)) > 0) {
                        $collaborationInstance = Collaboration::find($data['order']['collaboration']['id']);
                        $collaborationTask = CollaborationTask::updateOrCreate(['id' => $task['id']], $task);
                        $collaborationInstance->tasks()->save($collaborationTask);
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

            $productionInstance->save();
            $familyEmail = null;
            $customerContact = null;
            $invoiceNumber = null;
            $collaborationLink = URL::to('/customer-order-status-list');
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
            $productionInstance->load($this->relations);
            return response()->json($productionInstance);
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

    public function show(Production $production)
    {
        $production->load($this->relations);
        return response()->json($production);
    }

    public function destroy(Production $production)
    {

        return $production->delete();
    }

    public function getColumns()
    {

        $production = new Production();
        $production = $production->getTableColumns();
        $order = new Order();
        $order = $order->getTableColumns();
        $invoice = new Invoice();
        $invoice = $invoice->getInvoiceColumn();
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
        $data['production'] = $production;
        $data['order_status'] = $orderStatus;
        $data['order_type'] = $orderType;
        $data['paper_location'] = $paperLocation;
        return response()->json($data);
    }

    public function search(Request $request)
    {

        $production = new Production();
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
        $production = $this->searchQuery($production, $request, 'Production');

        if ($columnTableName == 'production') {
            return response()->json($this->getDataWithPagination($production, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($production, $this->relations, $childClassName, $sortByColumn, 'productions', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($production, $this->relations, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'order', 'productions', 'order_id', 'order_id', $pagePerPage);
        } else if ($columnTableName == 'idNotInChildOrParentTable') {
            return $this->idNotInParentNorChildSort($production, $this->relations, $sortDirection, 'productions', $pagePerPage, $sortByColumn, $childTableName, $foreignKey);
        }
        /*return response()->json($this->getDataWithPagination($production, 'id', $this->relations, '', '', $sortDirection));
        return $production->with($this->relations)->orderBy('id', 'desc')->get();*/
    }

    public function saveCustomText(Request $request)
    {
        $data = json_decode($request->data, true);
        $production = Production::find($data['id']);
        $production->update([$data['columnName'] => $data['valueToSave']]);
        return response()->json($production);
    }

    public function getNext(Production $production)
    {
        return $this->nextRecord(new Production, $this->relations, $production->id, 'desc');
    }

    public function getPrevious(Production $production)
    {
        return $this->previousRecord(new Production, $this->relations, $production->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Production, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Production, $this->relations, 'asc');
    }

    public function getDropDownRecord()
    {
        $production = Production::select('id', 'order_id')
            ->productiondetail()
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($production);
    }
}
