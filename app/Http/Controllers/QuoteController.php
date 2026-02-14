<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddQuoteRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Cemetery;
use App\Models\Company;
use App\Models\Composite;
use App\Models\Monument;
use App\Models\NonStockProduct;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteCompositeProduct;
use App\Models\Service;
use App\Models\Simple;
use Exception;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public $relations = ['products.NonStockProduct', 'products.Monument', 'products.Service', 'products.Simple',
        'products.QuoteCompositeProduct.Monument', 'products.QuoteCompositeProduct.Service', 'products.QuoteCompositeProduct.Simple',
        'products.Composite.compositeProducts.Monument', 'products.Composite.compositeProducts.Service', 'products.Composite.compositeProducts.Simple', 'cemetery', 'company'];

    public function index()
    {
        $quotes = new Quote();
        $quotes = $quotes->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($quotes);
    }

    public function getRecordPagination()
    {
        $quote = new Quote();
        return response()->json($this->getDataWithPagination($quote, 'id', $this->relations, '', '', 'desc'));
    }

    public function store(AddQuoteRequest $request)
    {
        try {
            $quote = json_decode($request->data, true);

            if ($quote['company_id'] == 0) {
                $quote['company_id'] = null;
            }
            if ($quote['cemetery_id'] == 0) {
                $quote['cemetery_id'] = null;
            }

            $quoteInstance = Quote::updateOrCreate(['id' => $quote['id']], $quote);

            foreach ($quote['products'] as $product) {

                $productInstance = Product::updateOrCreate(['id' => $product['id']], $product);
                $quoteInstance->products()->save($productInstance);

                if (array_key_exists('non_stock_product', $product) && count($product['non_stock_product']) > 0) {

                    $nonStockProduct = NonStockProduct::updateOrCreate(['id' => $product['non_stock_product'][0]['id']], $product['non_stock_product'][0]);
                    $nonStockProduct->products()->sync([$productInstance->id]);
                }
                if (array_key_exists('monument', $product) && count($product['monument']) > 0) {
//                    $monument = Monument::find($product['monument'][0]['id']);
//                    $monument->products()->sync([$productInstance->id]);
                    $productInstance->monument()->sync([$product['monument'][0]['id']]);
                }
                if (array_key_exists('service', $product) && count($product['service']) > 0) {
//                    $service = Service::find($product['service'][0]['id']);
//                    $service->products()->sync([$productInstance->id]);
                    $productInstance->service()->sync([$product['service'][0]['id']]);
                }
                if (array_key_exists('simple', $product) && count($product['simple']) > 0) {
//                    $simple = Simple::find($product['simple'][0]['id']);
//                    $simple->products()->sync([$productInstance->id]);
                    $productInstance->simple()->sync([$product['simple'][0]['id']]);
                }
                if (array_key_exists('composite', $product) && count($product['composite']) > 0) {
//                    $composite = Composite::find($product['composite'][0]['id']);
//                    $composite->products()->sync([$productInstance->id]);
                    $productInstance->composite()->sync([$product['composite'][0]['id']]);

                    if (array_key_exists('quote_composite_product', $product) && count($product['quote_composite_product']) > 0) {
                        foreach ($product['quote_composite_product'] as $compositeProduct) {
                            $compositeProduct['product_id'] = $productInstance->id;
                            $quoteComposite = QuoteCompositeProduct::updateOrCreate(['id' => $compositeProduct['id']], $compositeProduct);
                            if (array_key_exists('monument', $compositeProduct) && count($compositeProduct['monument']) > 0) {
                                $quoteComposite->Monument()->sync([$compositeProduct['monument'][0]['id']]);
                            }
                            if (array_key_exists('service', $compositeProduct) && count($compositeProduct['service']) > 0) {
                                $quoteComposite->Service()->sync([$compositeProduct['service'][0]['id']]);
                            }
                            if (array_key_exists('simple', $compositeProduct) && count($compositeProduct['simple']) > 0) {
                                $quoteComposite->Simple()->sync([$compositeProduct['simple'][0]['id']]);
                            }

                        }
                    }
                }
            }
            $quoteInstance->load($this->relations);
            return response()->json($quoteInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Quote $quote)
    {

        $quote->load($this->relations);
        return response()->json($quote);
    }

    public function destroy(Quote $quote)
    {
        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */
        /*foreach ($quote->products as $product){
            $product->NonStockProduct()->detach();
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            $product->Composite()->detach();
        }

        $quote->products()->delete();*/
        return $quote->delete();
    }

    public function getColumns()
    {

        $quote = new Quote();
        $company = new Company();
        $cemetery = new Cemetery();
        $quote = $quote->getTableColumns();
        $company = $company->getTableColumns();
        $cemetery = $cemetery->getTableColumns();

        $companyKey = array_search('company', $cemetery); // returns key e.g $key = 2;
        // Only get company name from cemetery in the form of key value pair
        $cemetery = array_slice($cemetery, $companyKey, 1, true);
        $cemetery = array_values($cemetery); // Rearrange array

        $accountNumberKey = array_search('account_number', $company); // returns key e.g $key = 2;
        // Only get account number from company in the form of key value pair
        $company = array_slice($company, $accountNumberKey, 1, true);
        $company = array_values($company); // Rearrange array

        $data = [];
        $data['quote'] = $quote;
        $data['cemetery'] = $cemetery;
        $data['company'] = $company;
        return response()->json($data);
    }

    public function search(Request $request)
    {

        $quote = new Quote();
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

        $quote = $this->searchQuery($quote, $request, 'Quote');
        if ($columnTableName == 'quote') {
            return response()->json($this->getDataWithPagination($quote, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($quote, $this->relations, $childClassName, $sortByColumn, 'quotes', $foreignKey, $sortDirection, $pagePerPage);
        }
//        return response()->json($this->getDataWithPagination($quote, 'id', $this->relations, '', '', $sortDirection));
//        return $quote->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function searchProducts(Request $request)
    {

        $keywords = $request->keywords;
        $type = $request->type; // Search By Number or Title
        $type = $type != '' ? $type : 'byNumber';
        try {
            $monument = new Monument();
            $service = new Service();
            $simple = new Simple();
            $composite = new Composite();

            /*$monument = $monument->with(['installation'])->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();

            $service = $service->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();

            $simple = $simple->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->get();

            $composite = $composite->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->with(['compositeProducts.Monument.installation', 'compositeProducts.Service', 'compositeProducts.Simple'])->get();*/

            $monument = $monument->select('id', 'product_number', 'item_name', 'override_selling_price')->with(['installation:id,installation_amount,monument_id'])
                ->when($type == 'byNumber', function ($q) use ($keywords) {
                    return $q->where('product_number', 'like', '%' . $keywords . '%');
                })->when($type == 'byTitle', function ($q) use ($keywords) {
                    return $q->where('item_name', 'like', '%' . $keywords . '%');
                })->orderBy('item_name', 'asc')->get();
            $service = $service->select('id', 'product_number', 'item_name', 'override_selling_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $simple = $simple->select('id', 'product_number', 'item_name', 'override_selling_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->orderBy('item_name', 'asc')->get();
            $composite = $composite->select('id', 'product_number', 'item_name', 'retail_price', 'install_price')->when($type == 'byNumber', function ($q) use ($keywords) {
                return $q->where('product_number', 'like', '%' . $keywords . '%');
            })->when($type == 'byTitle', function ($q) use ($keywords) {
                return $q->where('item_name', 'like', '%' . $keywords . '%');
            })->with(['compositeProducts:id,composite_id,quantity,installation_price,installation', 'compositeProducts.Monument:id,product_number,item_name,override_selling_price',
                'compositeProducts.Monument.installation:id,installation_amount,monument_id', 'compositeProducts.Service:id,product_number,item_name,override_selling_price',
                'compositeProducts.Simple:id,product_number,item_name,override_selling_price'])->orderBy('item_name', 'asc')->get();

            $monumentSorted = null;
            $serviceSorted = null;
            $simpleSorted = null;
            $compositeSorted = null;
            if ($type == 'byNumber') {
                $monumentSorted = $this->sortProductAlphaNumeric($monument, 'product_number');
                $serviceSorted = $this->sortProductAlphaNumeric($service, 'product_number');
                $simpleSorted = $this->sortProductAlphaNumeric($simple, 'product_number');
                $compositeSorted = $this->sortProductAlphaNumeric($composite, 'product_number');
            } else {
                $monumentSorted = $this->sortProductAlphaNumeric($monument, 'item_name');
                $serviceSorted = $this->sortProductAlphaNumeric($service, 'item_name');
                $simpleSorted = $this->sortProductAlphaNumeric($simple, 'item_name');
                $compositeSorted = $this->sortProductAlphaNumeric($composite, 'item_name');
            }

            $returnObj = new \stdClass();
            $returnObj->monument = $monument->count() == 0 ? 'No record found' : $monumentSorted;
            $returnObj->service = $service->count() == 0 ? 'No record found' : $serviceSorted;
            $returnObj->simple = $simple->count() == 0 ? 'No record found' : $simpleSorted;
            $returnObj->composite = $composite->count() == 0 ? 'No record found' : $compositeSorted;

            return response()->json($returnObj);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function deleteProduct(Product $product)
    {

        try {
            $product->NonStockProduct()->detach();
            $product->Monument()->detach();
            $product->Simple()->detach();
            $product->Service()->detach();
            $product->Composite()->detach();
            return response()->json($product->delete());
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function getFirst()
    {
        return $this->firstRecord(new Quote, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Quote, $this->relations, 'asc');
    }

    public function getNext(Quote $quote)
    {
        return $this->nextRecord(new Quote, $this->relations, $quote->id, 'desc');
    }

    public function getPrevious(Quote $quote)
    {
        return $this->previousRecord(new Quote, $this->relations, $quote->id);
    }

    public function getDropDownRecord()
    {
        $quote = Quote::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($quote);
    }
}
