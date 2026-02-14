<?php

namespace App\Http\Traits;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

trait Accessible{

    public function isAccessible($params){
        if ($this->isPermitted($params) && $this->isActive())
            return true;
        else
            return false;
    }

    public function isAccessibleorClient($params){

        if (( $this->userClient() || $this->isPermitted($params) ) && $this->isActive() )
            return true;
        else
            return false;
    }

    public function userClient(){
        $isClient = false;

        $role = UserRole::where('id', Auth::user()->role_id)->value('title');;

        if ($role == 'Client')
            $isClient = true;

        return $isClient;
    }

    public function isPermitted($params){
        $permitted = false;

        $permissions = UserRole::where('id', Auth::user()->role_id)->value('permissions');;
        if(!empty($permissions)) {
            foreach ($permissions as $permission)
                if ($params['resource'] == $permission['resource'])
                    $permitted = $permission[$params['action']];
        }

        return $permitted;
    }

    public function isActive(){
        return Auth::user()->status == 1;
    }
}
