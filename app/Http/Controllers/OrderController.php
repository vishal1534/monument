<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddOrderRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Helpers;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Accounting;
use App\Models\ApprovalMonument;
use App\Models\ApprovalMonumentImage;
use App\Models\Brick;
use App\Models\Collaboration;
use App\Models\CollaborationImage;
use App\Models\Company;
use App\Models\Composite;
use App\Models\Correspondence;
use App\Models\DeliveryWorkOrder;
use App\Models\Family;
use App\Models\FinalDate;
use App\Models\GranitBronzMemorial;
use App\Models\GranitBronzPrecious;
use App\Models\GranitBronzPreciousSpecification;
use App\Models\Installation;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\MemorialProduction;
use App\Models\MemorialProductionProduct;
use App\Models\Monument;
use App\Models\MonumentAgreement;
use App\Models\MonumentOrderNotes;
use App\Models\MonumentWorkOrder;
use App\Models\NonStockProduct;
use App\Models\Order;
use App\Models\OrderCompositeProduct;
use App\Models\OrderForm;
use App\Models\OrderStatus;
use App\Models\OrderType;
use App\Models\PaperLocation;
use App\Models\Porcelain;
use App\Models\PorcelainFile;
use App\Models\PorcelainOrientation;
use App\Models\PorcelainPart;
use App\Models\PorcelainShape;
use App\Models\Product;
use App\Models\Production;
use App\Models\Service;
use App\Models\Simple;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    use Searchable, Paginateable, FileUpload, Helpers, Accessible;

    public $relations = ['invoice.payments', 'family', 'products.OrderCompositeProduct.Monument', 'products.OrderCompositeProduct.Service',
        'products.OrderCompositeProduct.Simple', 'orderInstallation', 'monumentAgreement', 'approvalMonument', 'monumentWorkOrder'
        , 'finalDate', 'orderForm',
        'products.Monument', 'products.Service', 'products.Simple', 'company',
        'cemetery.city', 'cemetery.county', 'installation.checkList', 'production', 'accounting', 'collaboration.tasks', 'collaboration.images.user',
        'collaboration.collaborators.type', 'correspondence.tasks', 'products.NonStockProduct', 'products.Composite.compositeProducts.Monument',
        'products.Composite.compositeProducts.Service', 'products.Composite.compositeProducts.Simple', 'paperLocation', 'orderStatus', 'orderType', 'accounting'];

//    for Flutter
    public function invoiceOrders()
    {
        $orders = Order::with('invoice.payments', 'family')->orderBy('id', 'desc')->get();
        return response()->json($orders);
    }

    public function customerOrder()
    {
        $order = new Order;
        return $this->getCustomerOrder($order);
    }

    private function getCustomerOrder($order)
    {
        $currentPhoneNumber = Auth::user()->phone_number;
        if (Auth::user()->role->title != $this->userRoleTitle) {
            return $order->with($this->relations)
                ->whereHas('family', function ($query) use ($currentPhoneNumber) {
                    $query->where('phone', $currentPhoneNumber);
                })->orderBy('id', 'desc')->get();
        } else {
            return $order->with($this->relations)->orderBy('id', 'desc')->get();
        }
    }

    public function showCustomerOrder(Order $order)
    {
        /**
         * TODO:
         * This method need to be changed according to order id
         * It must not return the order that is not in family of the current user
         */
        $order->load($this->relations);
        return response()->json($order);
    }

    public function searchCustomerOrder(Request $request)
    {
        $order = new Order;
        $order = $this->searchQuery($order, $request->all(), 'Order');
        return $this->getCustomerOrder($order);
    }


    public function index()
    {
        $orders = new Order();
        $orders = $orders->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($orders);
    }

    public function getRecordPagination()
    {
        $orders = new Order();
        return response()->json($this->getDataWithPagination($orders, 'id', $this->relations, '', '', 'desc'));
    }

    public function getDropDownRecord()
    {
        $orders = Order::select('id')
            ->orderdetail()
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($orders);
    }

    public function show(Order $order)
    {
        $order->load($this->relations);
        return response()->json($order);
    }

    public function destroy(Order $order)
    {
        //delete order with all relations and sub relation
        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */
        /*foreach ($order->products as $product) {
            $product->NonStockProduct()->detach();
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            $product->Composite()->detach();
        }

        foreach ($order->invoice->payments as $payment) {
            $payment->delete();
        }
        $order->family()->delete();
        $order->products()->delete();
        $order->invoice()->delete();
        $order->correspondence()->delete();*/
        $order->production()->delete();
        $order->installation()->delete();
        $order->collaboration()->delete();
        $order->accounting()->delete();
        return $order->delete();
    }

    public function getColumns()
    {
        $order = new Order();
        $invoice = new Invoice();
        $family = new Family();
        $orderStatus = new OrderStatus();
        $orderType = new OrderType();
        $paperLocation = new PaperLocation();
        $order = $order->getTableColumns();
        $invoice = $invoice->getTableColumns();
        $family = $family->getOrderFamilyColumns();
        $orderStatus = $orderStatus->getOrderStatusColumn();
        $orderType = $orderType->getTableColumn();
        $paperLocation = $paperLocation->getTableColumns();
        $data = [];
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['order'] = $order;
        $data['order_status'] = $orderStatus;
        $data['order_type'] = $orderType;
        $data['paper_location'] = $paperLocation;
        return response()->json($data);
    }

    public function getReportColumn()
    {
        $company = new Company();
        $order = new Order();
        $invoice = new Invoice();
        $family = new Family();
        $paperLocation = new PaperLocation();
        $orderStatus = new OrderStatus();
        $accounting = new Accounting();
        $order = $order->getTableColumns();
        $invoice = $invoice->getTableColumns();
        $family = $family->getOrderFamilyColumns();
        $company = $company->getSaleReportColumn();
        $paperLocation = $paperLocation->getTableColumns();
        $orderStatus = $orderStatus->getOrderStatusColumn();
        $accounting = $accounting->getSaleReportColumn();
        $data = [];
        $data['order'] = $order;
        $data['company'] = $company;
        $data['invoice'] = $invoice;
        $data['family'] = $family;
        $data['paper_location'] = $paperLocation;
        $data['orderStatus'] = $orderStatus;
        $data['accounting'] = $accounting;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $order = new Order;
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
        $order = $this->searchQuery($order, $request, 'Order');
        if ($columnTableName == 'order') {
            return response()->json($this->getDataWithPagination($order, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($order, $this->relations, $childClassName, $sortByColumn, 'orders', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($order, $this->relations, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'order', 'orders', 'order_id', 'id', $pagePerPage);
        }
    }

    public function orderSearch(Request $request)
    {
        $order = new Order;
        $request = $request->all();
        $order = $this->searchQuery($order, $request, 'Order');
        return $order->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function searchProducts(Request $request)
    {
        $keywords = $request->keywords;
        $type = $request->type;
        try {
            $monument = new Monument();
            $service = new Service();
            $simple = new Simple();
            $composite = new Composite();
            $monument = $monument->select('id', 'product_number', 'item_name', 'override_selling_price')->with(['installation:id,installation_amount,monument_id'])
                ->when($type == 'byNumber', function ($q) use ($keywords) {
                    return $q->where('product_number', 'like', '%' . $keywords . '%');
                })->when($type == 'byTitle', function ($q) use ($keywords) {
                    return $q->where('item_name', 'like', '%' . $keywords . '%');
                })->orderBy('item_name', 'asc')->get();
            $service = $service->select('id', 'product_number', 'item_name', 'override_selling_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $simple = $simple->select('id', 'product_number', 'item_name', 'override_selling_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $composite = $composite->select('id', 'product_number', 'item_name', 'retail_price', 'install_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->with(['compositeProducts:id,composite_id,quantity,installation_price,installation', 'compositeProducts.Monument:id,product_number,item_name,override_selling_price',
                'compositeProducts.Monument.installation:id,installation_amount,monument_id', 'compositeProducts.Service:id,product_number,item_name,override_selling_price',
                'compositeProducts.Simple:id,product_number,item_name,override_selling_price'])->orderBy('item_name', 'asc')->get();
            if ($monument->count()) {
                foreach ($monument as &$item) {
                    $item['product_type'] = 'monument';
                }
            }
            if ($service->count()) {
                foreach ($service as &$item) {
                    $item['product_type'] = 'service';
                }
            }
            if ($simple->count()) {
                foreach ($simple as &$item) {
                    $item['product_type'] = 'simple';
                }
            }
            if ($composite->count()) {
                foreach ($composite as &$item) {
                    $item['product_type'] = 'composite';
                }
            }
            $returnObj = new \stdClass();
            $returnObj->monument = $monument->count() == 0 ? 'No record found' : $monument;
            $returnObj->service = $service->count() == 0 ? 'No record found' : $service;
            $returnObj->simple = $simple->count() == 0 ? 'No record found' : $simple;
            $returnObj->composite = $composite->count() == 0 ? 'No record found' : $composite;
            return response()->json($returnObj);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteProduct(Product $product)
    {
        try {
            $product->Monument()->decrement('total_sold', $product->quantity);
            $product->Simple()->decrement('total_sold', $product->quantity);
            $product->Service()->decrement('total_sold', $product->quantity);
            $product->Composite()->decrement('sold', $product->quantity);
            $product->NonStockProduct()->detach();
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            $product->Composite()->detach();
            if ($product->CompositeInventory) {
                if ($product->MonumentInventory) {
                    foreach ($product->MonumentInventory as $monumentProduct) {
                        $monument = Monument::find($monumentProduct->monument_id);
                        $monument->decrement('total_sold', $monumentProduct->item_order);
                        $monument->save();
                    }
                }
                if ($product->ServiceInventory) {
                    foreach ($product->ServiceInventory as $serviceProduct) {
                        $service = Service::find($serviceProduct->service_id);
                        $service->decrement('total_sold', $serviceProduct->item_order);
                        $service->save();
                    }
                }
                if ($product->SimpleInventory) {
                    foreach ($product->SimpleInventory as $simpleProduct) {
                        $simple = Simple::find($simpleProduct->simple_id);
                        $simple->decrement('total_sold', $simpleProduct->item_order);
                        $simple->save();
                    }
                }
            }
            $product->MonumentInventory()->delete();
            $product->ServiceInventory()->delete();
            $product->SimpleInventory()->delete();
            $product->CompositeInventory()->delete();
            return response()->json($product->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    /**
     * Forms
     */

    public function getOrderForm(Order $order)
    {
        $order->load(['orderForm', 'company', 'invoice', 'family']);
        return response()->json($order);
    }

    public function saveOrderForm(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $orderFormInstance = OrderForm::updateOrCreate(['id' => $data['id']], $data);
            $orderFormInstance->save();
            return response()->json($orderFormInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getBrick(Order $order)
    {
        $order->load(['brick', 'company', 'invoice', 'family']);
        return response()->json($order);
    }

    public function saveBrick(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $data['brick_1'] = array_map(function ($item) {
                if ($item == "")
                    return " ";
                return $item;
            }, $data['brick_1']);
            $data['brick_2'] = array_map(function ($item) {
                if ($item == "")
                    return " ";
                return $item;
            }, $data['brick_2']);
            $data['brick_1'] = implode('', $data['brick_1']);
            $data['brick_2'] = implode('', $data['brick_2']);
            $brickInstance = Brick::updateOrCreate(['id' => $data['id']], $data);
            $brickInstance->save();
            return response()->json($brickInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getGranitBronzMemorial(Order $order)
    {
        $order->load(['granitBronzMemorial', 'company', 'family', 'invoice']);
        return response()->json($order);
    }

    public function saveGranitBronzMemorial(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $granitBronzMemorialInstance = GranitBronzMemorial::updateOrCreate(['id' => $data['id']], $data);
            $granitBronzMemorialInstance->save();
            return response()->json($granitBronzMemorialInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getGranitBronzPrecious(Order $order)
    {
        $order->load(['granitBronzPrecious.flatPortrait', 'granitBronzPrecious.flatPinnedPortrait', 'granitBronzPrecious.flatPortraitVhbType',
            'granitBronzPrecious.domedPortrait', 'granitBronzPrecious.domedPinnedPortrait', 'granitBronzPrecious.originalFrame',
            'granitBronzPrecious.polishedFrame', 'granitBronzPrecious.plainColored', 'granitBronzPrecious.plainPolished',
            'granitBronzPrecious.decorativeColored', 'granitBronzPrecious.decorativePolished', 'granitBronzPrecious.castBronzeRing', 'company', 'family', 'invoice']);
        return response()->json($order);
    }

    public function saveGranitBronzPrecious(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            if (array_key_exists('horizontal_photographs', $data))
                $data['horizontal_photographs'] = implode(',', $data['horizontal_photographs']);
            if (array_key_exists('vertical_photographs', $data))
                $data['vertical_photographs'] = implode(',', $data['vertical_photographs']);
            $granitBronzPreciousInstance = GranitBronzPrecious::updateOrCreate(['id' => $data['id']], $data);
            if (!isset($data['flat_portrait']['id'])) {
                $data['flat_portrait']['id'] = 0;
            }
            $flatPortrait = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['flat_portrait']['id']], $data['flat_portrait']);
            $granitBronzPreciousInstance->flat_portrait_id = $flatPortrait->id;

            if (!isset($data['flat_pinned_portrait']['id'])) {
                $data['flat_pinned_portrait']['id'] = 0;
            }
            $flatPinnedPortrait = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['flat_pinned_portrait']['id']], $data['flat_pinned_portrait']);
            $granitBronzPreciousInstance->flat_pinned_portrait_id = $flatPinnedPortrait->id;
            if (!isset($data['flat_portrait_vhb_type']['id'])) {
                $data['flat_portrait_vhb_type']['id'] = 0;
            }
            $flatPortraitVhbType = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['flat_portrait_vhb_type']['id']], $data['flat_portrait_vhb_type']);
            $granitBronzPreciousInstance->flat_portrait_vhb_type_id = $flatPortraitVhbType->id;

            if (!isset($data['domed_portrait']['id'])) {
                $data['domed_portrait']['id'] = 0;
            }
            $domedPortrait = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['domed_portrait']['id']], $data['domed_portrait']);
            $granitBronzPreciousInstance->domed_portrait_id = $domedPortrait->id;
            if (!isset($data['domed_pinned_portrait']['id'])) {
                $data['domed_pinned_portrait']['id'] = 0;
            }
            $domedPinnedPortrait = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['domed_pinned_portrait']['id']], $data['domed_pinned_portrait']);
            $granitBronzPreciousInstance->domed_pinned_portrait_id = $domedPinnedPortrait->id;
            if (!isset($data['original_frame']['id'])) {
                $data['original_frame']['id'] = 0;
            }
            $originalFrame = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['original_frame']['id']], $data['original_frame']);
            $granitBronzPreciousInstance->original_frame_id = $originalFrame->id;
            if (!isset($data['polished_frame']['id'])) {
                $data['polished_frame']['id'] = 0;
            }
            $polishedFrame = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['polished_frame']['id']], $data['polished_frame']);
            $granitBronzPreciousInstance->polished_frame_id = $polishedFrame->id;
            if (!isset($data['plain_colored']['id'])) {
                $data['plain_colored']['id'] = 0;
            }
            $plainColored = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['plain_colored']['id']], $data['plain_colored']);
            $granitBronzPreciousInstance->plain_colored_id = $plainColored->id;
            if (!isset($data['plain_polished']['id'])) {
                $data['plain_polished']['id'] = 0;
            }
            $plainPolished = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['plain_polished']['id']], $data['plain_polished']);
            $granitBronzPreciousInstance->plain_polished_id = $plainPolished->id;
            if (!isset($data['decorative_colored']['id'])) {
                $data['decorative_colored']['id'] = 0;
            }
            $decorativeColored = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['decorative_colored']['id']], $data['decorative_colored']);
            $granitBronzPreciousInstance->decorative_colored_id = $decorativeColored->id;
            if (!isset($data['decorative_polished']['id'])) {
                $data['decorative_polished']['id'] = 0;
            }
            $decorativePolished = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['decorative_polished']['id']], $data['decorative_polished']);
            $granitBronzPreciousInstance->decorative_polished_id = $decorativePolished->id;
            if (!isset($data['cast_bronze_ring']['id'])) {
                $data['cast_bronze_ring']['id'] = 0;
            }
            $castBronzeRing = GranitBronzPreciousSpecification::updateOrCreate(['id' => $data['cast_bronze_ring']['id']], $data['cast_bronze_ring']);
            $granitBronzPreciousInstance->cast_bronze_ring_id = $castBronzeRing->id;
            $granitBronzPreciousInstance->save();
            return response()->json($granitBronzPreciousInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getMonumentAgreement(Order $order)
    {
        $order->load(['monumentAgreement', 'family', 'invoice']);
        return response()->json($order);
    }

    public function saveMonumentAgreement(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $monumentAgreementInstance = MonumentAgreement::updateOrCreate(['id' => $data['id']], $data);
            $monumentAgreementInstance->save();
            return response()->json($monumentAgreementInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getMonumentWorkOrder(Order $order)
    {
        $order->load(['monumentWorkOrder', 'family', 'invoice', 'company']);
        return response()->json($order);
    }

    public function saveMonumentWorkOrder(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $monumentWorkOrder = MonumentWorkOrder::updateOrCreate(['id' => $data['id']], $data);
            $monumentWorkOrder->save();
            return response()->json($monumentWorkOrder);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getFinalDate(Order $order)
    {
        $order->load(['finalDate', 'family', 'invoice', 'cemetery.city']);
        return response()->json($order);
    }

    public function saveFinalDate(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $finalDateInstance = FinalDate::updateOrCreate(['id' => $data['id']], $data);
            $finalDateInstance->save();
            return response()->json($finalDateInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getPorcelain(Order $order)
    {
        $order->load(['porcelain.part', 'porcelain.shape', 'porcelain.orientation', 'family', 'invoice', 'porcelain.files']);
        return response()->json($order);
    }

    public function savePorcelain(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            if (isset($data['part_title'])) {
                $part = ['id' => $data['part']['id'], 'title' => $data['part_title']];
                $porcelainPart = PorcelainPart::updateOrCreate(['id' => $data['part']['id']], $part);
            }
            if (isset($data['orientation_title'])) {
                $orientation = ['id' => $data['orientation']['id'], 'title' => $data['orientation_title']];
                $porcelainOrientation = PorcelainOrientation::updateOrCreate(['id' => $data['orientation']['id']], $orientation);
            }
            if (isset($data['shape_title'])) {
                $shape = ['id' => $data['shape']['id'], 'title' => $data['shape_title']];
                $porcelainShape = PorcelainShape::updateOrCreate(['id' => $data['shape']['id']], $shape);
            }
            $porcelainData = array(
                "order_id" => isset($data['order_id']) ? $data['order_id'] : null,
                "id" => isset($data['id']) ? $data['id'] : null,
                "part_id" => isset($porcelainPart->id) ? $porcelainPart->id : null,
                "format_id" => isset($data['format_id']) ? $data['format_id'] : null,
                "orientation_id" => isset($porcelainOrientation->id) ? $porcelainOrientation->id : null,
                "size_id" => isset($data['size_id']) ? $data['size_id'] : null,
                "shape_id" => isset($porcelainShape->id) ? $porcelainShape->id : null,
                "background" => isset($data['background']) ? $data['background'] : null,
                "border" => isset($data['border']) ? $data['border'] : null,
                "photograph" => isset($data['photograph']) ? $data['photograph'] : null,
                "special_instructions" => isset($data['special_instructions']) ? $data['special_instructions'] : null,
            );
            $porcelainInstance = Porcelain::updateOrCreate(['id' => $data['id']], $porcelainData);
            $porcelainInstance->save();
            if ($request->hasFile('doc_files')) {
                foreach ($request->doc_files as $file) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $file->storeAs('public/porcelain', $filenameToStore);
                    $document = new PorcelainFile();
                    $document->name = $filenameWithExt;
                    $porcelainInstance->files()->save($document);
                    $orderInstance = Order::find($data['order_id']);
                    $collaboration = Collaboration::find($orderInstance->collaboration->id);
                    $uploadObj = new \stdClass();
                    $uploadObj->file = $file;
                    $uploadObj->path = 'collaboration/';
                    $uploadObj->module = 'collaboration';
                    $file = $this->upload($uploadObj);
                    $collaborationImage = new CollaborationImage();
                    $collaborationImage->name = $file->filenameWithExt;
                    $collaborationImage->uploaded_by = Auth::user()->name;
                    $collaborationImage->user_id = Auth::user()->id;
                    $collaborationImage->size = $file->size;
                    $collaborationImage->path = 'images/' . $uploadObj->path . $file->filenameToStore;
                    $collaborationImage->status = 'porcelain';
                    $collaborationImage->sent_mail = 0;
                    $collaborationImage->save();
                    $collaboration->images()->save($collaborationImage);
                }
            }
            $porcelainInstance->load(['part', 'shape', 'orientation', 'files']);
            return response()->json($porcelainInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getMonumentOrderNotes(Order $order)
    {
        $order->load(['monumentOrderNotes', 'family', 'invoice']);
        return response()->json($order);
    }

    public function saveMonumentOrderNotes(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $monumentOrderNotesInstance = MonumentOrderNotes::updateOrCreate(['id' => $data['id']], $data);
            $monumentOrderNotesInstance->save();
            return response()->json($monumentOrderNotesInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getDeliveryWorkOrder(Order $order)
    {
        $order->load(['deliveryWorkOrder', 'family', 'invoice']);
        return response()->json($order);
    }

    public function saveDeliveryWorkOrder(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $deliveryWOrkOrderInstance = DeliveryWorkOrder::updateOrCreate(['id' => $data['id']], $data);
            $deliveryWOrkOrderInstance->save();
            return response()->json($deliveryWOrkOrderInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getMemorialProduction(Order $order)
    {
        $order->load(['memorialProduction.products', 'company', 'invoice', 'products.Monument.type', 'products.Monument.color', 'products.Service', 'products.Simple', 'products.Composite', 'family']);
        return response()->json($order);
    }

    public function saveMemorialProduction(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $memorialProductionInstance = MemorialProduction::updateOrCreate(['id' => $data['memorial_production']['id']], $data['memorial_production']);
            foreach ($data['memorial_production']['products'] as $product) {
                if (count($this->arrayCount($product)) > 0) {
                    $productInstance = MemorialProductionProduct::updateOrCreate(['id' => $product['id']], $product);
                    $memorialProductionInstance->products()->save($productInstance);
                }
            }
            $memorialProductionInstance->load(['products']);
            $memorialProductionInstance->save();
            return response()->json($memorialProductionInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteMemorialProductionProduct(MemorialProductionProduct $product)
    {
        try {
            return response()->json($product->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getApprovalMonument(Order $order)
    {
        $order->load(['approvalMonument.image', 'family', 'company', 'invoice']);
        return response()->json($order);
    }

    public function saveApprovalMonument(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $pattern = '/^data:([a-z]+\/[a-z]+|image\/svg\+xml|application\/vnd\.openxmlformats-officedocument\.wordprocessingml\.document|application\/vnd\.openxmlformats-officedocument\.spreadsheetml\.sheet|application\/vnd\.ms-excel|application\/postscript|application\/octet-stream);base64,/';
            if (isset($data['deleteImage']) && !empty($data['deleteImage'])) {
                foreach ($data['deleteImage'] as $approval) {
                    $image = ApprovalMonumentImage::find($approval['id']);
                    $image->delete();
                }
            }
            $collaboration = Collaboration::whereOrderId($data['order_id'])->first();
            $approvalMonumentInstance = ApprovalMonument::updateOrCreate(['id' => $data['id']], $data);

            if (isset($data['baseSixtyFourImg']) && !empty($data['baseSixtyFourImg'])) {
                foreach ($data['baseSixtyFourImg'] as $img) {
                    $base64Image = $img['base64file'];
                    $fileNameWithExt = $img['name'];
                    $fileNameToStore = $this->uploadBase64File($img);
                    $approvalImage = $this->storeApprovalMonumentImage($fileNameWithExt, $fileNameToStore, $img['title'], $img['printable']);
                    $approvalMonumentInstance->image()->save($approvalImage);
                    $fileSize = Storage::size('public/approval-monument/' . $fileNameToStore);
                    $collaborationImage = $this->storeCollaborationUploadFile($fileNameWithExt, $fileSize, $fileNameToStore, 'images/approval-monument/');
                    $collaboration->images()->save($collaborationImage);
                }
            }
            /*if ($request->hasFile('doc_files')) {
                foreach ($request->doc_files as $file) {
                    $fileNameWithExt = $file->getClientOriginalName();
                    $fileSize = $file->getSize();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extention = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);
                    $fileNameToStore = 'approval-monument_' . random_int(1, 9999) . time() . '.' . $extention;
                    $path = $file->storeAs('public/approval-monument', $fileNameToStore);
                    $approvalImage = $this->storeApprovalMonumentImage($fileNameWithExt, $fileNameToStore, null, null);
                    $approvalMonumentInstance->image()->save($approvalImage);
                    $collaborationImage = $this->storeCollaborationUploadFile($fileNameWithExt, $fileSize, $fileNameToStore, 'images/approval-monument/');
                    $collaboration->images()->save($collaborationImage);
                }
            }*/
            if (isset($data['image']) && !empty($data['image'])) {
                foreach ($data['image'] as $title) {
                    if (isset($title['id']) && !empty($title['id'])) {
                        $updateImage = ApprovalMonumentImage::find($title['id']);
                        $updateImage->update(['title' => $title['title'], 'printable' => $title['printable']]);
                    }
                }
            }
            $approvalMonumentInstance->save();
            $approvalMonumentInstance->load('image');
            return response()->json($approvalMonumentInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    private function uploadBase64File($image)
    {
        $base64Image = $image['base64file'];
        $fileNameWithExt = $image['name'];
        $pattern = '/^data:([a-z]+\/[a-z]+|image\/svg\+xml|application\/vnd\.openxmlformats-officedocument\.wordprocessingml\.document|application\/vnd\.openxmlformats-officedocument\.spreadsheetml\.sheet|application\/vnd\.ms-excel|application\/postscript|application\/octet-stream);base64,/';
        $fileExtension = pathinfo($fileNameWithExt, PATHINFO_EXTENSION);
        $replacement = '';
        $base64Image = preg_replace($pattern, $replacement, $base64Image);
        $base64Image = str_replace(' ', '+', $base64Image);
        $fileNameToStore = 'approval-monument_' . random_int(1, 9999) . time() . '.' . $fileExtension;
        \File::put(storage_path('app/public/approval-monument') . '/' . $fileNameToStore, base64_decode($base64Image));
        return $fileNameToStore;
    }

    private function storeApprovalMonumentImage($fileNameWithExt, $fileNameToStore, $fileTitle, $filePrintable)
    {
        $approvalImage = new ApprovalMonumentImage();
        $approvalImage->name = $fileNameWithExt;
        $approvalImage->file = 'images/approval-monument/' . $fileNameToStore;
        $approvalImage->title = $fileTitle;
        $approvalImage->printable = $filePrintable;
        $approvalImage->save();
        return $approvalImage;
    }

    private function storeCollaborationUploadFile($filename, $fileSize, $filenameToStore, $path)
    {
        $collaborationImage = new CollaborationImage();
        $collaborationImage->name = $filename;
        $collaborationImage->uploaded_by = Auth::user()->name;
        $collaborationImage->user_id = Auth::user()->id;
        $collaborationImage->size = $fileSize;
        $collaborationImage->path = $path . $filenameToStore;
        $collaborationImage->status = 'uploads';
        $collaborationImage->sent_mail = 0;
        $collaborationImage->save();
        return $collaborationImage;
    }

    public function getNext(Order $order)
    {
        return $this->nextRecord(new Order, $this->relations, $order->id, 'desc');
    }

    public function getPrevious(Order $order)
    {
        return $this->previousRecord(new Order, $this->relations, $order->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Order, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Order, $this->relations, 'asc');
    }

    public function getTotalRecord()
    {
        return $this->totalRecord(new Order);
    }

    public function orderType()
    {
        $record = new OrderType();
        $record = $record->select('id', 'type_title')->orderBy('type_title', 'asc')->get();
        return response()->json($record);
    }

    public function saveOrderType(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $type = OrderType::updateOrCreate(['id' => $data['id']], $data);
            $type->save();
            return response()->json($type);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteOrderType(OrderType $orderType)
    {
        return $orderType->delete();
    }

    /**
     * Sync Orders from Magento Store
     */
    public function syncOrdersApi(Request $request)
    {
        try {
            $responseAll = [];
            $errorMsgUser = 'Somethings wrong, please contact IT administrator.';
            $magentoApiURL = config('services.magento.api_url');
            $tokenResponse = $this->generateTokenApi($magentoApiURL);
            $token = $tokenResponse['token'];
            if ($tokenResponse['statusCode'] === 200 && !empty($token)) {
                $ordersResponse = $this->fetchOrdersApi($magentoApiURL, $token);
                if ($ordersResponse['statusCode'] === 200 && !empty($ordersResponse['orders']) && $ordersResponse['orders']['total_count'] > 0) {
                    $orderIdsProcessed = [];
                    foreach ($ordersResponse['orders']['items'] as $item) {
                        $payload = [
                            'status' => $item['status'],
                            'cemetery' => [],
                            'cemetery_id' => NULL,
                            'company_id' => 0,
                            'collaboration' => ['id' => 0],
                            'correspondence' => ['id' => 0],
                            'family' => ['id' => 0],
                            'is_installation' => 0,
                            'installation' => ['id' => 0],
                            'date' => $item['created_at'],
                            'id' => 0,
                            'invoice' =>
                                [
                                    'invoice_number' => 0,
                                    'payments' => [],
                                    'invoice_total' => $item['payment']['base_amount_ordered']
                                ],
                            'order_type' => NULL,
                            'po' => NULL,
                            'production' => ['id' => 0],
                            'sales_person' => NULL,
                            'store_address' => NULL,
                            'store_location' => NULL,
                            'sub_total' => $item['subtotal'],
                            'tax_rate' => 0,
                            'tax_amount' => $item['tax_amount'],
                            'products' => []
                        ];
                        $products = [];
                        foreach ($item['items'] as $key => $product) {
                            if (array_key_exists("parent_item", $product)) {
                                continue;
                            }
                            $products[$key]['id'] = 0;
                            $products[$key]['quantity'] = $product['qty_ordered'];
                            $products[$key]['amount'] = $product['row_total'];
                            $products[$key]['price'] = $product['price'];
                            $products[$key]['total'] = $product['price_incl_tax'];
                            $products[$key]['non_stock_product'][0]['id'] = 0;
                            $products[$key]['non_stock_product'][0]['item_name'] = $product['name'];
                            $products[$key]['non_stock_product'][0]['product_number'] = '';
                        }
                        $payload['products'] = $products;
                        $addOrderReq = new AddOrderRequest();
                        $addOrderReq->setMethod('POST');
                        $addOrderReq->data = json_encode($payload);
                        $newOrderResponse = $this->store($addOrderReq);
                        if ($newOrderResponse->getStatusCode() === 200) {
                            $newOrderId = json_decode($newOrderResponse->getContent(), true)['id'];
                            $payloadPayment = ["id" => 0, "amount" => $item['payment']['amount_ordered'], "type" => $item['payment']['additional_information'][0], "order" => $newOrderId];
                            $newPaymentReq = new Request();
                            $newPaymentReq->setMethod('POST');
                            $newPaymentReq->data = json_encode($payloadPayment);
                            $newPaymentResponse = $this->addPayment($newPaymentReq);
                            if ($newPaymentResponse->getStatusCode() === 200) {
                                $orderIdsProcessed[] = $item['entity_id'];
                            } else {
                                // TODO: handle error logs
                                $responseAll['errorInfo'] = $errorMsgUser;
                            }

                        } else {
                            // TODO: handle error logs
                            $responseAll['errorInfo'] = $errorMsgUser;
                        }

                    }
                    if (count($orderIdsProcessed) > 0) {
                        $responseOrderApi = $this->updateOrdersApi($magentoApiURL, $token, $orderIdsProcessed);
                        if (array_key_exists('errorInfo', $responseOrderApi)) {
                            $responseAll['errorInfo'] = $errorMsgUser;
                        }
                    } else {
                        // TODO: handle error logs
                        $responseAll['errorInfo'] = $errorMsgUser;
                    }
                } else {
                    $responseAll['warnInfo'] = 'Orders already Synced!';
                }
            } else {
                // TODO: handle error logs
                $responseAll['errorInfo'] = $errorMsgUser;
            }
            return response()->json($responseAll);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    /**
     * Generate Token from Magento Store Admin
     */
    private function generateTokenApi($magentoApiURL)
    {
        $magentoAdminUsername = config('services.magento.admin_username');;
        $magentoAdminPassword = config('services.magento.admin_password');;
        $apiURL = $magentoApiURL . 'integration/admin/token';
        $postInput = [
            'username' => $magentoAdminUsername,
            'password' => $magentoAdminPassword
        ];
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $response = Http::withHeaders($headers)->post($apiURL, $postInput);
        return ['statusCode' => $response->status(), 'token' => json_decode($response->getBody(), true)];
    }

    /**
     * Fetch all Pending Orders from Magento Store
     */
    private function fetchOrdersApi($magentoApiURL, $token)
    {
        $searchCriteria = 'searchCriteria[filter_groups][0][filters][0][field]=status_mps&searchCriteria[filter_groups][0][filters][0][value]=pending&searchCriteria[filter_groups][0][filters][0][condition_type]=eq&searchCriteria[currentPage]=1&searchCriteria[sortOrders][0][field]=created_at&searchCriteria[sortOrders][0][direction]=ASC';
        $apiURL = $magentoApiURL . 'orders?' . $searchCriteria;
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ];

        $response = Http::withHeaders($headers)->get($apiURL);
        return ['statusCode' => $response->status(), 'orders' => json_decode($response->getBody(), true)];
    }

    public function store(AddOrderRequest $request)
    {
        try {
            $order = json_decode($request->data, true);

            if ($order['company_id'] == 0) {
                $order['company_id'] = null;
            }
            $orderInstance = Order::updateOrCreate(['id' => $order['id']], $order);
            if (!empty($order['invoice'])) {
                $invoice = Invoice::updateOrCreate(['invoice_number' => $order['invoice']['invoice_number']], $order['invoice']);
                $order['invoice']['invoice_number'] = $invoice['invoice_number'];
                $orderInstance->invoice()->save($invoice);
            }
            if (!empty($order['family'])) {
                $familyInstance = Family::updateOrCreate(['id' => $order['family']['id']], $order['family']);
                $orderInstance->family()->save($familyInstance);
            }
            if (!empty($order['production'])) {
//                $order['production']['store_id'] = Auth::user()->store_id;
                $productionInstance = Production::updateOrCreate(['id' => $order['production']['id']], $order['production']);
                $orderInstance->production()->save($productionInstance);
            }
            if (!empty($order['accounting'])) {
                $accountingInstance = Accounting::updateOrCreate(['id' => $order['accounting']['id']], $order['accounting']);
                $orderInstance->accounting()->save($accountingInstance);
            }
            if (!empty($order['collaboration'])) {
//                $order['collaboration']['store_id'] = Auth::user()->store_id;
                $collaborationInstance = Collaboration::updateOrCreate(['id' => $order['collaboration']['id']], $order['collaboration']);
                $orderInstance->collaboration()->save($collaborationInstance);
            }
            if (!empty($order['correspondence'])) {
                $correspondenceInstance = Correspondence::updateOrCreate(['id' => $order['correspondence']['id']], $order['correspondence']);
                $orderInstance->correspondence()->save($correspondenceInstance);
            }
            if (!empty($order['installation'])) {
//                $order['installation']['store_id'] = Auth::user()->store_id;
                $installationInstance = Installation::updateOrCreate(['id' => $order['installation']['id']], $order['installation']);
                $orderInstance->installation()->save($installationInstance);
            }
            foreach ($order['products'] as $product) {
                $productData = Product::find($product['id']);
                if ($productData) {
                    $existingProductQuantity = $productData->quantity;
                } else {
                    $existingProductQuantity = 0;
                }
                $productInstance = Product::updateOrCreate(['id' => $product['id']], $product);
                $orderInstance->products()->save($productInstance);
                if (array_key_exists('non_stock_product', $product) && count($product['non_stock_product']) > 0) {
                    $nonStockProduct = NonStockProduct::updateOrCreate(['id' => $product['non_stock_product'][0]['id']], $product['non_stock_product'][0]);
                    $nonStockProduct->products()->sync([$productInstance->id]);
                }
                if (array_key_exists('monument', $product) && count($product['monument']) > 0) {
                    $monument = Monument::find($product['monument'][0]['id']);
//                    $monument->products()->sync([$productInstance->id]);
                    $productInstance->monument()->sync([$product['monument'][0]['id']]);
                    $this->addProductInventory($monument, $product['quantity'], $order, $productInstance, $existingProductQuantity, 'monument', null, $product['monument'][0]['id']);
                }
                if (array_key_exists('service', $product) && count($product['service']) > 0) {
                    $service = Service::find($product['service'][0]['id']);
//                    $service->products()->sync([$productInstance->id]);
                    $productInstance->service()->sync([$product['service'][0]['id']]);
                    $this->addProductInventory($service, $product['quantity'], $order, $productInstance, $existingProductQuantity, 'service', null, $product['service'][0]['id']);
                }
                if (array_key_exists('simple', $product) && count($product['simple']) > 0) {
                    $simple = Simple::find($product['simple'][0]['id']);
//                    $simple->products()->sync([$productInstance->id]);
                    $productInstance->simple()->sync([$product['simple'][0]['id']]);
                    $this->addProductInventory($simple, $product['quantity'], $order, $productInstance, $existingProductQuantity, 'simple', null, $product['simple'][0]['id']);
                }
                if (array_key_exists('composite', $product) && count($product['composite']) > 0) {
                    $composite = Composite::find($product['composite'][0]['id']);
//                    $composite->products()->sync([$productInstance->id]);
                    $this->addProductInventory($composite, $product['quantity'], $order, $productInstance, $existingProductQuantity, 'composite', $product['composite'][0]['id'], $product['composite'][0]['id']);
                    $productInstance->composite()->sync([$product['composite'][0]['id']]);
                    if (array_key_exists('order_composite_product', $product) && count($product['order_composite_product']) > 0) {
                        foreach ($product['order_composite_product'] as $compositeProduct) {
                            $compositeProduct['product_id'] = $productInstance->id;
                            $itemOrder = $compositeProduct['quantity'] * $productInstance->quantity;
                            $orderComposite = OrderCompositeProduct::updateOrCreate(['id' => $compositeProduct['id']], $compositeProduct);
                            if (array_key_exists('monument', $compositeProduct) && count($compositeProduct['monument']) > 0) {
                                $orderComposite->Monument()->sync([$compositeProduct['monument'][0]['id']]);
                                $monument = Monument::find($compositeProduct['monument'][0]['id']);
                                $this->addProductInventory($monument, $itemOrder, $order, $productInstance, $existingProductQuantity, 'monument', $product['composite'][0]['id'], $compositeProduct['monument'][0]['id']);
                            }
                            if (array_key_exists('service', $compositeProduct) && count($compositeProduct['service']) > 0) {
                                $orderComposite->Service()->sync([$compositeProduct['service'][0]['id']]);
                                $service = Service::find($compositeProduct['service'][0]['id']);
                                $this->addProductInventory($service, $itemOrder, $order, $productInstance, $existingProductQuantity, 'service', $product['composite'][0]['id'], $compositeProduct['service'][0]['id']);
                            }
                            if (array_key_exists('simple', $compositeProduct) && count($compositeProduct['simple']) > 0) {
                                $orderComposite->Simple()->sync([$compositeProduct['simple'][0]['id']]);
                                $simple = Simple::find($compositeProduct['simple'][0]['id']);
                                $this->addProductInventory($simple, $itemOrder, $order, $productInstance, $existingProductQuantity, 'simple', $product['composite'][0]['id'], $compositeProduct['simple'][0]['id']);
                            }
                        }
                    }
                }
            }
            $orderInstance->save();
            $orderInstance->load($this->relations);
            return response()->json($orderInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function addPayment(Request $request)
    {
        $data = json_decode($request->data, true);
        $payment = InvoicePayment::updateOrCreate(['id' => $data['id']], $data);
        $order = Order::find($data['order']);
        $payment = $order->invoice->payments()->save($payment);
        return response()->json($payment);
    }

    /**
     * Update Status of Pending Orders in Magento Store
     */
    private function updateOrdersApi($magentoApiURL, $token, $orderIdsProcessed)
    {
        $responsesUpdateOrder = [];
        foreach ($orderIdsProcessed as $orderId) {
            $apiURL = $magentoApiURL . 'orders/status_mps_update';
            $postInput = [
                'entity' => [
                    'entity_id' => $orderId,
                    'status_mps' => 'processed'
                ]
            ];
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ];
            $responseUpdateOrder = Http::withHeaders($headers)->post($apiURL, $postInput);
            if ($responseUpdateOrder->getStatusCode() !== 200) {
                // TODO: handle error logs
                $responseUpdateOrder['errorInfo'] = 1;
            }
        }
        return $responsesUpdateOrder;
    }

    public function uploadOrderImage(Request $request)
    {
        $data = json_decode($request->data, true);
        $collaboration = Collaboration::whereOrderId($data['order_id'])->first();
        if ($request->hasFile('doc_files')) {
            foreach ($request->doc_files as $file) {
                $filenameWithExt = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                $filenameToStore = 'collaboration_' . time() . '.' . $extension;
                $path = $file->storeAs('public/collaboration', $filenameToStore);
                $collaborationImage = new CollaborationImage();
                $collaborationImage->name = $filenameWithExt;
                $collaborationImage->uploaded_by = Auth::user()->name;
                $collaborationImage->user_id = Auth::user()->id;
                $collaborationImage->size = $fileSize;
                $collaborationImage->path = 'images/collaboration/' . $filenameToStore;
                $collaborationImage->status = 'uploads';
                $collaborationImage->sent_mail = 0;
                $collaborationImage->save();
                $collaboration->images()->save($collaborationImage);
            }
            return response()->json($collaboration);
        } else {
            return response()->json(['errorInfo' => ['No file is selected. Please select files first']], 200);
        }
    }
}
