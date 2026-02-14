<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddSimpleCategoryRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Models\SimpleCategory;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class SimpleCategoryController extends Controller{

    use Searchable,Paginateable,Accessible;

    public function index(){

        $simpleCategory = new SimpleCategory;
        return response()->json($simpleCategory->get());
    }

    public function store(AddSimpleCategoryRequest $request){

        try {

            $simpleCategory = json_decode($request->data, true);

            $categoryInstance = SimpleCategory::updateOrCreate(['id' => $simpleCategory['id']], $simpleCategory);

            return response()->json($categoryInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(SimpleCategory $simpleCategory){

        return response()->json($simpleCategory);
    }

    public function destroy(SimpleCategory $simpleCategory){

        return $simpleCategory->delete();
    }

    public function getColumns(){
        $simpleCategory = new SimpleCategory;
        $simpleCategory = $simpleCategory->getTableColumns();
        $data = [];
        $data['simpleCategory'] = $simpleCategory;
        return response()->json($data);
    }

    public function search(AddSimpleCategoryRequest $request){

        $simpleCategory = new SimpleCategory;
        $request = $request->all();
        $simpleCategory = $this->searchQuery($simpleCategory, $request,'SimpleCategory');
        return $simpleCategory->orderBy('id', 'desc')->get();
    }

}
