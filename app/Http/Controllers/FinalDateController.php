<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddFinalDateRequest;
use App\Http\Traits\Searchable;
use App\Models\FinalDate;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class FinalDateController extends Controller
{
    use Searchable;

    public function index(){
        $finalDate = new FinalDate;
        return response()->json($finalDate->with(['order.family','order.invoice'])->get());
    }

    public function store(AddFinalDateRequest $request){
        try {

            $finalDate = json_decode($request->data, true);

            $finalDateInstance = FinalDate::updateOrCreate(['id' => $finalDate['id']], $finalDate);

            $finalDateInstance->load(['order.family','order.invoice']);
            return response()->json($finalDateInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(FinalDate $finalDate){
        $finalDate->load(['order.family','order.invoice']);
        return response()->json($finalDate);
    }

    public function destroy(FinalDate $finalDate){
        return $finalDate->delete();
    }
}
