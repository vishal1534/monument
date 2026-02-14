<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddSimpleRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Simple;
use App\Models\SimpleCategory;
use App\Models\SimpleFile;
use App\Models\SimpleImage;
use App\Models\SimpleInventory;
use Exception;
use Illuminate\Http\Request;

class SimpleController extends Controller
{
    use FileUpload, Searchable, Accessible, Paginateable;

    public $relation = ['category', 'simpleInventory', 'saleHistory.simpleInvoice.order.family', 'saleHistory.simpleInvoice.order.company', 'files', 'images'];

    public function index()
    {
        $simple = new Simple();
        $simple = $simple->with($this->relation)->orderBy('product_number', 'desc')->get();
        return response()->json($simple);
    }

    public function getRecordPagination()
    {
        $simple = new Simple();
        return response()->json($this->getDataWithPagination($simple, 'product_number', $this->relation));
    }

    public function simpleInfo()
    {
        $category = new SimpleCategory();
        return response()->json($category->get());
    }

    public function store(AddSimpleRequest $request)
    {
        $simple = json_decode($request->data, true);
        if ($simple['id'] == 0) {
            if ($this->isProductNumberExist($simple['product_number'])) {
                return response()->json(["errorInfo" => ["Duplicate entry '" . $simple['product_number'] . "' for key 'product_number'"]], 200);
            }
        } else {
            $className = Simple::class;
            if ($this->productNoForUpdate($className, $simple['id'], $simple['product_number']))
                return response()->json(["errorInfo" => ["Duplicate entry '" . $simple['product_number'] . "' for key 'product_number'"]], 200);
        }
        try {
            $simpleInventory = null;
            if (isset($simple['simple_inventory']))
                $simpleInventory = $simple['simple_inventory'];
            if ($request->hasFile('image_file')) {
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'simple/';
                $uploadObj->module = 'simple';
                $file = $this->upload($uploadObj);
                $simple['image'] = $file->filenameToStore;
            }
            $simpleInstance = Simple::updateOrCreate(['id' => $simple['id']], $simple);
            if (!empty($simpleInventory) && sizeof($simpleInventory) > 0) {
                foreach ($simpleInventory as $key => $value) {
                    $inventory = [];
                    $inventory['id'] = $simpleInventory[$key]['id'];
                    $inventory['qty_add_or_remove'] = $simpleInventory[$key]['qty_add_or_remove'];
                    $inventory['by_whom'] = $simpleInventory[$key]['by_whom'];
                    if ($value['id'] != 0) {
                        $inventory['total'] = $simpleInventory[$key]['total'];
                    } else {
                        $className = SimpleInventory::class;
                        $total = $this->getTotal($className, 'simple_id', $simpleInstance->id);
                        $inventory['total'] = $value['qty_add_or_remove'] + $total;
                        $inventory['date'] = $this->changeDateFormat($simpleInventory[$key]['date']);
                        if ($simpleInstance->total_added == null) {
                            $simpleInstance->total_added = $value['qty_add_or_remove'];
                            $simpleInstance->save();
                        } else {
                            $simpleInstance->increment('total_added', $value['qty_add_or_remove']);
                        }
                    }
                    $simpleInstance->simpleInventory()->updateOrCreate(['id' => $inventory['id']], $inventory);
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
                    $path = $file->storeAs('public/simple', $filenameToStore);
                    // Store in DB
                    $document = new SimpleImage();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $simpleInstance->images()->save($document);
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
                    $path = $file->storeAs('public/simple', $filenameToStore);
                    // Store in DB
                    $document = new SimpleFile();
                    $document->file = $filenameToStore;
                    $document->name = $filenameWithExt;
                    $simpleInstance->files()->save($document);
                }
            }
            $simpleInstance->total_on_hand = $simpleInstance->total_added - $simpleInstance->total_sold;
            $simpleInstance->save();
            return response()->json($simpleInstance->load($this->relation));
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Simple $simple)
    {
        return response()->json($simple->load($this->relation));
    }

    public function destroy(Simple $simple)
    {
        /*if(isset($simple->image)){
            $imagePath = "images/simple/".$simple->image;;
            if (file_exists($imagePath))
                unlink($imagePath);
        }*/
        $simple->products()->delete();
        $simple->compositeProducts()->delete();
        return $simple->delete();
    }

    public function getColumns()
    {
        $simple = new Simple();
        $category = new SimpleCategory();
        $simple = $simple->getTableColumns();
        $category = $category->getTableColumns();
        $data = [];
        $data['simple'] = $simple;
        $data['category'] = $category;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $simple = new Simple;
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
        $simple = $this->searchQuery($simple, $request, 'Simple');
        if ($columnTableName == 'simple') {
            $simple = $this->getDataWithPagination($simple, $sortByColumn, $this->relation, 'products', 'amount', $sortDirection, $pagePerPage);
            return response()->json($simple);
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($simple, $this->relation, $childClassName, $sortByColumn, 'simples', $foreignKey, $sortDirection, $pagePerPage);
        }
    }

    public function simpleSearch(Request $request)
    {
        $simple = new Simple;
        $request = $request->all();
        $simple = $this->searchQuery($simple, $request, 'Simple');
        return $simple->withSum('products', 'amount')->with(['category'])->orderBy('id', 'desc')->get();
    }

    public function deleteImage($id)
    {
        try {
            $file = SimpleImage::findOrFail($id);
            $file_path = "images/simple/" . $file->file;
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
            $file = SimpleFile::findOrFail($id);
            $file_path = "images/simple/" . $file->file;
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
        $simple = Simple::select('id', 'product_number')->get();
        return response()->json($simple);
    }

    public function getNextPrevious(Simple $simple)
    {
        return $this->nextPreviousRecord(new Simple, $this->relation, $simple->id);
    }
}
