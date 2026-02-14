<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\PaperLocation;
use Exception;
use Illuminate\Http\Request;

class PaperLocationController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public function index()
    {
        try {
            $paperLocation = new PaperLocation();
            return response()->json($paperLocation->orderBy('location_title', 'asc')->get());
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function paginationRecord()
    {
        $paperLocation = new PaperLocation();
        return response()->json($this->getDataWithPagination($paperLocation, 'location_title', [], '', '', 'asc'));
    }

    public function dropDownInfo()
    {
        $paperLocation = PaperLocation::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($paperLocation);
    }


    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $paperLocation = PaperLocation::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($paperLocation);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function show(PaperLocation $paperLocation)
    {
        try {
            return response()->json($paperLocation);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }

    }

    public function destroy($id)
    {
        try {
            return PaperLocation::where('id', $id)->delete();
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    function paperLocationInfo()
    {
        if (!$this->isAccessibleorClient(['resource' => 'Setting', 'action' => 'read']))
            return response()->json(["message" => "Sorry, You don't have an access!! "], 403);
        try {
            $paperLocation = new PaperLocation();
            return response()->json($paperLocation->orderBy('location_title', 'asc')->get());
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    function getColumns()
    {
        try {
            $paperLocation = new PaperLocation();
            $paperLocation = $paperLocation->getTableColumns();
            $data = [];
            $data['paperLocation'] = $paperLocation;
            return response()->json($data);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    function search(Request $request)
    {
        try {
            $paperLocation = new PaperLocation();
            $request = $request->all();
            $queryData = json_decode($request['queryData']);
            $queryData = $queryData[0];
            $sortDirection = $queryData->sortDirection;
            $sortByColumn = $queryData->sortByColumn;
            $pagePerPage = $queryData->pagePerPage;
            unset($request['queryData']);
            unset($request['page']);
            $paperLocation = $this->searchQuery($paperLocation, $request, 'PaperLocation');
            return response()->json($this->getDataWithPagination($paperLocation, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function getNext(PaperLocation $location)
    {
        return $this->nextRecord(new PaperLocation, [], $location->id, 'desc');
    }

    public function getPrevious(PaperLocation $location)
    {
        return $this->previousRecord(new PaperLocation, [], $location->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new PaperLocation, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new PaperLocation, [], 'asc');
    }
}
