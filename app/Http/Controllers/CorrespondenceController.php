<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCorrespondenceRequest;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Correspondence;
use App\Models\CorrespondenceTask;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;

class CorrespondenceController extends Controller
{
    use Searchable,Paginateable,FileUpload;
    public $relations = [];

    public function index(){
        $correspondences = new Correspondence();
        $correspondences = $correspondences->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($correspondences);
    }

    public function store(AddCorrespondenceRequest $request){
        try {
            $correspondence = json_decode($request->data, true);

            $correspondenceInstance = Correspondence::updateOrCreate(['id' => $correspondence['id']], $correspondence);

            $correspondenceInstance->save();
            $correspondenceInstance->load($this->relations);
            return response()->json($correspondenceInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Correspondence $correspondence){
        // Belongs To relation throws exception when related record does not exists error:(Illegal offset type in isset or empty)
        // so, first checking here if relation exists then load it
//        if ($correspondence->user()->exists()){
//            $correspondence->load(['user', 'family']);
//        }
        $correspondence->load($this->relations);
        return response()->json($correspondence);
    }

    public function destroy(Correspondence $correspondence){
        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */

        return $correspondence->delete();
    }

    public function getColumns(){
        $correspondence = new Correspondence();
        $invoice = new Invoice();
        $correspondence = $correspondence->getTableColumns();
        $invoice = $invoice->getTableColumns();

        $data = [];
        $data['correspondence'] = $correspondence;
        $data['invoice'] = $invoice;
        return response()->json($data);
    }

    public function search(Request $request){
        $correspondence = new Correspondence();
        $correspondence = $this->searchQuery($correspondence, $request,'Correspondence');
        return $correspondence->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function deleteTask(CorrespondenceTask $task){
        try{
            return response()->json($task->delete());
        }catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

}
