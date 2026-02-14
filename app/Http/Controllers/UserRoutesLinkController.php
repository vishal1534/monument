<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\UserResource;
use Illuminate\Support\Facades\Validator;
use Exception;


class UserRoutesLinkController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public function index()
    {
        try{
            $resource = new UserResource();
            return response()->json($resource->get());
        }catch (Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }

    }

    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $rules = [
                "title" => ["unique:resources,title,".$data['id'].",id"],
            ];
            $validator = validator::make($data, $rules);
            if ($validator->fails())
                return response()->json($validator->errors()->all());

            $resource = UserResource::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($resource);

        }catch (Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }

    }

    public function show($id)
    {
        try {

            $resource = UserResource::where('id', $id)->get();
            return response()->json($resource);

        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }

    }


    public function destroy($id)
    {
        try{

            return UserResource::where('id', $id)->delete();

        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function resourcesInfo ()
    {
        try{
            $resource = new UserResource();
            return response()->json($resource->get());

        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function getColumns ()
    {
        try {
            $resource = new UserResource();
            $resource = $resource->getTableColumns();
            $data = [];
            $data["resource"] = $resource;
            return response()->json($data);

        }catch(Exception $ex){
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    function search (Request $request)
    {
        try{
            $resourceLinks = new UserResource();
            $request = $request->all();
            $resourceLinks = $this->searchQuery($resourceLinks, $request,'Resource');
            return $resourceLinks->orderBy('id', 'desc')->get();
        }catch (Exception $ex)
        {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }
}
