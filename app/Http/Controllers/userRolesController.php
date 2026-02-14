<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddUserRoleRequest;
use App\Http\Traits\Helpers;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class userRolesController extends Controller
{
    use Searchable,Paginateable,Helpers;
    public $relations = [];

    public function index(){
        $records = new UserRole();
        $records = $records->with($this->relations)
            ->where('title','not like','Supper Admin')
            ->where('title','not like','Admin')
            ->orderBy('id', 'asc')->get();
        return response()->json($records);
    }

    public function store(AddUserRoleRequest $request){
        try {
            $data = json_decode($request->data, true);
            if (isset($data['title']) && !empty($data['title']))
            {

//            'email' => ["unique:users,email,".$user['id'].",id"],
                $rules = [
                    "title" => ["unique:user_roles,title,".$data['id'].",id"],
                ];

                $validator = validator::make($data, $rules);
                if ($validator->fails())
                    return response()->json($validator->errors()->all());

                $recordInstance = UserRole::updateOrCreate(['id' => $data['id']], $data);

                $recordInstance->save();
                $recordInstance->load($this->relations);
                return response()->json($recordInstance);
            }else{
                return response()->json([
                    '0' => "Title Cannot be empty"
                ]);
            }

        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(UserRole $userRole){
        $userRole->load($this->relations);
        return response()->json($userRole);
    }

    public function destroy(UserRole $userRole){

        return $userRole->delete();
    }

    public function getColumns(){
        $userRole = new UserRole();
        $userRole = $userRole->getTableColumns();

        $data = [];
        $data['userRole'] = $userRole;
        return response()->json($data);
    }

    public function search(Request $request){
        $record = new UserRole;
        $request = $request->all();

        $record = $this->searchQuery($record, $request,'UserRole');
        return $record->with($this->relations)
            ->where('title','not like','Supper Admin')
            ->where('title','not like','Admin')
            ->orderBy('id', 'desc')->get();
    }
}
