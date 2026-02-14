<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddServiceRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceFile;
use App\Models\ServiceImage;
use App\Models\ServiceInventory;
use Exception;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use FileUpload, Searchable, Accessible, Paginateable;

    public $relation = ['category', 'serviceInventory', 'saleHistory.serviceInvoice.order.family', 'saleHistory.serviceInvoice.order.company', 'files', 'images'];

    public function index()
    {
        $service = new Service();
        $service = $service->with($this->relation)->orderBy('product_number', 'desc')->get();
        return response()->json($service);
    }

    public function getRecordPagination()
    {
        $service = new Service();
        return response()->json($this->getDataWithPagination($service, 'product_number', $this->relation));
    }

    public function serviceInfo()
    {
        $category = new ServiceCategory();
        return response()->json($category->get());
    }

    public function store(AddServiceRequest $request)
    {
        $service = json_decode($request->data, true);
        if ($service['id'] == 0) {
            if ($this->isProductNumberExist($service['product_number'])) {
                return response()->json(["errorInfo" => ["Duplicate entry '" . $service['product_number'] . "' for key 'product_number'"]], 200);
            }
        } else {
            $className = Service::class;
            if ($this->productNoForUpdate($className, $service['id'], $service['product_number']))
                return response()->json(["errorInfo" => ["Duplicate entry '" . $service['product_number'] . "' for key 'product_number'"]], 200);
        }
        try {
            $serviceInventory = null;
            if (isset($service['service_inventory']))
                $serviceInventory = $service['service_inventory'];
            if ($request->hasFile('image_file')) {
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'service/';
                $uploadObj->module = 'service';
                $file = $this->upload($uploadObj);
                $service['image'] = $file->filenameToStore;
            }
            $serviceInstance = Service::updateOrCreate(['id' => $service['id']], $service);
            if (!empty($serviceInventory) && sizeof($serviceInventory) > 0) {
                foreach ($serviceInventory as $key => $value) {
                    $inventory = [];
                    $inventory['id'] = $serviceInventory[$key]['id'];
                    $inventory['qty_add_or_remove'] = $serviceInventory[$key]['qty_add_or_remove'];
                    $inventory['by_whom'] = $serviceInventory[$key]['by_whom'];
                    if ($value['id'] != 0) {
                        $inventory['total'] = $serviceInventory[$key]['total'];
                    }
                    if ($value['id'] == 0) {
                        $className = ServiceInventory::class;
                        $total = $this->getTotal($className, 'service_id', $serviceInstance->id);
                        $inventory['total'] = $value['qty_add_or_remove'] + $total;
                        $inventory['date'] = $this->changeDateFormat($serviceInventory[$key]['date']);
                        if ($serviceInstance->total_added == null) {
                            $serviceInstance->total_added = $value['qty_add_or_remove'];
                            $serviceInstance->save();
                        } else {
                            $serviceInstance->increment('total_added', $value['qty_add_or_remove']);
                        }
                    }
                    $serviceInstance->serviceInventory()->updateOrCreate(['id' => $inventory['id']], $inventory);
                    unset($inventory);
                }
            }
            if ($request->hasFile('doc_images')) {
                foreach ($request->doc_images as $file) {
                    // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just extension
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    // Filename to store
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $file->storeAs('public/service', $filenameToStore);
                    // Store in DB
                    $document = new ServiceImage();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $serviceInstance->images()->save($document);
                }
            }
            if ($request->hasFile('doc_files')) {
                foreach ($request->doc_files as $file) {
                    // Get filename with the extension
                    $filenameWithExt = $file->getClientOriginalName();
                    // Get just filename
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    // Get just extension
                    $extension = pathinfo($filenameWithExt, PATHINFO_EXTENSION);
                    // Filename to store
                    $filenameToStore = $filename . '_' . time() . '.' . $extension;
                    // Upload Image
                    $path = $file->storeAs('public/service', $filenameToStore);
                    // Store in DB
                    $document = new ServiceFile();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $serviceInstance->files()->save($document);
                }
            }
            $serviceInstance->total_on_hand = $serviceInstance->total_added - $serviceInstance->total_sold;
            $serviceInstance->save();
            return response()->json($serviceInstance->load($this->relation));
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Service $service)
    {
        return response()->json($service->load($this->relation));
    }

    public function destroy(Service $service)
    {
        /* if(isset($service->image)){
             $imagePath = "images/service/".$service->image;;
             if (file_exists($imagePath))
                 unlink($imagePath);
         }*/
        $service->products()->delete();
        $service->compositeProducts()->delete();
        return $service->delete();
    }

    public function getColumns()
    {
        $service = new Service();
        $category = new ServiceCategory();
        $service = $service->getTableColumns();
        $category = $category->getTableColumns();
        $data = [];
        $data['service'] = $service;
        $data['category'] = $category;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $service = new Service();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $childClassName = '\App\Models' . $queryData->childClassName;
        $childClassName = str_replace('\\\\', '\\', $childClassName);
        $foreignKey = $queryData->foreignKey;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $service = $this->searchQuery($service, $request, 'Service');
        if ($columnTableName == 'service') {
            return response()->json($this->getDataWithPagination($service, $sortByColumn, $this->relation, 'products', 'amount', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($service, $this->relation, $childClassName, $sortByColumn, 'services', $foreignKey, $sortDirection, $pagePerPage);
        }
    }

    public function serviceSearch(Request $request)
    {
        $service = new Service();
        $request = $request->all();
        $service = $this->searchQuery($service, $request, 'Service');
        return $service->withSum('products', 'amount')->with(['category'])->orderBy('id', 'desc')->get();
    }

    public function deleteImage($id)
    {
        try {
            $file = ServiceImage::findOrFail($id);
            $file_path = "images/service/" . $file->file;
            if (file_exists($file_path))
                unlink($file_path);
            return response()->json($file->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteFile($id)
    {
        try {
            $file = ServiceFile::findOrFail($id);
            $file_path = "images/service/" . $file->file;
            if (file_exists($file_path))
                unlink($file_path);
            return response()->json($file->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getDropDown()
    {
        $service = Service::select('id', 'product_number')->get();
        return response()->json($service);
    }

    public function getNextPrevious(Service $service)
    {
        return $this->nextPreviousRecord(new Service, $this->relation, $service->id);
    }

}
