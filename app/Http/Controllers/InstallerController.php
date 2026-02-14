<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddInstallerRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\InstallationDailyLoadList;
use App\Models\Installer;
use Exception;
use Illuminate\Http\Request;

class InstallerController extends Controller
{
    use Searchable, Paginateable, FileUpload, Accessible;

    public $relations = ['dailyLoadList.order.invoice', 'dailyLoadList.order.family'];

    public function index()
    {
        $installers = new Installer();
        $installers = $installers->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($installers);
    }

    public function store(AddInstallerRequest $request)
    {
        try {
            $data = json_decode($request->data, true);
            $recordInstance = Installer::updateOrCreate(['id' => $data['id']], $data);
            if (count($data['daily_load_list']) > 0) {
                foreach ($data['daily_load_list'] as $item) {
                    if (count($this->arrayCount($item)) > 0) {
                        $childRecord = InstallationDailyLoadList::updateOrCreate(['id' => $item['id']], $item);
                        $recordInstance->dailyLoadList()->save($childRecord);
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

    public function show(Installer $installer)
    {
        $installer->load($this->relations);
        return response()->json($installer);
    }

    public function destroy(Installer $installer)
    {
        return $installer->delete();
    }

    public function getColumns()
    {
        $installer = new Installer();
        $installer = $installer->getTableColumns();
        $data = [];
        $data['installer'] = $installer;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $installer = new Installer();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $installer = $this->searchQuery($installer, $request, 'Installer');
        return response()->json($this->getDataWithPagination($installer, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
//        return $installer->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function paginationRecord()
    {
        $installers = new Installer();
        return response()->json($this->getDataWithPagination($installers, 'id', $this->relations, '', '', 'desc'));
    }

    public function installerOrder()
    {
        return $this->productionOrder();
    }

    public function dropDownInfo()
    {
        $records = Installer::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function getNext(Installer $installer)
    {
        return $this->nextRecord(new Installer, $this->relations, $installer->id, 'desc');
    }

    public function getPrevious(Installer $installer)
    {
        return $this->previousRecord(new Installer, $this->relations, $installer->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new Installer, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Installer, $this->relations, 'asc');
    }
}
