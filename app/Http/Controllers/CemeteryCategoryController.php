<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\CemeteryCategory;
use Exception;
use Illuminate\Http\Response;

class CemeteryCategoryController extends Controller
{
    use Searchable,Paginateable, Accessible;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $cemeteryCategory = new CemeteryCategory;
        return response()->json($cemeteryCategory->get());
    }

    /**
     * Show the form for creating a new resource.
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $cemeteryCategory = json_decode($request->data, true);
            $categoryInstance = CemeteryCategory::updateOrCreate(['id' => $cemeteryCategory['id']], $cemeteryCategory);
            return response()->json($categoryInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param CemeteryCategory $category
     *
     * @return JsonResponse
     */
    public function show(CemeteryCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return void
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @todo : In this destroy method we need to pass same parameter name as in api resource name otherwise destroy will not work.
     * Remove the specified resource from storage.
     *
     * @param CemeteryCategory $cemeteryCategory
     *
     * @return bool
     */
    public function destroy(CemeteryCategory $cemeteryCategory)
    {
        return $cemeteryCategory->delete();
    }

    /**
     * @return JsonResponse
     */
    function getColumns(){

        try {
            $cemeteryCategory = new CemeteryCategory;
            $cemeteryCategory = $cemeteryCategory->getTableColumns();
            $data = [];
            $data['cemeteryCategory'] = $cemeteryCategory;
            return response()->json($data);
        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }

    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    function search (Request $request)
    {

        try{
            $paperLocation = new CemeteryCategory();
            $request = $request->all();
            $paperLocation = $this->searchQuery($paperLocation, $request,'CemeteryCategory');
            return $paperLocation->orderBy('id', 'desc')->get();
        }catch (Exception $ex)
        {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }
}
