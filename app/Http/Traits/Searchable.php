<?php

namespace App\Http\Traits;

use App\Mail\OrderStatusUpdated;
use App\Models\Collaboration;
use App\Models\CollaborationImage;
use App\Models\Monument;
use App\Models\Order;
use App\Models\Service;
use App\Models\Simple;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

trait Searchable
{

    public $userRoleTitle = 'Admin';
    public $userSupperRoleTitle = 'Supper Admin';
    public $fileUploaded = 'File Uploaded';
    public $fileDeleted = 'File Deleted';
    public $fileMovedToApprove = 'File Moved to Approval';
    public $fileMovedToCustomer = 'File Moved to Customer';
    public $fileRejectedForCustomer = 'File Rejected for Customer';
    public $fileApprovalNeeded = 'Approval Needed Checkbox Checked';
    public $fileApprove = 'File Approved';
    public $related_tables = ['Polish', 'Engrave', 'Freight', 'Installation'];

    public function searchQuery($model, $data, $module)
    {

        try {
            $modelObj = $model;
            $queryObj = new \stdClass();
            foreach ($data as $key => $fields) {

                $fields = json_decode($fields);
                // For Models which contains '_' in their name link Production_Picture, Production_Laser, They will be converted into ProductionPicture, ProductionLaser
                $key = str_replace('_', '', $key);

                if ($key == $module) {
                    foreach ($fields as $field) {
                        $queryObj->query = $modelObj;
                        $queryObj->field = $field;
                        $modelObj = $this->makeQuery($queryObj);
                    }
                } else {
//                    $modelObj = $modelObj->whereHas($key, function ($query) use ($fields, $queryObj){
//                        foreach ($fields as $field) {
//                            $queryObj->query = $query;
//                            $queryObj->field = $field;
//                            $query = $this->makeQuery($queryObj);
//                        }
//                        return $query;
//                    });

                    // Execute below relationship query only when fields of respective relation has some non empty value
                    $fieldsWithData = array_filter($fields, function ($obj) use ($fields, $key) {
                        if ($obj->operator == 'IS' && strpos($obj->column, 'date') !== false) {
                            return true;
                        }
                        if ($obj->value != '' && $obj->value != 'NULL') {
                            return true;
                        }
                        if ($obj->operator == 'IS' && $obj->value == 'NULL' && count($fields) > 1 && !in_array($key, $this->related_tables)) {
                            return true;
                        }
                    });
                    // ! Here below code is use to check for empty records in relationship
                    $emptyfields = array_filter($fields, function ($obj) use ($fields, $key) {
                        if ($obj->value == 'NULL' && count($fields) < 2) {
                            return true;
                        }
                        if ($obj->value == 'NULL' && count($fields) > 1 && in_array($key, $this->related_tables)) {
                            return true;
                        }
                    });
                    if (count($fieldsWithData) > 0) {
                        $modelObj = $modelObj->whereHas($key, function ($query) use ($fields, $queryObj) {
                            foreach ($fields as $field) {
                                $queryObj->query = $query;
                                $queryObj->field = $field;
                                $query = $this->makeQuery($queryObj, $fields);
                            }
                            return $query;
                        });
                    }
                    if (count($emptyfields) > 0) {
                        $modelObj = $modelObj->whereDoesntHave($key, function ($query) use ($fields, $queryObj) {
                            foreach ($fields as $field) {
                                $queryObj->query = $query;
                                $queryObj->field = $field;
                                $query = $queryObj;
                            }
                            return $query;
                        });
                    }
                }
            }

            return $modelObj;
        } catch (QueryException $e) {
            return response()->json($e);
        }
    }

    public function makeQuery($queryObj, $relational_fields = [])
    {

        if ($queryObj->field->value != '') {
            if ($queryObj->field->operator == '...') {
                $values = explode("...", $queryObj->field->value);
                if (isset($values[0]) && isset($values[1])) {
//                    Here, chr(255) is used to add a character with the highest ASCII value, which ensures that any string value that comes after 'd' will also be
// included in the query result. this is because of column type which is string.
                    $queryObj->query = $queryObj->query->whereBetween($queryObj->field->column, [$values[0], $values[1] . chr(255)]);
                }
//                $queryObj->query = $queryObj->query->whereBetween($queryObj->field->column, [(int)$values[0], (int)$values[1]]);
            } else {

                // If no operator provided, set to equal
                if ($queryObj->field->operator == '') {
                    $queryObj->field->operator = 'like';
                }
                if (is_numeric($queryObj->field->value)) {
                    if (($queryObj->field->operator == 'like' || $queryObj->field->operator == 'not like') && ($queryObj->field->column != 'created_at')) {
                        $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value . "%");
//                        $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, "%" . $queryObj->field->value . "%");
                    } else if ($queryObj->field->column != 'created_at' && $queryObj->field->operator != "IS") {
                        $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, +$queryObj->field->value); // (+) here is used for type cast (converting string to int)
                    }
                } else if (strlen($queryObj->field->value) > 1 && strtotime($queryObj->field->value) && $queryObj->field->column != 'created_at' && $queryObj->field->operator != "=''") {
                    if ($queryObj->field->operator == 'like')
                        $queryObj->field->operator = '=';

                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value);
                } else if ($queryObj->field->column != 'created_at' && $queryObj->field->operator != "IS") {
                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value . "%");
//                    $queryObj->query = $queryObj->query->where($queryObj->field->column, $queryObj->field->operator, "%" . $queryObj->field->value . "%");
                } else if ($queryObj->field->operator == "IS") {
//                    $queryObj->query = $queryObj->query->whereNull($queryObj->field->column)->orWhere($queryObj->field->column, '=', '');
                    $columnName = $queryObj->field->column;
                    $queryObj->query = $queryObj->query->where(function ($queryObj) use ($columnName) {
                        $queryObj->whereNull($columnName)->orWhere($columnName, '=', '');
                    });
//                    dd($queryObj->query->getQuery()->tosql());
                }
                if ($queryObj->field->column == 'created_at') {
                    $queryObj->query = $queryObj->query->whereDate($queryObj->field->column, $queryObj->field->operator, date($queryObj->field->value));
                }
            }
        }
        $date_types = ['closed_date', 'ship_date', 'date_promised', 'date'];
        $columnName = $queryObj->field->column;
        if (($queryObj->field->operator == "IS") && strpos($columnName, 'date') !== false) {
            $queryObj->query = $queryObj->query->where(function ($queryObj) use ($columnName, $date_types) {
                if (in_array($columnName, $date_types)) {
                    $queryObj->whereNull($columnName);
                } else {
                    $queryObj->whereNull($columnName)->orWhere($columnName, '=', '');
                }
            });
        }
        if ($queryObj->field->operator == "IS" && $queryObj->field->value == 'NULL' && count($relational_fields) > 1 && !in_array($columnName, $date_types)) {
            $queryObj->query = $queryObj->query->where(function ($queryObj) use ($columnName) {
                $queryObj->whereNull($columnName)->orWhere($columnName, '=', '0.00')->orWhere($columnName, '=', '');
            });
        }
        return $queryObj->query;
    }

    public function productNoForUpdate($className, $id, $productNumber)
    {
        $entityExist = false;
        $getProductNumber = $className::findOrFail($id);
        if ($getProductNumber['product_number'] != $productNumber) {
            if ($this->isProductNumberExist($productNumber)) {
                $entityExist = true;
            }
        }
        return $entityExist;
    }

    public function isProductNumberExist($productNumber)
    {

        $className = [];
        $className[] = Service::class;
        $className[] = Simple::class;
        $className[] = Monument::class;
        $entityExist = false;
        foreach ($className as $name) {
            if ($name::where('product_number', '=', $productNumber)->count() > 0) {
                $entityExist = true;
                break;
            }
        }
        return $entityExist;
    }

    public function sortProductAlphaNumeric($dataObject, $columnName)
    {
        $dataObject = json_decode($dataObject, true);
        $dataColumn = array_column($dataObject, $columnName);
        array_multisort($dataColumn, SORT_ASC, $dataObject);
        return $dataObject;
    }

    public function getDataWithPagination($model, $columnName, $relations, $tableName = null, $sumColumnName = null, $direction = 'asc', $perPage = 10)
    {
        $direction = trim($direction, '"');
        return $model->select('*', $columnName)
            ->selectRaw("$columnName * 1 as pd")
            ->with($relations)
            ->withSum($tableName, $sumColumnName)
            ->orderBy('pd', $direction)
            ->orderBy($columnName, $direction)
            ->paginate($perPage);
    }

    public function sortRelatedTable($model, $relation, $childClassName, $sortByColumn, $tableName, $foreignKey, $sortDirection, $perPage = 10)
    {
        return response()->json($model->with($relation)->orderBy(
            $childClassName::select($sortByColumn)
                ->whereColumn('id', $tableName . '.' . $foreignKey)
                ->orderBy($sortByColumn, $sortDirection), $sortDirection
        )->paginate($perPage));
    }

    public function sortRelationalTable($model, $relation, $childClassName, $sortByColumn, $childTableName, $sortDirection, $parentRelation, $parentTable, $parentForeignId, $id, $perPage = 10)
    {
        return response()->json($model->with($relation)->orderBy(
            $childClassName::select($sortByColumn)
                ->with($parentRelation)
                ->whereColumn($childTableName . '.' . $parentForeignId, $parentTable . '.' . $id)
                ->orderBy($sortByColumn, $sortDirection)
                ->limit(1), $sortDirection
        )->paginate($perPage));
    }

    public function idNotInParentNorChildSort($model, $relations, $sortDirection, $parentTable, $perPage = 10, $sortByColumn, $childTableName, $foreignKey)
    {
        return response()->json($model->with($relations)->orderBy(function ($query) use ($sortDirection, $parentTable, $sortByColumn, $childTableName, $foreignKey) {
            $query->select($sortByColumn)
                ->from($childTableName)
                ->join('orders', $childTableName.'.id', '=', 'orders.'.$foreignKey)
                ->whereColumn('orders.'.$foreignKey, '=', $childTableName.'.id')
                ->whereColumn($parentTable . '.order_id', '=', 'orders.id')
                ->orderBy($sortByColumn, $sortDirection)
                ->limit(1);
        }, $sortDirection)->paginate($perPage));
    }

    public function changeDateFormat($date)
    {
        return Carbon::createFromFormat('m/d/Y', $date)->format('Y-m-d H:i:s');
    }

    public function getTotal($className, $column, $id)
    {
        return $className::where($column, $id)
            ->whereNotNull(['total', 'qty_add_or_remove'])
            ->sum('qty_add_or_remove');
    }

    public function addProductInventory($monument, $productQuantity, $order, $productInstance, $existingProductQuantity, $objectName, $compositeID = null, $id)
    {
        $inventory = [];
        $inventory['by_whom'] = auth()->user()->name;
        $inventory['date'] = date('Y-m-d H:i:s');
        $inventory['invoice_number'] = $order['invoice']['invoice_number'];
        $inventory['item_order'] = $productQuantity;
        $inventory['composite_id'] = $compositeID;
        if ($objectName == "monument") {
            $productInstance->MonumentInventory()->updateOrCreate(['monument_id' => $id], $inventory);
        } else if ($objectName == "service") {
            $productInstance->ServiceInventory()->updateOrCreate(['service_id' => $id], $inventory);
        } else if ($objectName == "simple") {
            $productInstance->SimpleInventory()->updateOrCreate(['simple_id' => $id], $inventory);
        } else if ($objectName == "composite") {
            $productInstance->CompositeInventory()->updateOrCreate(['composite_id' => $id], $inventory);
        }
        $incrementQuantity = $productQuantity - $existingProductQuantity;
        if ($objectName == "composite") {
            if ($monument->sold == null) {
                $monument->sold = $incrementQuantity;
                $monument->save();
            } else {
                $monument->increment('sold', $incrementQuantity);
            }
        } else {
            if ($monument->total_sold == null) {
                $monument->total_sold = $incrementQuantity;
                $monument->save();
            } else {
                $monument->increment('total_sold', $incrementQuantity);
            }
            $monument->total_on_hand = $monument->total_added - $monument->total_sold;
            $monument->save();
        }
        unset($inventory);
    }

    public function linkInstallationUploadsToCollaboration($data, $request, $status, $file)
    {
        $collaboration = Collaboration::find($data['order']['collaboration']['id']);
        $uploadObj = new \stdClass();
        $uploadObj->file = $request->file($file);
        $uploadObj->path = 'installation/';
        $uploadObj->module = 'installation';
        $file = $this->upload($uploadObj);
        $collaborationImage = new CollaborationImage();
        $collaborationImage->name = $file->filenameWithExt;
        $collaborationImage->uploaded_by = Auth::user()->name;
        $collaborationImage->user_id = Auth::user()->id;
        $collaborationImage->size = $file->size;
        $collaborationImage->path = 'images/' . $uploadObj->path . $file->filenameToStore;
        $collaborationImage->status = $status;
        $collaborationImage->sent_mail = 0;
        $collaborationImage->save();
        $collaboration->images()->save($collaborationImage);
    }

    public function productionOrder()
    {
        return response()->json(Order::select('id')
            ->with(['invoice:invoice_number,order_id', 'family:id,order_id,name_on_stone'])
            ->orderBy('id', 'desc')
            ->get());
    }

    public function sendMailForOrderStatusAndTask($familyEmail, $collaborationLink, $customerContact, $invoiceNumber, $message, $messageOne, $messageTwo)
    {
        $taskParam['mps_collaboration_link'] = $collaborationLink;
        $taskParam['name'] = $customerContact;
        $taskParam['order'] = $invoiceNumber;
        $taskParam['message'] = $message;
        $taskParam['message_one'] = $messageOne;
        $taskParam['message_two'] = $messageTwo;
        Mail::to($familyEmail)->send(new OrderStatusUpdated($taskParam));
    }
}
