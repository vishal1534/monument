<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddMonumentAgreementRequest;
use App\Http\Traits\Searchable;
use App\Models\MonumentAgreement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class MonumentAgreementController extends Controller
{
    use Searchable;

    public function index(){
        $monumentAgreement = new MonumentAgreement;
        return response()->json($monumentAgreement->get());
    }

    public function store(AddMonumentAgreementRequest $request){
        try {

            $monumentAgreement = json_decode($request->data, true);

            $monumentAgreementInstance = MonumentAgreement::updateOrCreate(['id' => $monumentAgreement['id']], $monumentAgreement);

            return response()->json($monumentAgreementInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(MonumentAgreement $monumentAgreement){
        return response()->json($monumentAgreement);
    }

    public function destroy(MonumentAgreement $monumentAgreement){
        return $monumentAgreement->delete();
    }
}
