<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use App\Http\Traits\Searchable;
use App\Models\CollaboratorType;
use App\Http\Traits\Accessible;
use App\Events\ProcessException;

class CollaboratorTypeController extends Controller
{
    use Searchable, Accessible;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $records = new CollaboratorType();
        return response()->json($records->orderBy('title', 'asc')->get());
    }


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
            $data = json_decode($request->data, true);
            $type = CollaboratorType::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($type);
        }catch (Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    /**
     * @param CollaboratorType $collaboratorType
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CollaboratorType $collaboratorType)
    {
        try{
            return response()->json($collaboratorType);
        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param CollaboratorType $collaboratorType
     *
     * @return bool|null
     */
    public function destroy(CollaboratorType $collaboratorType)
    {
        return $collaboratorType->delete();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getColumns(){
        $type = new CollaboratorType();
        $type = $type->getTableColumns();
        $data = [];
        $data['collaboratorType'] = $type;
        return response()->json($data);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request){
        $record = new CollaboratorType();
        $request = $request->all();
        $type = $this->searchQuery($record, $request, 'CollaboratorType');
        return $type->orderBy('title', 'asc')->get();
    }
}
