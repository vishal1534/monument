<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentColorRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Models\MonumentColor;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class MonumentColorController extends Controller{

    use Searchable,Paginateable,Accessible;

    public function index(){

        $monumentColor = new MonumentColor;
        return response()->json($monumentColor->get());
    }

    public function store(AddMonumentColorRequest $request){

        try {

            $monumentColor = json_decode($request->data, true);
            $title = $monumentColor['color_title'];
            $record = MonumentColor::whereColorTitle($title)->exists();
            if($record)
                return response()->json(['errorInfo' => ['The Color name already exists']], 200);

            $monumentColorInstance = MonumentColor::updateOrCreate(['id' => $monumentColor['id']], $monumentColor);

            return response()->json($monumentColorInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentColor $monumentColor){
        return response()->json($monumentColor);
    }

    public function destroy(MonumentColor $monumentColor){
        return $monumentColor->delete();
    }

    public function getColumns(){

        $monumentColor = new MonumentColor;
        $monumentColor = $monumentColor->getTableColumns();
        $data = [];
        $data['monumentColor'] = $monumentColor;
        return response()->json($data);
    }

    public function search(AddMonumentColorRequest $request){
        $monumentColor = new MonumentColor;
        $request = $request->all();
        $monumentColor = $this->searchQuery($monumentColor, $request,'MonumentColor');
        return $monumentColor->orderBy('id', 'desc')->get();
    }
}
