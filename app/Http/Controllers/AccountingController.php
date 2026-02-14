<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddAccountingRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Accounting;
use App\Models\Family;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderType;
use Exception;

class AccountingController extends Controller
{


    use Searchable, Paginateable, Accessible;

    public $relation = ['order.invoice.payments', 'order.family', 'order.company', 'order.cemetery.city', 'order.cemetery.county', 'order.orderStatus', 'order.orderType',
        'order.products.Monument', 'order.products.Service', 'order.products.Simple',
        'order.products.OrderCompositeProduct.Monument', 'order.products.OrderCompositeProduct.Service', 'order.products.OrderCompositeProduct.Simple',
        'order.products.NonStockProduct', 'order.products.Composite.compositeProducts.Monument', 'order.products.Composite.compositeProducts.Service',
        'order.products.Composite.compositeProducts.Simple'];

    public function index()
    {
        $accounting = new Accounting;
        return response()->json($accounting->with($this->relation)->get());
    }

    public function paginateRecord()
    {
        $accounting = new Accounting;
        return response()->json($this->getDataWithPagination($accounting, 'id', $this->relation, '', '', 'desc'));
    }

    public function store(AddAccountingRequest $request)
    {
        try {
            $accounting = json_decode($request->data, true);
            $accountInstance = Accounting::updateOrCreate(['id' => $accounting['id']], $accounting);
            $accountInstance->load($this->relation);
            return response()->json($accountInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Accounting $accounting)
    {
        $accounting->load($this->relation);
        return response()->json($accounting);
    }

    public function destroy(Accounting $accounting)
    {
        return $accounting->delete();
    }

    public function getColumns()
    {
        $accounting = new Accounting();
        $invoice = new Invoice();
        $family = new Family();
        $order = new Order();
        $orderStatus = new OrderStatus();
        $orderType = new OrderType();
        $accounting = $accounting->getTableColumns();
        $invoice = $invoice->getInvoiceColumn();
        $family = $family->getOrderFamilyColumns();
        $order = $order->getOrderColumn();
        $orderStatus = $orderStatus->getOrderStatusColumns();
        $orderType = $orderType->getTableColumn();
        $data = [];
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['order'] = $order;
        $data['accounting'] = $accounting;
        $data['order_status'] = $orderStatus;
        $data['order_type'] = $orderType;
        return response()->json($data);
    }

    public function search(AddAccountingRequest $request)
    {
        $accounting = new Accounting();
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
        $accounting = $this->searchQuery($accounting, $request, 'Accounting');
        if ($columnTableName == 'accounting') {
            return response()->json($this->getDataWithPagination($accounting, $sortByColumn, $this->relation, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($accounting, $this->relation, $childClassName, $sortByColumn, 'accounting', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($accounting, $this->relation, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'order', 'accounting', 'order_id', 'order_id', $pagePerPage);
        } else if ($columnTableName == 'idNotInChildOrParentTable') {
            return $this->idNotInParentNorChildSort($accounting, $this->relation, $sortDirection, 'accounting', $pagePerPage, $sortByColumn, $childTableName, $foreignKey);
        }
//        return $accounting->orderBy('id', 'desc')->get();
    }

    private function removeParamsFromRequest($data)
    {
        $data['Order.Invoice'] = $data['Invoice'];
        $data['Order.Family'] = $data['Family'];
        $data['Order.Order_Status'] = $data['Order_Status'];
        $data['Order.Order_Type'] = $data['Order_Type'];
        unset($data['Invoice']);
        unset($data['Family']);
        unset($data['Order_Status']);
        unset($data['Order_Type']);
        return $data;
    }

    public function getDropDownRecord()
    {
        $accounting = Accounting::select('id', 'order_id')
            ->accountingdetail()
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($accounting);

    }

    public function next(Accounting $accounting)
    {
        return $this->nextRecord(new Accounting, $this->relation, $accounting->id, 'desc');
    }

    public function previous(Accounting $accounting)
    {
        return $this->previousRecord(new Accounting, $this->relation, $accounting->id);
    }

    public function first()
    {
        return $this->firstRecord(new Accounting, $this->relation, 'desc');
    }

    public function last()
    {
        return $this->lastRecord(new Accounting, $this->relation, 'asc');
    }

}
