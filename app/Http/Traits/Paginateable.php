<?php

namespace App\Http\Traits;

trait Paginateable
{

    public function nextRecord($model, $relations, $id, $direction)
    {
        return response()->json($model->with($relations)->where('id', '<', $id)->orderBy('id', $direction)->first());
    }

    public function previousRecord($model, $relations, $id)
    {
        return response()->json($model->with($relations)->where('id', '>', $id)->first());
    }

    public function firstRecord($model, $relations, $direction)
    {
        return response()->json($model->with($relations)->orderBy('id', $direction)->first());
    }

    public function lastRecord($model, $relations, $direction)
    {
        return response()->json($model->with($relations)->orderBy('id', $direction)->first());
    }

    public function totalRecord($model)
    {
        return response()->json($model->count());
    }

    public function nextPreviousRecord($model, $relation, $id)
    {
        return response()->json($model->with($relation)
            ->whereId($id)
            ->first());
    }

    public function monumentPreviousRecord($model, $relation, $productNumber, $columnName, $direction = 'asc')
    {
        return response()->json($model->with($relation)
            ->orderByRaw("CAST($columnName AS UNSIGNED) $direction, $columnName $direction")
            ->whereRaw("CAST($columnName AS UNSIGNED) < CAST(? AS UNSIGNED)", [$productNumber])
            ->first()
        );
    }
}
