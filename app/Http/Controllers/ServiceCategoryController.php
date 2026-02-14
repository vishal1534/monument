<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddServiceCategoryRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Models\ServiceCategory;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class ServiceCategoryController extends Controller{

    use Searchable,Paginateable,Accessible;

    public function index(){
        $serviceCategory = new ServiceCategory;
        return response()->json($serviceCategory->get());
    }

    public function store(AddServiceCategoryRequest $request){

        try {

            $serviceCategory = json_decode($request->data, true);

            $categoryInstance = ServiceCategory::updateOrCreate(['id' => $serviceCategory['id']], $serviceCategory);

            return response()->json($categoryInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(ServiceCategory $serviceCategory){
        return response()->json($serviceCategory);
    }

    public function destroy(ServiceCategory $serviceCategory){
        return $serviceCategory->delete();
    }

    public function getColumns(){

        $serviceCategory = new ServiceCategory;
        $serviceCategory = $serviceCategory->getTableColumns();
        $data = [];
        $data['serviceCategory'] = $serviceCategory;
        return response()->json($data);
    }

    public function search(AddServiceCategoryRequest $request){

        $serviceCategory = new ServiceCategory;
        $request = $request->all();
        $serviceCategory = $this->searchQuery($serviceCategory, $request,'ServiceCategory');
        return $serviceCategory->orderBy('id', 'desc')->get();
    }

}
