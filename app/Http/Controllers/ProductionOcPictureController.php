<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddProductionOcPictureRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Helpers;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Order;
use App\Models\ProductionOcPicture;
use App\Models\ProductionOcPictureList;
use Exception;
use Illuminate\Http\Request;

class ProductionOcPictureController extends Controller
{
    use Searchable, Paginateable, FileUpload, Helpers, Accessible;

    public $relations = ['pictureList.order.invoice', 'pictureList.order.family'];

    public function index()
    {
        $productionOcPictures = new ProductionOcPicture();
        $productionOcPictures = $productionOcPictures->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($productionOcPictures);
    }

    public function paginationRecord()
    {
        $records = new ProductionOcPicture();
        return response()->json($this->getDataWithPagination($records, 'id', $this->relations, '', '', 'desc'));
    }

    public function jwtStore(AddProductionOcPictureRequest $request)
    {
        try {
            $data = $request->all();
            $productionOcPictureInstance = ProductionOcPicture::updateOrCreate(['id' => $data['id']], $data);
            $data['production_oc_picture_id'] = $productionOcPictureInstance->id;
            $pictureInstance = ProductionOcPictureList::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($pictureInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }


    public function store(AddProductionOcPictureRequest $request)
    {
        try {
            $data = json_decode($request->data, true);
            $productionOcPictureInstance = ProductionOcPicture::updateOrCreate(['id' => $data['id']], $data);
            $entries = 0;
            if (count($data['picture_list']) > 0) {
                foreach ($data['picture_list'] as $picture) {
                    if (count($this->arrayCount($picture)) > 0) {
                        $entries++;
                        $pictureInstance = ProductionOcPictureList::updateOrCreate(['id' => $picture['id']], $picture);
                        $productionOcPictureInstance->pictureList()->save($pictureInstance);
                    }
                }
            }

            $productionOcPictureInstance->total_entries = $entries;
            $productionOcPictureInstance->save();
            $productionOcPictureInstance->load($this->relations);
            return response()->json($productionOcPictureInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show($id)
    {
        $productionOcPicture = ProductionOcPicture::with($this->relations)->find($id);
        $productionOcPicture->load($this->relations);
        return response()->json($productionOcPicture);
    }

    public function destroy($id)
    {
        $productionOcPicture = ProductionOcPicture::find($id);

        foreach ($productionOcPicture->pictureList as $item) {
            $item->delete();
        }

        return $productionOcPicture->delete();
    }

    public function getColumns()
    {
        $productionOcPicture = new ProductionOcPicture();

        $data = [];
        $data['Production Picture'] = $productionOcPicture->getTableColumns();
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $productionOcPicture = new ProductionOcPicture;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $productionOcPicture = $this->searchQuery($productionOcPicture, $request, 'ProductionPicture');
        return response()->json($this->getDataWithPagination($productionOcPicture, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
//        return $productionOcPicture->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function dropDownInfo()
    {
        $records = ProductionOcPicture::select('id', 'week_of')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function pictureOrder()
    {
        return $this->productionOrder();
    }

    public function getNext(ProductionOcPicture $ocPicture)
    {
        return $this->nextRecord(new ProductionOcPicture, $this->relations, $ocPicture->id, 'desc');
    }

    public function getPrevious(ProductionOcPicture $ocPicture)
    {
        return $this->previousRecord(new ProductionOcPicture, $this->relations, $ocPicture->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new ProductionOcPicture, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new ProductionOcPicture, $this->relations, 'asc');
    }
}
