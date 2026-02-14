<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddInstallationProductionRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\InstallationProduction;
use App\Models\InstallationProductionList;
use Exception;
use Illuminate\Http\Request;

class InstallationProductionController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['installProductionList.order.invoice', 'installProductionList.order.family'];

    public function index()
    {
        $installationProductions = new InstallationProduction();
        $installationProductions = $installationProductions->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($installationProductions);
    }

    public function paginationRecord()
    {
        $records = new InstallationProduction();
        return response()->json($this->getDataWithPagination($records, 'id', $this->relations, '', '', 'desc'));
    }

    public function store(AddInstallationProductionRequest $request)
    {
        try {
            $data = json_decode($request->data, true);
            $recordInstance = InstallationProduction::updateOrCreate(['id' => $data['id']], $data);
            if (count($data['install_production_list']) > 0) {
                foreach ($data['install_production_list'] as $item) {
                    if (count($this->arrayCount($item)) > 0) {
                        $childRecord = InstallationProductionList::updateOrCreate(['id' => $item['id']], $item);
                        $recordInstance->installProductionList()->save($childRecord);
                    }
                }
            }
            $recordInstance->save();
            $recordInstance->load($this->relations);
            return response()->json($recordInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != null;
        });
        return $arrCount;
    }

    public function show(InstallationProduction $installationProduction)
    {
        $installationProduction->load($this->relations);
        return response()->json($installationProduction);
    }

    public function destroy(InstallationProduction $installationProduction)
    {
        return $installationProduction->delete();
    }

    public function getColumns()
    {
        $installationProduction = new InstallationProduction();
        $installationProduction = $installationProduction->getTableColumns();
        $data = [];
        $data['Installation Production'] = $installationProduction;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $installationProduction = new InstallationProduction();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $installationProduction = $this->searchQuery($installationProduction, $request, 'InstallationProduction');
        return response()->json($this->getDataWithPagination($installationProduction, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
    }

    public function installerProductionOrder()
    {
        return $this->productionOrder();
    }

    public function dropDownInfo()
    {
        $records = InstallationProduction::select('id', 'week_of')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function getNext(InstallationProduction $production)
    {
        return $this->nextRecord(new InstallationProduction, $this->relations, $production->id, 'desc');
    }

    public function getPrevious(InstallationProduction $production)
    {
        return $this->previousRecord(new InstallationProduction, $this->relations, $production->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new InstallationProduction, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new InstallationProduction, $this->relations, 'asc');
    }

}
