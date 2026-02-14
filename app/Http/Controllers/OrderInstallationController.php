<?php


namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddOrderInstallationRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\OrderInstallation;
use App\Models\Order;
use App\Models\InstallationFlagging;
use App\Models\InstallationCemeteryConfirmation;
use App\Models\InstallationPayment;
use App\Models\InstallationPlacement;
use App\Models\InstallationMonument;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;

class OrderInstallationController extends Controller
{
    use Searchable,Paginateable,Accessible;
    public $relations = ['order', 'monument', 'flagging', 'placement', 'payment', 'cemeteryConfirmation'];
    public $orderRelations = ['orderInstallation.monument', 'orderInstallation.flagging', 'orderInstallation.placement',
        'orderInstallation.payment', 'orderInstallation.cemeteryConfirmation', 'company', 'invoice.payments', 'cemetery.city',
        'cemetery.county', 'cemetery.state', 'family', 'products.Monument', 'products.Composite','products.Service',
        'products.Simple'];

    public function index(){

        $installations = new OrderInstallation();
        $installations = $installations->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($installations);
    }

    public function store(AddOrderInstallationRequest $request){

        try {
            $installation = json_decode($request->data, true);

            $installationInstance = OrderInstallation::updateOrCreate(['id' => $installation['order_installation']['id']], $installation['order_installation']);

            if ($this->arrayCount($installation['order_installation']['flagging']) > 0){
                $flagging = InstallationFlagging::updateOrCreate(['id' =>$installation['order_installation']['flagging']['id']], $installation['order_installation']['flagging']);
                $installationInstance->flagging()->save($flagging);
            }

            if ($this->arrayCount($installation['order_installation']['monument']) > 0){
                $monument= InstallationMonument::updateOrCreate(['id' =>$installation['order_installation']['monument']['id']], $installation['order_installation']['monument']);
                $installationInstance->monument()->save($monument);
            }
            if ($this->arrayCount($installation['order_installation']['placement']) > 0){
                $placement = InstallationPlacement::updateOrCreate(['id' =>$installation['order_installation']['placement']['id']], $installation['order_installation']['placement']);
                $installationInstance->placement()->save($placement);
            }
            if ($this->arrayCount($installation['order_installation']['payment']) > 0){
                $payment = InstallationPayment::updateOrCreate(['id' =>$installation['order_installation']['payment']['id']], $installation['order_installation']['payment']);
                $installationInstance->payment()->save($payment);
            }
            if ($this->arrayCount($installation['order_installation']['cemetery_confirmation']) > 0){
                $cemetery_confirmation = InstallationCemeteryConfirmation::updateOrCreate(['id' =>$installation['order_installation']['cemetery_confirmation']['id']], $installation['order_installation']['cemetery_confirmation']);
                $installationInstance->payment()->save($cemetery_confirmation);
            }

            $installationInstance->save();


            // Attach installation with Order
            $order = Order::find($installation['id']);
            $order->installation()->save($installationInstance);


//            $installationInstance->load($this->relations);
            $order->load($this->orderRelations);
            return response()->json($order);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    // TODO: add query in DI if no record found to avoid notFoundException (in case of OrderInstallation)
    public function show($orderID){


//        $installation = OrderInstallation::with($this->relations)->where('order_id', $orderID)->get();

        $order = Order::with($this->orderRelations)->find($orderID);
//        $order->load($this->orderRelations);
        return response()->json($order);
    }

    public function destroy(OrderInstallation $installation){

        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */
        foreach ($installation->products as $product){
            $product->Monument()->detach();
        }

        foreach ($installation->invoice->payments as $payment){
            $payment->delete();
        }

        $installation->products()->delete();
        $installation->invoice()->delete();
        return $installation->delete();
    }

    public function getColumns(){

        $installation = new OrderInstallation();
        $invoice = new Invoice();
        $installation = $installation->getTableColumns();
        $invoice = $invoice->getTableColumns();

        $data = [];
        $data['installation'] = $installation;
        $data['invoice'] = $invoice;
        return response()->json($data);
    }

    public function search(Request $request){

        $installation = new OrderInstallation;
        $installation = $this->searchQuery($installation, $request,'OrderInstallation');
        return $installation->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function arrayCount($arr){
        $arrCount = array_filter($arr, function ($item){
            return $item != 0 && $item != null;
        });
        return $arrCount;
    }
}
