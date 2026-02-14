<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddDeliveryWorkOrderRequest;
use App\Http\Traits\Searchable;
use App\Models\DeliveryStoreLocation;
use App\Models\DeliveryWorkOrder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class DeliveryWorkOrderController extends Controller
{
    use Searchable;

    public function index(){
        $deliveryWorkOrder = new DeliveryWorkOrder;
        return response()->json($deliveryWorkOrder->with(['order.family','order.invoice'])->get());
    }

    public function store(AddDeliveryWorkOrderRequest $request){
        try {

            $deliveryWorkOrder = json_decode($request->data, true);

            $deliveryWorkOrderInstance = DeliveryWorkOrder::updateOrCreate(['id' => $deliveryWorkOrder['id']], $deliveryWorkOrder);

            $deliveryWorkOrderInstance->load(['order.family','order.invoice']);
            return response()->json($deliveryWorkOrderInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(DeliveryWorkOrder $deliveryWorkOrder){
        $deliveryWorkOrder->load(['order.family','order.invoice']);
        return response()->json($deliveryWorkOrder);
    }

    public function destroy(DeliveryWorkOrder $deliveryWorkOrder){
        return $deliveryWorkOrder->delete();
    }

    public function deliveryStoreLocationInfo(){
        $deliveryStoreLocations= new DeliveryStoreLocation();
        return response()->json($deliveryStoreLocations->get());
    }
}
