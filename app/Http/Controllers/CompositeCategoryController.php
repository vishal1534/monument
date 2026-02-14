<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCompositeCategoryRequest;
use App\Http\Traits\Accessible;
use App\Models\CompositeCategory;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class CompositeCategoryController extends Controller{

    use Searchable, Accessible;

    public function index(){

        $compositeCategory = new CompositeCategory;
        return response()->json($compositeCategory->get());
    }

    public function store(AddCompositeCategoryRequest $request){
        try {

            $compositeCategory = json_decode($request->data, true);

            $categoryInstance = CompositeCategory::updateOrCreate(['id' => $compositeCategory['id']], $compositeCategory);

            return response()->json($categoryInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(CompositeCategory $compositeCategory){

        return response()->json($compositeCategory);
    }

    public function destroy(CompositeCategory $compositeCategory){

        return $compositeCategory->delete();
    }

    public function getColumns(){

        $compositeCategory = new CompositeCategory;
        $compositeCategory = $compositeCategory->getTableColumns();
        $data = [];
        $data['compositeCategory'] = $compositeCategory;
        return response()->json($data);
    }

    public function search(AddCompositeCategoryRequest $request){

        $compositeCategory = new CompositeCategory;
        $request = $request->all();
        $compositeCategory = $this->searchQuery($compositeCategory, $request,'CompositeCategory');
        return $compositeCategory->orderBy('id', 'desc')->get();
    }

}
