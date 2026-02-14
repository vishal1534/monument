<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentSideRequest;
use App\Http\Traits\Accessible;
use App\Models\MonumentSide;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class MonumentSideController extends Controller{

    use Searchable,Accessible;

    public function index(){

        $monumentSide = new MonumentSide;
        return response()->json($monumentSide->get());
    }

    public function store(AddMonumentSideRequest $request){

        try {

            $monumentSide = json_decode($request->data, true);
            $title = $monumentSide['side_title'];
            $record = MonumentSide::whereSideTitle($title)->exists();
            if ($record)
                return response()->json(['errorInfo' => ['The Side name already exists']], 200);

            $monumentSideInstance = MonumentSide::updateOrCreate(['id' => $monumentSide['id']], $monumentSide);

            return response()->json($monumentSideInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentSide $monumentSide){

        return response()->json($monumentSide);
    }

    public function destroy(MonumentSide $monumentSide){

        return $monumentSide->delete();
    }

    public function getColumns(){

        $monumentSide = new MonumentSide;
        $monumentSide = $monumentSide->getTableColumns();
        $data = [];
        $data['monumentSide'] = $monumentSide;
        return response()->json($data);
    }

    public function search(AddMonumentSideRequest $request){

        $monumentSide = new MonumentSide;
        $request = $request->all();
        $monumentSide = $this->searchQuery($monumentSide, $request,'MonumentSide');
        return $monumentSide->orderBy('id', 'desc')->get();
    }

}
