<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\OrderStatus;
use Exception;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    use Searchable, Paginateable, Accessible;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $orderStatus = new OrderStatus();
            return response()->json($orderStatus->orderBy('title', 'asc')->get());
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function paginationRecord()
    {
        $orderStatus = new OrderStatus();
        return response()->json($this->getDataWithPagination($orderStatus, 'title', [], '', '', 'asc'));
    }

    public function dropDownInfo()
    {
        $orderStatus = OrderStatus::select('id')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($orderStatus);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->data, true);
            $orderStatus = OrderStatus::updateOrCreate(['id' => $data['id']], $data);
            return response()->json($orderStatus);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\OrderStatus $orderStatus
     *
     * @return \Illuminate\Http\Response
     */
    public function show(OrderStatus $orderStatus)
    {
        try {
            return response()->json($orderStatus);
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OrderStatus $orderStatus
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderStatus $orderStatus
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\OrderStatus $orderStatus
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderStatus $orderStatus)
    {
        return $orderStatus->delete();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getColumn()
    {
        $orderStatus = new OrderStatus();
        $orderStatus = $orderStatus->getTableColumn();
        $data = [];
        $data['orderStatus'] = $orderStatus;
        return response()->json($data);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function search(Request $request)
    {
        $orderStaus = new OrderStatus();
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $orderStaus = $this->searchQuery($orderStaus, $request, 'OrderStatus');
        return response()->json($this->getDataWithPagination($orderStaus, $sortByColumn, [], '', '', $sortDirection, $pagePerPage));
    }

    public function getNext(OrderStatus $status)
    {
        return $this->nextRecord(new OrderStatus, [], $status->id, 'desc');
    }

    public function getPrevious(OrderStatus $status)
    {
        return $this->previousRecord(new OrderStatus, [], $status->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new OrderStatus, [], 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new OrderStatus, [], 'asc');
    }

}
