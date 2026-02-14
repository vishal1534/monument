<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCompositeRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\FileUpload;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Composite;
use App\Models\CompositeCategory;
use App\Models\CompositeFile;
use App\Models\CompositeProduct;
use App\Models\Monument;
use App\Models\Service;
use App\Models\Simple;
use Exception;
use Illuminate\Http\Request;

class CompositeController extends Controller
{
    use FileUpload, Searchable, Accessible, Paginateable;

    public $relation = ['category', 'files', 'compositeProducts.Monument.installation', 'compositeProducts.Monument.color', 'compositeProducts.Monument.type',
        'compositeProducts.Service', 'compositeProducts.Simple'
        , 'CompositeServiceInventory.serviceInvoice.order.family', 'CompositeServiceInventory.serviceInvoice.order.company'
        , 'saleHistory.monumentInvoice.order.family', 'saleHistory.monumentInvoice.order.company',
        'CompositeSimpleInventory.simpleInvoice.order.family', 'CompositeSimpleInventory.simpleInvoice.order.company', 'CompositeInventory.compositeInvoice.order.family'
        , 'CompositeInventory.compositeInvoice.order.company'];

    public function index()
    {
        $composite = new Composite();
        $composite = $composite->with($this->relation)->orderBy('product_number', 'desc')->get();
        return response()->json($composite);
    }

    public function compositeReportInfo()
    {
        $composite = new Composite();
        $composite = $composite->select('id', 'product_number', 'category_id', 'sold', 'item_name', 'final_price', 'retail_price', 'install_price')->with(['category',
            'compositeProducts:id,composite_id,quantity,installation_price', 'compositeProducts.Monument:id,product_number,item_name,override_selling_price,color_id,type_id',
            'compositeProducts.Monument.color:id,color_title', 'compositeProducts.Monument.type:id,type_title', 'compositeProducts.Service:id,product_number,item_name,type,color,override_selling_price'
            , 'compositeProducts.Simple:id,product_number,item_name,type,color,override_selling_price'
        ])
            ->orderBy('product_number', 'desc')->get();
        return response()->json($composite);
    }

    public function compositeInfo()
    {
        $category = new CompositeCategory();
        return response()->json($category->get());
    }

    public function store(AddCompositeRequest $request)
    {
        try {
            $composite = json_decode($request->data, true);
            if ($request->hasFile('image_file')) {
                $uploadObj = new \stdClass();
                $uploadObj->file = $request->file('image_file');
                $uploadObj->path = 'composite/';
                $uploadObj->module = 'composite';
                $file = $this->upload($uploadObj);
                $composite['image'] = $file->filenameToStore;
            }
            $compositeInstance = Composite::updateOrCreate(['id' => $composite['id']], $composite);
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
                    $path = $file->storeAs('public/composite', $filenameToStore);
                    // Store in DB
                    $document = new CompositeFile();
                    $document->file = $filenameToStore;
                    $compositeInstance->files()->save($document);
                }
            }
            foreach ($composite['composite_products'] as $product) {
                $productInstance = CompositeProduct::updateOrCreate(['id' => $product['id']], $product);
                $compositeInstance->compositeProducts()->save($productInstance);
                if (array_key_exists('monument', $product) && count($product['monument']) > 0) {
//                    $monument = Monument::find($product['monument'][0]['id']);
//                    $monument->compositeProducts()->sync([$productInstance->id]);
                    $productInstance->monument()->sync([$product['monument'][0]['id']]);
                }
                if (array_key_exists('service', $product) && count($product['service']) > 0) {
//                    $service = Service::find($product['service'][0]['id']);
//                    $service->compositeProducts()->sync([$productInstance->id]);
                    $productInstance->service()->sync([$product['service'][0]['id']]);
                }
                if (array_key_exists('simple', $product) && count($product['simple']) > 0) {
//                    $simple = Simple::find($product['simple'][0]['id']);
//                    $simple->compositeProducts()->sync([$productInstance->id]);
                    $productInstance->simple()->sync([$product['simple'][0]['id']]);
                }
            }
            return response()->json($compositeInstance->load($this->relation));
//            return response()->json($compositeInstance->load([ 'category','files','compositeProducts.Monument.installation','compositeProducts.Service','compositeProducts.Simple']));
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Composite $composite)
    {
        return response()->json($composite->load($this->relation));
    }

    public function destroy(Composite $composite)
    {
        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */
        /*foreach ($composite->compositeProducts as $product){
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
        }

        $composite->compositeProducts()->delete();
        $composite->products()->delete();

        if(isset($composite->image)){
            $imagePath = "images/composite/".$composite->image;;
            if (file_exists($imagePath))
                unlink($imagePath);
        }*/
        $composite->products()->delete();
        return $composite->delete();
    }

    public function getColumns()
    {
        $prefix = request()->route()->getPrefix();
        $composite = new Composite();
        $category = new CompositeCategory();
        $composite = $composite->getTableColumns();
        $category = $category->getTableColumns();
        $data = [];
        $data['composite'] = $composite;
        $data['category'] = $category;
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $composite = new Composite;
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
        $composite = $this->searchQuery($composite, $request, 'Composite');
        if ($columnTableName == 'composite') {
            return response()->json($this->getDataWithPagination($composite, $sortByColumn, $this->relation, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($composite, $this->relation, $childClassName, $sortByColumn, 'composites', $foreignKey, $sortDirection, $pagePerPage);
        }
    }

    public function compositeSearch(Request $request)
    {
        $composite = new Composite;
        $request = $request->all();
        $composite = $this->searchQuery($composite, $request, 'Composite');
        return $composite->with(['category', 'files', 'compositeProducts.Monument.installation', 'compositeProducts.Service', 'compositeProducts.Simple'])->orderBy('id', 'desc')->get();
    }

    public function searchProducts(Request $request)
    {
        $keywords = $request->keywords;
        $type = $request->type;
        try {
            $monument = new Monument();
            $service = new Service();
            $simple = new Simple();
            $monument = $monument->with(['installation'])->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $service = $service->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $simple = $simple->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $monumentSorted = null;
            $serviceSorted = null;
            $simpleSorted = null;
            if ($type == 'byNumber') {
                $monumentSorted = $this->sortProductAlphaNumeric($monument, 'product_number');
                $serviceSorted = $this->sortProductAlphaNumeric($service, 'product_number');
                $simpleSorted = $this->sortProductAlphaNumeric($simple, 'product_number');
            } else {
                /* $monumentSorted = $this->sortProductAlphaNumeric($monument, 'item_name');
                 $serviceSorted = $this->sortProductAlphaNumeric($service, 'item_name');
                 $simpleSorted = $this->sortProductAlphaNumeric($simple, 'item_name');*/
                $monumentSorted = $monument;
                $serviceSorted = $service;
                $simpleSorted = $simple;
            }
            $returnObj = new \stdClass();
            $returnObj->monument = $monument->count() == 0 ? 'No record found' : $monumentSorted;
            $returnObj->service = $service->count() == 0 ? 'No record found' : $serviceSorted;
            $returnObj->simple = $simple->count() == 0 ? 'No record found' : $simpleSorted;
            return response()->json($returnObj);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteProduct(CompositeProduct $product)
    {
        try {
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            return response()->json($product->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteFile($id)
    {
        try {
            $file = CompositeFile::findOrFail($id);
            $file_path = "images/composite/" . $file->file;
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
        $composite = Composite::select('id', 'product_number')->get();
        return response()->json($composite);
    }

    public function getNextPrevious(Composite $composite)
    {
        return $this->nextPreviousRecord(new Composite, $this->relation, $composite->id);
    }

    public function getRecordPagination()
    {
        $composite = new Composite();
        return response()->json($this->getDataWithPagination($composite, 'product_number', $this->relation));
    }
}
