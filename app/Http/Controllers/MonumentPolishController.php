<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Models\MonumentPolish;
use Illuminate\Http\Request;
use App\Http\Traits\Accessible;
use App\Http\Traits\Searchable;
use Exception;
use Illuminate\Database\QueryException;

class MonumentPolishController extends Controller
{
    use Searchable, Accessible;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response as JSON Object
     */
    public function index()
    {
        $monumentPolish = new MonumentPolish;
        return response()->json($monumentPolish->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        try{
            $monumentPolish = json_decode($request->data, true);
            $title = $monumentPolish['product_polish_title'];
            $record = MonumentPolish::whereProductPolishTitle($title)->exists();
            if ($record)
                return response()->json(['errorInfo' => ['The polish name already exists']],200);

            $monumentPolishInstance =  MonumentPolish::updateOrCreate(['id'=>$monumentPolish['id']], $monumentPolish);
             return response()->json($monumentPolishInstance);

        }catch (Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MonumentPolish  $monumentPolish
     * @return \Illuminate\Http\Response
     */
    public function show(MonumentPolish $monumentPolish)
    {
        return response()->json($monumentPolish);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MonumentPolish  $monumentPolish
     * @return \Illuminate\Http\Response
     */
    public function edit(MonumentPolish $monumentPolish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MonumentPolish  $monumentPolish
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MonumentPolish $monumentPolish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MonumentPolish  $monumentPolish
     * @return \Illuminate\Http\Response
     */
    public function destroy(MonumentPolish $monumentPolish)
    {
       return $monumentPolish->delete();
    }

    public function getColumns(){

        $monumentPolish = new MonumentPolish();
        $monumentPolish = $monumentPolish->getTableColumns();
        $data = [];
        $data['monumentPolish'] = $monumentPolish;
        return response()->json($data);
    }


    public function search(Request $request){
        $monumentPolish = new MonumentPolish();
        $request = $request->all();
        $monumentPolish = $this->searchQuery($monumentPolish, $request,'MonumentPolish');
        return $monumentPolish->orderBy('id', 'desc')->get();
    }
}
