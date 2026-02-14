<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCountryRequest;
use App\Models\Country;
use Illuminate\Database\QueryException;
use App\Http\Traits\Searchable;
use Exception;

class CountryController extends Controller{

    use Searchable;

    public function index(){
        $country = new country;
        return response()->json($country->get());
    }

    public function store(AddcountryRequest $request){
        try {

            $country = json_decode($request->data, true);
            $title = $country['country_title'];
           $record = country::whereCountryTitle($title)->exists();
          if ($record)
              return response()->json(['errorInfo' => ['The country name already exists']], 200);

            $countryInstance = country::updateOrCreate(['id' => $country['id']], $country);

            return response()->json($countryInstance);
        }
        catch (Exception $e){
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(country $country){
        return response()->json($country);
    }

    public function destroy(country $country){
        return $country->delete();
    }

    public function getColumns(){
        $country = new country;
        $country = $country->getTableColumns();
        $data = [];
        $data['country'] = $country;
        return response()->json($data);
    }

    public function search(AddcountryRequest $request){

        $country = new country;
        $country = $this->searchQuery($country, $request,'country');
        return $country->orderBy('id', 'desc')->get();
    }

}
