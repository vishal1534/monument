<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentOrderNotesRequest;
use App\Http\Traits\Searchable;
use App\Models\MonumentOrderNotes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class MonumentOrderNotesController extends Controller
{
    use Searchable;

    public function index(){
        $monumentOrderNotes = new MonumentOrderNotes;
        return response()->json($monumentOrderNotes->with(['order.family','order.invoice'])->get());
    }

    public function store(AddMonumentOrderNotesRequest $request){
        try {

            $monumentOrderNotes = json_decode($request->data, true);

            $monumentOrderNotesInstance = MonumentOrderNotes::updateOrCreate(['id' => $monumentOrderNotes['id']], $monumentOrderNotes);

            $monumentOrderNotesInstance->load(['order.family','order.invoice']);
            return response()->json($monumentOrderNotesInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show($id){

        $monumentOrderNotes = MonumentOrderNotes::find($id);
        $monumentOrderNotes->load(['order.family','order.invoice']);
        return response()->json($monumentOrderNotes);
    }

    public function destroy(MonumentOrderNotes $monumentOrderNotes){
        return $monumentOrderNotes->delete();
    }

}
