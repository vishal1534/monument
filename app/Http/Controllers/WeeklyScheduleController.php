<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Requests\AddWeeklyScheduleRequest;
use App\Http\Traits\Accessible;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Models\WeeklySchedule;
use App\Models\WeeklyScheduleList;
use Exception;
use Illuminate\Http\Request;

class WeeklyScheduleController extends Controller
{
    use Searchable, Paginateable, Accessible;

    public $relations = ['weeklyScheduleList.order.invoice', 'weeklyScheduleList.order.family'];

    public function index()
    {
        $weeklySchedule = new WeeklySchedule();
        $weeklySchedule = $weeklySchedule->with($this->relations)->orderBy('id', 'desc')->get();
        return response()->json($weeklySchedule);
    }

    public function paginationRecord()
    {
        $records = new WeeklySchedule();
        return response()->json($this->getDataWithPagination($records, 'id', $this->relations, '', '', 'desc'));
    }

    public function weeklyScheduleOrder()
    {
        return $this->productionOrder();
    }

    public function dropDownInfo()
    {
        $records = WeeklySchedule::select('id', 'week_of')
            ->orderBy('id', 'desc')
            ->get();
        return response()->json($records);
    }

    public function store(AddWeeklyScheduleRequest $request)
    {
        try {
            $data = json_decode($request->data, true);
            $weeklyScheduleInstance = WeeklySchedule::updateOrCreate(['id' => $data['id']], $data);
            $entries = 0;
            if (count($data['weekly_schedule_list']) > 0) {
                foreach ($data['weekly_schedule_list'] as $schedule) {
                    if (count($this->arrayCount($schedule)) > 0) {
                        $entries++;
                        $scheduleInstance = WeeklyScheduleList::updateOrCreate(['id' => $schedule['id']], $schedule);
                        $weeklyScheduleInstance->weeklyScheduleList()->save($scheduleInstance);
                    }
                }
            }
            $weeklyScheduleInstance->total_entries = $entries;
            $weeklyScheduleInstance->save();
            $weeklyScheduleInstance->load($this->relations);
            return response()->json($weeklyScheduleInstance);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }
    }

    public function arrayCount($arr)
    {
        $arrCount = array_filter($arr, function ($value, $key) {
            if ($value === 0 && $key != 'id')
                return 1;
            else
                return $value != null;
        }, ARRAY_FILTER_USE_BOTH);
        return $arrCount;
    }

    public function show($id)
    {
        $weeklySchedule = WeeklySchedule::with($this->relations)->find($id);
        return response()->json($weeklySchedule);
    }

    public function destroy($id)
    {
        $weeklySchedule = WeeklySchedule::find($id);
        foreach ($weeklySchedule->weeklyScheduleList as $item) {
            $item->delete();
        }
        return $weeklySchedule->delete();
    }

    public function getColumns()
    {
        $weeklySchedule = new WeeklySchedule();
        $data = [];
        $data['Weekly Schedule'] = $weeklySchedule->getTableColumns();
        return response()->json($data);
    }

    public function search(Request $request)
    {
        $weeklySchedule = new WeeklySchedule;
        $request = $request->all();
        $queryData = json_decode($request['queryData']);
        $queryData = $queryData[0];
        $sortDirection = $queryData->sortDirection;
        $columnTableName = $queryData->columnTableName;
        $sortByColumn = $queryData->sortByColumn;
        $pagePerPage = $queryData->pagePerPage;
        unset($request['queryData']);
        unset($request['page']);
        $weeklySchedule = $this->searchQuery($weeklySchedule, $request, 'WeeklySchedule');
        return response()->json($this->getDataWithPagination($weeklySchedule, $sortByColumn, $this->relations, '', '', $sortDirection, $pagePerPage));
//        return $weeklySchedule->with($this->relations)->orderBy('id', 'desc')->get();
    }

    public function getNext(WeeklySchedule $schedule)
    {
        return $this->nextRecord(new WeeklySchedule, $this->relations, $schedule->id, 'desc');
    }

    public function getPrevious(WeeklySchedule $schedule)
    {
        return $this->previousRecord(new WeeklySchedule, $this->relations, $schedule->id);
    }

    public function getFirst()
    {
        return $this->firstRecord(new WeeklySchedule, $this->relations, 'desc');
    }

    public function getLast()
    {
        return $this->lastRecord(new WeeklySchedule, $this->relations, 'asc');
    }
}
