<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddCompanyRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\Company;
use App\Models\CompanyInfoType;
use App\Models\CustomerRole;
use Exception;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use Searchable, Paginateable, Accessible;

    protected $relations = ['role', 'type'];

    public function index()
    {
        $company = new Company;
        return response()->json($company->with($this->relations)->orderBy('id', 'desc')->get());
    }

    public function getPaginationRecord()
    {
        $company = new Company();
        return response()->json($this->getDataWithPagination($company, 'id', $this->relations, '', '', 'desc'));
    }

    public function store(AddCompanyRequest $request)
    {
        try {

            $company = json_decode($request->data, true);

            $companyInstance = Company::updateOrCreate(['id' => $company['id']], $company);

            return response()->json($companyInstance->load($this->relations));
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function show(Company $company)
    {

        return response()->json($company->load($this->relations));
    }

    public function destroy(Company $company)
    {

        return $company->delete();
    }

    public function getColumns()
    {

        $company = new Company();
        $company = $company->getTableColumns();
        $companyType = new CompanyInfoType();
        $companyType = $companyType->getTableColumns();
        $data = [];
        $data['company'] = $company;
        $data['type'] = $companyType;
        return response()->json($data);
    }

    public function search(AddCompanyRequest $request)
    {

        $company = new Company;
        $request = $request->all();
        $queryData = json_decode($request['queryData'] ?? '[]');

        // $queryData = json_decode($request['queryData']);
        // $queryData = json_decode($request->input('queryData'));
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
        $company = $this->searchQuery($company, $request, 'Company');
        if ($columnTableName == 'company') {
            return response()->json($this->getDataWithPagination($company, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
        } else if ($columnTableName == 'idInParentTable') {
            return $this->sortRelatedTable($company, $this->relations, $childClassName, $sortByColumn, 'companies', $foreignKey, $sortDirection, $pagePerPage);
        }
//        return $company->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function companyInfo()
    {

        $customerRole = new CustomerRole();
        return response()->json($customerRole->get());
    }

    public function getCompanyInfoType()
    {
        $companyType = new CompanyInfoType();
        return response()->json($companyType->select('id', 'title')->orderBy('title', 'desc')->get());
    }

    public function getDropDownInfo()
    {
        $company = Company::select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($company);
    }

    public function getFirst(){
        return $this->firstRecord(new Company, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new Company, $this->relations, 'asc');
    }

    public function getNext(Company $company){
        return $this->nextRecord(new Company, $this->relations, $company->id, 'desc');
    }

    public function getPrevious(Company $company){
        return $this->previousRecord(new Company, $this->relations, $company->id);
    }

    public function saveCompanyInfoType(Request $request)
    {
        $data = json_decode($request->data, true);
        $companyType = CompanyInfoType::updateOrCreate(['id' => $data['id']], $data);
        $companyType->save();
        return response()->json($companyType);
    }

    public function deleteCompanyInfoType(CompanyInfoType $companyInfoType)
    {
        return $companyInfoType->delete();
    }

}
