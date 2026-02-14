<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentTypeRequest;
use App\Http\Traits\Accessible;
use App\Models\MonumentType;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class MonumentTypeController extends Controller{

    use Searchable,Accessible;

    public function index(){
        $monumentType = new MonumentType;
        return response()->json($monumentType->get());
    }

    public function store(AddMonumentTypeRequest $request){

        try {

            $monumentType = json_decode($request->data, true);
            $title = $monumentType['type_title'];
            $record = MonumentType::whereTypeTitle($title)->exists();
            if ($record)
                return response()->json(['errorInfo' => ['The type name already exists']], 200);

            $monumentTypeInstance = MonumentType::updateOrCreate(['id' => $monumentType['id']], $monumentType);

            return response()->json($monumentTypeInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentType $monumentType){

        return response()->json($monumentType);
    }

    public function destroy(MonumentType $monumentType){

        return $monumentType->delete();
    }

    public function getColumns(){

        $monumentType = new MonumentType;
        $monumentType = $monumentType->getTableColumns();
        $data = [];
        $data['monumentType'] = $monumentType;
        return response()->json($data);
    }

    public function search(AddMonumentTypeRequest $request){

        $monumentType = new MonumentType;
        $request = $request->all();
        $monumentType = $this->searchQuery($monumentType, $request,'MonumentType');
        return $monumentType->orderBy('id', 'desc')->get();
    }

}
