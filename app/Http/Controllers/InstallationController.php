<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddInstallationRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Cemetery;
use App\Models\Family;
use App\Models\FoundationDepth;
use App\Models\Installation;
use App\Models\InstallationCheckList;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\PaperLocation;
use App\Models\VaseDirection;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class InstallationController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['order.invoice', 'order.invoice.payments', 'order.family', 'order.company', 'order.orderStatus', 'order.cemetery',
        'order.production', 'order.installation', 'order.paperLocation',
        'order.collaboration.tasks', 'order.correspondence.tasks', 'order.cemetery', 'foundationDepth', 'order.orderType',
        'order.products.Monument', 'order.products.Service', 'order.products.Simple', 'order.products.Composite',
        'order.products.NonStockProduct',
        'order.products.OrderCompositeProduct.Monument', 'order.products.OrderCompositeProduct.Service', 'order.products.OrderCompositeProduct.Simple',
        'order.products.Composite.compositeProducts.Monument', 'order.products.Composite.compositeProducts.Service', 'order.products.Composite.compositeProducts.Simple',
        'checkList', 'vaseDirection', 'order.collaboration', 'order.collaboration.images'];

    public function index()
    {

        $installations = new Installation();
        $installations = $installations->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($installations);
    }

    public function getRecordPagination()
    {
        $installation = new Installation();
        return response()->json($this->getDataWithPagination($installation, 'id', $this->relations, '', '', 'desc'));
    }

    public function store(AddInstallationRequest $request)
    {
        try {

            $data = json_decode($request->data, true);

            $installationInstance = Installation::updateOrCreate(['id' => $data['id']], $data);
//            $data['order']['cemetery']['store_id'] = Auth::user()->store_id;
            $cemeteryID = Cemetery::updateOrCreate(['id' => $data['order']['cemetery']['id']], $data['order']['cemetery']);
            $data['order']['cemetery_id'] = $cemeteryID->id;
            $checkOrderStatuschanged = Order::updateOrCreate(['id' => $data['order']['id']], $data['order']);
            Invoice::updateOrCreate(['invoice_number' => $data['order']['invoice']['invoice_number']], $data['order']['invoice']);
            $checkList = InstallationCheckList::updateOrCreate(['id' => $data['check_list']['id']], $data['check_list']);

            $fileObj = new \stdClass();
            if ($request->hasFile('installing_area_image_file')) {
                $fileObj->request = $request;
                $fileObj->name = 'installing_area_image_file';
                $checkList->installing_area_image = $this->getFile($fileObj);
                $this->linkInstallationUploadsToCollaboration($data, $request, 'installing area', $fileObj->name);
            }
            if ($request->hasFile('before_pouring_concrete_image_file')) {
                $fileObj->request = $request;
                $fileObj->name = 'before_pouring_concrete_image_file';
                $checkList->before_pouring_concrete_image = $this->getFile($fileObj);
                $this->linkInstallationUploadsToCollaboration($data, $request, 'before pouring concrete', $fileObj->name);
            }
            if ($request->hasFile('after_pouring_concrete_image_file')) {
                $fileObj->request = $request;
                $fileObj->name = 'after_pouring_concrete_image_file';
                $checkList->after_pouring_concrete_image = $this->getFile($fileObj);
                $this->linkInstallationUploadsToCollaboration($data, $request, 'after pouring concrete', $fileObj->name);
            }
            if ($request->hasFile('finished_installed_image_file')) {
                $fileObj->request = $request;
                $fileObj->name = 'finished_installed_image_file';
                $checkList->finished_installed_image = $this->getFile($fileObj);
                $this->linkInstallationUploadsToCollaboration($data, $request, 'finished installed', $fileObj->name);
            }
            if ($request->hasFile('damaged_grave_image_file')) {
                $fileObj->request = $request;
                $fileObj->name = 'damaged_grave_image_file';
                $checkList->damaged_grave_image = $this->getFile($fileObj);
                $this->linkInstallationUploadsToCollaboration($data, $request, 'damaged grave', $fileObj->name);
            }
            $checkList->save();
            $installationInstance->save();
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
            $installationInstance->load($this->relations);
            return response()->json($installationInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getFile($file)
    {
        $uploadObj = new \stdClass();
        $uploadObj->file = $file->request->file($file->name);
        $uploadObj->path = 'installation/';
        $uploadObj->module = 'installation';
        $file = $this->upload($uploadObj);
        $file = $uploadObj->path . $file->filenameToStore;
        return $file;
    }

    public function show(Installation $installation)
    {

        $installation->load($this->relations);
        return response()->json($installation);
    }

    public function destroy(Installation $installation)
    {

        return $installation->delete();
    }

    public function getColumns()
    {

        $installation = new Installation();
        $installation = $installation->getTableColumns();
        $order = new Order();
        $order = $order->getCollabColumns();
        $invoice = new Invoice();
        $invoice = $invoice->getTableColumns();
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
        $data['installation'] = $installation;
        $data['order_status'] = $orderStatus;
        $data['order_type'] = $orderType;
        $data['paper_location'] = $paperLocation;
        return response()->json($data);
    }

    public function search(Request $request)
    {

        $installation = new Installation();
        $request = $request->all();
        $request['Order.Invoice'] = $request['Invoice'];
        $request['Order.Family'] = $request['Family'];
        $request['Order.Order_Status'] = $request['Order_Status'];
        $request['Order.Order_Type'] = $request['Order_Type'];
        $request['Order.Paper_Location'] = $request['Paper_Location'];
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
        unset($request['Invoice']);
        unset($request['Family']);
        unset($request['Order_Status']);
        unset($request['Order_Type']);
        unset($request['Paper_Location']);
        unset($request['page']);
        $installation = $this->searchQuery($installation, $request, 'Installation');

        if ($columnTableName == 'installation') {
            return response()->json($this->getDataWithPagination($installation, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($installation, $this->relations, $childClassName, $sortByColumn, 'installations', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($installation, $this->relations, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'order', 'installations', 'order_id', 'order_id', $pagePerPage);
        } else if ($columnTableName == 'idNotInChildOrParentTable') {
            return $this->idNotInParentNorChildSort($installation, $this->relations, $sortDirection, 'installations', $pagePerPage, $sortByColumn, $childTableName, $foreignKey);
        }

        return response()->json($this->getDataWithPagination($installation, 'id', $this->relations, '', '', $sortDirection, $pagePerPage));
        return $installation->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != 0 && $item != null;
        });
        return $arrCount;
    }

    /**
     * Installation Forms
     */

    public function getCheckList(Installation $installation)
    {
        $installation->load(['checkList']);
        return response()->json($installation);
    }

    public function saveCheckList(Request $request)
    {
        try {

            $data = json_decode($request->data, true);

            $brickInstance = Brick::updateOrCreate(['id' => $data['id']], $data);

            $brickInstance->save();
            return response()->json($brickInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteCheckList(Installation $installation)
    {

        return $installation->checkList->delete();
    }

    public function getVaseDirection()
    {
        $vaseDirection = new VaseDirection();
        return response()->json($vaseDirection->orderBy('direction', 'asc')->get());
    }

    public function getFoundationDepth()
    {
        $foundationDepth = new FoundationDepth();
        return response()->json($foundationDepth->orderBy('depth', 'asc')->get());
    }

    public function saveVaseDirection(Request $request)
    {

        $data = json_decode($request->data, true);
        $vaseDirection = VaseDirection::updateOrCreate(['id' => $data['id']], $data);
        $vaseDirection->save();
        return response()->json($vaseDirection);
    }

    public function deleteVaseDirection(VaseDirection $vaseDirection)
    {
        return $vaseDirection->delete();
    }

    public function deleteFoundationDepth(FoundationDepth $foundationDepth)
    {
        return $foundationDepth->delete();
    }

    public function saveFoundationDepth(Request $request)
    {

        $data = json_decode($request->data, true);
        $foundationDepth = FoundationDepth::updateOrCreate(['id' => $data['id']], $data);
        $foundationDepth->save();
        return response()->json($foundationDepth);
    }

    public function saveInstallCustomText(Request $request)
    {
        $data = json_decode($request->data, true);
        $installation = Installation::find($data['id']);
        $installation->update([$data['columnName'] => $data['valueToSave']]);
        return response()->json($installation);
    }

    public function getDropDownRecord()
    {
        $installation = Installation::select('id', 'order_id')
            ->installationdetail()
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($installation);
    }

    public function first()
    {
        return $this->firstRecord(new Installation, $this->relations, 'desc');
    }

    public function last()
    {
        return $this->lastRecord(new Installation, $this->relations, 'asc');
    }

    public function next(Installation $installation)
    {
        return $this->nextRecord(new Installation, $this->relations, $installation->id, 'desc');
    }

    public function previous(Installation $installation)
    {
        return $this->previousRecord(new Installation, $this->relations, $installation->id);
    }
}
