<?php

namespace App\Http\Middleware;

use App\Models\UserRole;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class MyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $resource,$action)
    {
        // for resource route
        if($action == 'resource'){

            $method = explode('.',$request->route()->action['as'])[1];

            if ($method == 'store'){

                $data= json_decode($request->data, true);

                    if($data['id'] == 0)
                        $action = 'create';

                    if($data['id'] > 0)
                        $action = 'update';
            }
            else if ($method == 'destroy')
                $action = 'delete';
            else
                $action = 'read';

        }
        //dd( $method,$resource,$action);

        if($this->isAccessible(['resource'=>$resource,'action'=>$action]))
        {

            return $next($request);
        }
        return response()->json(["message"=>"Sorry, You don't have an access"],403);
        //redirect('login','403');
    }

    public function isAccessible($params){
        if ($this->isPermitted($params) && $this->isActive())
            return true;
        else
            return false;
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
