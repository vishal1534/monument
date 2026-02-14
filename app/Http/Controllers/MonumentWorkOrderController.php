<?php

namespace App\Http\Controllers;
use App\Events\ProcessException;
use App\Http\Requests\AddMonumentWorkOrderRequest;
use App\Http\Traits\Searchable;
use App\Models\MonumentWorkOrder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class MonumentWorkOrderController extends Controller
{
    use Searchable;

    public function index(){
        $monumentWorkOrder = new MonumentWorkOrder;
        return response()->json($monumentWorkOrder->with(['order.family','order.invoice'])->get());
    }

    public function store(AddMonumentWorkOrderRequest $request){
        try {

            $monumentWorkOrder = json_decode($request->data, true);

            $monumentWorkOrderInstance = MonumentWorkOrder::updateOrCreate(['id' => $monumentWorkOrder['id']], $monumentWorkOrder);

            $monumentWorkOrderInstance->load(['order.family','order.invoice']);
            return response()->json($monumentWorkOrderInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentWorkOrder $monumentWorkOrder){
        $monumentWorkOrder->load(['order.family','order.invoice']);
        return response()->json($monumentWorkOrder);
    }

    public function destroy(MonumentWorkOrder $monumentWorkOrder){
        return $monumentWorkOrder->delete();
    }

}
