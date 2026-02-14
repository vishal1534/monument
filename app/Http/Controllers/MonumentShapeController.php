<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentShapeRequest;
use App\Http\Traits\Accessible;
use App\Models\MonumentShape;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class MonumentShapeController extends Controller{

    use Searchable,Accessible;

    public function index(){

        $monumentShape = new MonumentShape;
        return response()->json($monumentShape->get());
    }

    public function store(AddMonumentShapeRequest $request){

        try {

            $monumentShape = json_decode($request->data, true);
            $title = $monumentShape['shape_title'];
            $record = MonumentShape::whereShapeTitle($title)->exists();
            if ($record)
                return response()->json(['errorInfo' => ['The Shape name already exists']], 200);

            $monumentShapeInstance = MonumentShape::updateOrCreate(['id' => $monumentShape['id']], $monumentShape);

            return response()->json($monumentShapeInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentShape $monumentShape){

        return response()->json($monumentShape);
    }

    public function destroy(MonumentShape $monumentShape){

        return $monumentShape->delete();
    }

    public function getColumns(){

        $monumentShape = new MonumentShape;
        $monumentShape = $monumentShape->getTableColumns();
        $data = [];
        $data['monumentShape'] = $monumentShape;
        return response()->json($data);
    }

    public function search(AddMonumentShapeRequest $request){

        $monumentShape = new MonumentShape;
        $request = $request->all();
        $monumentShape = $this->searchQuery($monumentShape, $request,'MonumentShape');
        return $monumentShape->orderBy('id', 'desc')->get();
    }

}
