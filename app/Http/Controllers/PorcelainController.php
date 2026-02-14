<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddPorcelainRequest;
use App\Http\Traits\Searchable;
use App\Models\Porcelain;
use App\Models\PorcelainFormat;
use App\Models\PorcelainOrientation;
use App\Models\PorcelainPart;
use App\Models\PorcelainShape;
use App\Models\PorcelainSize;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;

class PorcelainController extends Controller
{
    use Searchable;

    public function index(){
        $porcelain = new Porcelain;
        return response()->json($porcelain->with(['order.family','order.invoice'])->get());
    }

    public function store(AddPorcelainRequest $request){
        try {

            $porcelain = json_decode($request->data, true);

            $porcelainInstance = Porcelain::updateOrCreate(['id' => $porcelain['id']], $porcelain);

            $porcelainInstance->load(['order.family','order.invoice']);
            return response()->json($porcelainInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Porcelain $porcelain){
        $porcelain->load(['order.family','order.invoice']);
        return response()->json($porcelain);
    }

    public function destroy(Porcelain $porcelain){
        return $porcelain->delete();
    }
    public function porcelainInfo(){
        $formats = PorcelainFormat::select('id', 'title')->get();
        $parts = PorcelainPart::select('id', 'title')->get();
        $size = PorcelainSize::select('id', 'title')->get();
        $shapes = PorcelainShape::select('id', 'title')->get();
        $orientations = PorcelainOrientation::select('id', 'title')->get();

        return compact('formats','parts','size', 'shapes','orientations');
    }
}
