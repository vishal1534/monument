<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddStoreRequest;
use App\Models\Store;
use Illuminate\Http\Request;
use Exception;

class StoreController extends Controller
{
    public $relations = [];

    public function index(){
        $store = new Store();
        return response()->json($store->get());
    }

    public function store(AddStoreRequest $request){

        try {
            $store = json_decode($request->data, true);

            $storeInstance = Store::updateOrCreate(['id' => $store['id']], $store);

            $storeInstance->load($this->relations);
            return response()->json($storeInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Store $store){
        $store->load($this->relations);
        return response()->json($store);
    }

    public function destroy(Store $store){

        return $store->delete();
    }

    public function getColumns(){
        $store = new Store();
        $store = $store->getTableColumns();

        $data = [];
        $data['store'] = $store;
        return response()->json($data);
    }

    public function search(Request $request){

        try{
            $store = new Store();

            $queryObj = new \stdClass();

            foreach ($request->all() as $key => $fields) {

                $fields = json_decode($fields);

                if ($key == "Store"){
                    foreach ($fields as $field) {
                        $queryObj->query = $store;
                        $queryObj->field = $field;
                        $store = $this->refineQuery($queryObj);
                    }
                }
                else{
                    $store = $store->whereHas($key, function ($query) use ($fields, $queryObj){
                        foreach ($fields as $field) {
                            $queryObj->query = $query;
                            $queryObj->field = $field;
                            $query = $this->refineQuery($queryObj);
                        }
                        return $query;
                    });
                }
            }

            $store = $store->orderBy('id', 'desc')->get();
            $store->load($this->relations);
            return $store;
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function refineQuery($queryObj){

        if ($queryObj->field->value != ''){

            if($queryObj->field->operator == '...'){
                $values = explode("...", $queryObj->field->value);
                $queryObj->query = $queryObj->query->whereBetween($queryObj->field->column, [(int)$values[0], (int)$values[1]]);
            }
            else{

                // If no operator provided, set to equal
                if ($queryObj->field->operator == ''){
                    $queryObj->field->operator = 'like';
                }
                if (is_numeric($queryObj->field->value)){
                    if ($queryObj->field->operator == 'like')
                        $queryObj->field->operator = '=';
                    elseif ($queryObj->field->operator == 'not like')
                        $queryObj->field->operator = '!=';

                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, +$queryObj->field->value); // (+) here is used for type cast (converting string to int)
                }
                else if((bool)strtotime($queryObj->field->value)){
                    if ($queryObj->field->operator == 'like')
                        $queryObj->field->operator = '=';

                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value);
                }
                else{
                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, "%".$queryObj->field->value."%");
                }
            }
        }

        return $queryObj->query;
    }

    public function next($id){
        $store = new Store;
        $store = $store->with($this->relations)->where('id', '>', $id)->first();
        return response()->json($store);
    }

    public function previous($id){
        $store = new Store;
        $store = $store->with($this->relations)->where('id', '<', $id)->orderBy('id','desc')->first();
        return response()->json($store);
    }

    public function first(){
        $store = new Store;
        $store = $store->with($this->relations)->first();
        return response()->json($store);
    }

    public function last(){
        $store = new Store;
        $store = $store->with($this->relations)->orderBy('id','desc')->first();
        return response()->json($store);
    }
}
