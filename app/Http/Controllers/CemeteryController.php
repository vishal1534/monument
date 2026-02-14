<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCemeteryRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Cemetery;
use App\Models\CemeteryCategory;
use App\Models\CemeteryFile;
use App\Models\CemeteryRegulation;
use App\Models\City;
use App\Models\County;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;

class CemeteryController extends Controller
{
    use FileUpload, Searchable, Paginateable, Accessible;

    public $relations = ['regulation', 'files', 'category', 'city', 'state', 'county'];


    public function index()
    {

        $cemetery = new Cemetery();
        $cemetery = $cemetery->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($cemetery);
    }

    public function paginationRecord()
    {
        $cemetery = new Cemetery();
        return response()->json($this->getDataWithPagination($cemetery, 'id', $this->relations, '', '', 'desc'));
    }

    public function dropDownInfo()
    {
        $cemetery = Cemetery::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($cemetery);
    }

    public function cemeteryInfo($id)
    {

        $counties = County::select('id', 'county_title')->get();
        $states = State::select('id', 'state_title')->get();
        $cities = null;
        if ($id) {
            $cities = City::select('id', 'city_title')->where('state_id', $id)->get();
        } else {
            $cities = City::select('id', 'city_title')->get();
        }
        $categories = CemeteryCategory::select('id', 'title')->get();
        return compact('counties', 'categories', 'states', 'cities');
    }

    public function cemeteryCityInfo($id)
    {

        $cities = City::select('id', 'city_title')->where('state_id', $id)->get();
        return compact('cities');
    }

    public function store(AddCemeteryRequest $request)
    {
        /* $data= json_decode($request->data, true);

        if(($data['id'] == 0 && !$this->isAccessible(['resource'=>'Cemetery','action'=>'create'])) || ($data['id'] > 0 && !$this->isAccessible(['resource'=>'Cemetery','action'=>'update'])))
            return response()->json(["message"=>"Sorry, You don't have an access"],403);*/

        try {

            $cemetery = json_decode($request->data, true);
            $regulation = $cemetery['regulation'];
            /**
             * @todo : commented below code because it will use to upload only single file but we need to upload multiple files.
             */
            /*if ($request->hasFile('image_file')) {
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'cemetery/';
                $uploadObj->module = 'cemetery';
                $file = $this->upload($uploadObj);
                $cemetery['image'] = $file->filenameToStore;
            }*/

            unset($cemetery['regulation']);
//            $cemetery['store_id'] = Auth::user()->store_id;
            $cemeteryInstance = Cemetery::updateOrCreate(['id' => $cemetery['id']], $cemetery);

            if ($request->hasFile('doc_files')) {
                foreach ($request->doc_files as $file) {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    $path = $file->storeAs('public/cemetery', $filenameToStore);
                    // Store in DB
                    $document = new CemeteryFile();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $cemeteryInstance->files()->save($document);
                }
            }
            //if (count($this->arrayCount($regulation)) > 0){
            $cemeteryInstance->regulation()->updateOrCreate(
                ['id' => $regulation['id']],
                $regulation
            );
            // }
            $cemeteryInstance->save();
            $cemeteryInstance->load($this->relations);
            return response()->json($cemeteryInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Cemetery $cemetery)
    {

        $cemetery->load($this->relations);
        return response()->json($cemetery);
    }

    public function destroy(Cemetery $cemetery)
    {
        if (isset($cemetery->cemetery_image)) {
            $filePath = public_path('cemetery') . $cemetery->cemetery_image;
            if (file_exists($filePath))
                unlink($filePath);
        }
        return $cemetery->delete();

    }

    public function getColumns()
    {

        $cemetery = new Cemetery();
        $regulation = new CemeteryRegulation();
        $category = new CemeteryCategory();
        $city = new City();
        $county = new County();
        $state = new State();

        $cemetery = $cemetery->getTableColumns();
        $regulation = $regulation->getTableColumns();
        $category = $category->getTableColumns();
        $city = $city->getTableColumns();
        $county = $county->getTableColumns();
        $state = $state->getTableColumns();

        $data = [];
        $data['cemetery'] = $cemetery;
        $data['regulation'] = $regulation;
        $data['category'] = $category;
        $data['city'] = $city;
        $data['county'] = $county;
        $data['state'] = $state;

        return response()->json($data);
    }

    public function search(Request $request)
    {
        $cemetery = new Cemetery;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $childTableName = $queryData->childTableName;
        $foreignKey = $queryData->foreignKey;
        $pagePerPage = $queryData->pagePerPage;
        $childClassName = '\App\Models' . $queryData->childClassName;
        $childClassName = str_replace('\\\\', '\\', $childClassName);
        unset($request['queryData']);
        unset($request['page']);
        $cemetery = $this->searchQuery($cemetery, $request, 'Cemetery');
        if ($columnTableName == 'cemetery') {
            return response()->json($this->getDataWithPagination($cemetery, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($cemetery, $this->relations, $childClassName, $sortByColumn, 'cemeteries', $foreignKey, $sortDirection, $pagePerPage);
        } else if ($columnTableName == 'idInChildTable') {
            return $this->sortRelationalTable($cemetery, $this->relations, $childClassName, $sortByColumn, $childTableName, $sortDirection, 'cemetery', 'cemeteries', 'cemetery_id', 'id', $pagePerPage);
        }
    }

    public function findCompany(Request $request)
    {
        $cemetery = new Cemetery;
        $cemetery = $cemetery->with($this->relations)
            ->where('company', 'LIKE', $request->company)
            ->get();
        return response()->json($cemetery);
    }

    public function showCompanies(Request $request)
    {
        $cemetery = new Cemetery;
        $cemetery = $cemetery->where('company', 'LIKE', '%' . $request->company . '%')
            ->distinct()
            ->orderBy('company', 'asc')
            ->get(['company']);
        return response()->json($cemetery);
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($item) {
            return $item != 0 && $item != null;
        });
        return $arrCount;
    }

    public function deleteFile($id)
    {
        try {
            $file = CemeteryFile::findOrFail($id);
            $file_path = "images/cemetery/" . $file->file;
            if (file_exists($file_path))
                unlink($file_path);
            return response()->json($file->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function saveCategory(Request $request)
    {
        $data = json_decode($request->data, true);
        $category = CemeteryCategory::updateOrCreate(['id' => $data['id']], $data);
        $category->save();
        return response()->json($category);
    }

    public function deleteCategory(CemeteryCategory $cemeteryCategory)
    {
        return $cemeteryCategory->delete();
    }

    public function getFirst()
    {
        return $this->firstRecord(new Cemetery, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Cemetery, $this->relations, 'asc');
    }

    public function getNext(Cemetery $cemetery)
    {
        return $this->nextRecord(new Cemetery, $this->relations, $cemetery->id, 'desc');
    }

    public function getPrevious(Cemetery $cemetery)
    {
        return $this->previousRecord(new Cemetery, $this->relations, $cemetery->id);
    }

}
