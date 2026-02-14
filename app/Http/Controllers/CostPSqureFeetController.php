<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\CostPSqureFeet;
use App\Models\Monument;
use App\Models\ProductSpecification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CostPSqureFeetController extends Controller
{
    use Searchable, Paginateable;


    public function index()
    {
        $records = new CostPSqureFeet();
        return response()->json($this->getDataWithPagination($records, 'id', [], '', '', 'desc'));
    }

    public function store(Request $request)
    {
        try {
            $record = json_decode($request->data, true);
            $validator = Validator::make($record, [
                'granite_description' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $recordInstance = CostPSqureFeet::updateOrCreate(['id' => $record['id']], $record);
            if (isset($record['id']) && !empty($record['id']) && $recordInstance->wasChanged('granite_sq_ft_price')) {
                $monumentIds = Monument::where('cost_p_squ_ft_id', $record['id'])->pluck('id')->toArray();
                foreach ($monumentIds as $id) {
                    ProductSpecification::whereMonumentId($id)->update(['cost_per_square_ft' => $record['granite_sq_ft_price']]);
                }
            }
            return response()->json($recordInstance);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function show(CostPSqureFeet $costPerSqureFeet)
    {
        return response()->json($costPerSqureFeet);
    }


    public function destroy(CostPSqureFeet $costPerSqureFeet)
    {
        return $costPerSqureFeet->delete();
    }

    public function getColumns()
    {
        $record = new CostPSqureFeet();
        $record = $record->getTableColumns();
        $data = [];
        $data['CostPSqureFeet'] = $record;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $record = new CostPSqureFeet();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $record = $this->searchQuery($record, $request, 'CostPSqureFeet');
        return response()->json($this->getDataWithPagination($record, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
    }

    public function dropDownInfo()
    {
        $record = CostPSqureFeet::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($record);
    }

    public function getNext(CostPSqureFeet $feet)
    {
        return $this->nextRecord(new CostPSqureFeet, [], $feet->id, 'desc');
    }

    public function getPrevious(CostPSqureFeet $feet)
    {
        return $this->previousRecord(new CostPSqureFeet, [], $feet->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new CostPSqureFeet, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new CostPSqureFeet, [], 'asc');
    }
}
