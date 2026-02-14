<?php

namespace App\Http\Controllers;

use App\Http\Traits\Searchable;
use App\Models\Composite;
use App\Models\Monument;
use App\Models\Service;
use App\Models\Simple;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    use Searchable;

    public function index()
    {
        $monuments = new Monument();
        $simple = new Simple();
        $service = new Service();
        $composite = new Composite();
        $simple = $simple->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')
            ->orderBy('product_number', 'desc')->get()->toArray();
        $service = $service->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')
            ->orderBy('product_number', 'desc')->get()->toArray();
        $composite = $composite->select('id', 'product_number', 'item_name', 'on_hand', 'product_type')->orderBy('product_number', 'desc')->get()->toArray();
        $monuments = $monuments->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')
            ->whereNull('price_estimator')->orWhere('price_estimator', '=', '')->orderBy('product_number', 'desc')->get()->toArray();
        $productCollection = array_merge_recursive($monuments, $service, $simple, $composite);
        return response()->json($productCollection);
    }

    public function getColumns()
    {
        $monument = new Monument;
        $monument = $monument->getTableColumns();
        $data = [];
        $data['monument'] = $monument;
        return response()->json($data);
    }

    public function monumentSearch(Request $request)
    {
        $monument = new Monument;
        $request = $request->all();
        $monument = $this->searchQuery($monument, $request, 'Monument');
        $monument = $monument->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')
            ->whereNull('price_estimator')->orWhere('price_estimator', '=', '')->orderBy('product_number', 'desc')
            ->orderBy('id', 'desc')->get();
        return $monument;
    }

    public function serviceSearch(Request $request)
    {
        $service = new Service();
        $request = $request->all();
        $service = $this->searchQuery($service, $request, 'Service');
        $service = $service->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')->orderBy('product_number', 'desc')->get();
        return $service;
    }

    public function simpleSearch(Request $request)
    {
        $simple = new Simple;
        $request = $request->all();
        $simple = $this->searchQuery($simple, $request, 'Simple');
        $simple = $simple->select('id', 'product_number', 'item_name', 'product_cost', 'total_on_hand', 'override_selling_price', 'product_type')->orderBy('product_number', 'desc')->get();
        return $simple;
    }

    public function compositeSearch(Request $request)
    {
        $composite = new Composite;
        $request = $request->all();
        $composite = $this->searchQuery($composite, $request, 'Composite');
        $composite = $composite->select('id', 'product_number', 'item_name', 'on_hand', 'product_type')->orderBy('product_number', 'desc')->get();
        return $composite;
    }
}
