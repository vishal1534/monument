<?php

namespace App\Http\Controllers;

use App\Events\ProcessException;
use App\Http\Traits\Paginateable;
use App\Http\Traits\Searchable;
use App\Mail\CreateUserPassword;
use App\Mail\PasswordResetNotification;
use App\Mail\VerificationMail;
use App\Models\Family;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Mail;


class UserController extends Controller
{
    use Searchable, Paginateable, HasApiTokens;

    protected $relations = ['role', 'store'];

    public function userDetail()
    {
        /**
         * TODO :
         * user authentication using sanctum token base
         * this line is for getting current loged in user id
         *  return auth('sanctum')->user()->id;
         */
        $user = new User();
        $user = $user->with(['role', 'store'])->where('id', auth('sanctum')->user()->id)->get();
        return response()->json($user);

        /**
         * TODO :
         * user authentication using sanctum session base
         * $token = Auth::user()->createToken('auth_token')->plainTextToken;
         * $user = $user->with(['role'])->where('id', Auth::user()->id)->get();
         * $user[0]['auth_token'] = $token;
         *  return response()->json($user);
         */

    }

    public function userFamiliesInfo()
    {
        /**
         * TODO :
         * 1-Need to be impliminted later
         * 2- This will used when order is created and family for that order is created and then
         * 3- Admin will search this family in user add section search functionality will also added later
         * 4- Admin will search and add this family to user
         */
//        $family = new Family();
        $families = Family::all();
        return response()->json($families);
    }

    public function updateProfile(Request $request)
    {
        $user = null;
        if ((!empty($request->name) && !empty($request->password)) || (empty($request->name) && empty($request->password)) || (empty($request->name) && !empty($request->password))) {
            $request->validate([
                'name' => ['required'],
                //'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:8', 'confirmed']
            ]);
        }

        try {
            if (!empty($request->name) && !empty($request->password)) {
                $user = User::updateOrCreate(['id' => $request['id']], [
                    'name' => $request->name,
                    'password' => Hash::make($request->password)
                ]);
            } elseif (!empty($request->name) && empty($request->password)) {
                $user = User::updateOrCreate(['id' => $request['id']], [
                    'name' => $request->name
                ]);
            } elseif (empty($request->name) && !empty($request->password)) {
                $user = User::updateOrCreate(['id' => $request['id']], [
                    'password' => Hash::make($request->password)
                ]);
            }

            return response()->json($user->load(['role']));
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json($e);
        }

    }

    public function register(Request $request)
    {
        $userRole = UserRole::where('title', 'Customer')->value('id');

        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'phone_number' => ['required', 'min:10', 'max:20']
        ]);


        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_status' => 1,
                'phone_number' => $request->phone_number,
                'role_id' => $userRole
            ]);

            $token = Str::random(64);

            $tokenInstance = User::updateOrCreate(['email' => $request->email], ['verify_token' => $token]);

            $user = User::where('email', $request->email)->first();

            $params['name'] = $user['name'];
            $params['email'] = $user['email'];
            $params['redirect_link'] = URL::to('/user-verification/' . $token);


            \Illuminate\Support\Facades\Mail::to($params['email'])->send(new VerificationMail($params));

            return response()->json([
                'message' => 'Account Created, Check email for verification'
            ], 200);
        } catch (Exception $e) {

            /*throw ValidationException::withMessages([
                'errors' =>['something went wrong ...']
            ]);*/
            ProcessException::dispatch($e->getMessage());
            return response()->json(['errors' => $e->getMessage()]);
        }

        //Auth::login($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        //$remember_me =  $request=>['remember_me']
        $remember_me = $request->input('remember_me');

        $check = $request->only('email', 'password');

        $isVerified = User::where('email', $request->email)->value('email_verified_at');

        if ($isVerified == null) {
            throw ValidationException::withMessages([
                'error' => ['Unverified User']
            ]);
        }

        $isActive = User::where('email', $request->email)->value('status');

        if ($isActive == 0) {
            throw ValidationException::withMessages([
                'error' => ['InActive User']
            ]);
        }
        /**
         * TODO :
         * this is for token base user authentication using sanctum
         */

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.']
            ]);
        } else {
            $userToken = $user->createToken('auth_token')->plainTextToken;
            $user = $user->with(['role', 'store'])->where('id', $user->id)->get();
            $user['auth_token'] = $userToken;
            return response()->json($user, 200);
        }
        /**
         * TODO :
         * user authentication using sanctum session base
         * if (Auth::attempt($check, $remember_me)){
         * $user= new User();
         * $user = $user->with(['role'])->where('id', Auth::user()->id)->get();
         * $token = Auth::user()->createToken('auth_token')->plainTextToken;
         * $user['auth_token'] = $token;
         * return response()->json($user,200);
         * }
         * throw ValidationException::withMessages([
         * 'error' =>['The provided credentials are incorrect.']
         * ]);
         */

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        /**
         * TODO:
         * This is for session base authentication of the user
         * Auth::user()->tokens()->delete();
         * Auth::guard('web')->logout();
         */

    }

    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ],
            [
                'email.exists' => "We can't find a user with that e-mail address.",
            ]);

        $token = Str::random(64);

        try {
            $passwordInstance = PasswordReset::updateOrCreate(['email' => $request->email], ['token' => $token]);
            $user = User::where('email', $request->email)->first();

            $params['name'] = $user['name'];
            $params['email'] = $user['email'];
            $params['redirect_link'] = URL::to('/reset-password/' . $token);


            \Illuminate\Support\Facades\Mail::to($params['email'])->send(new PasswordResetNotification($params));

            return response()->json([
                'message' => 'We have e-mailed your password reset link!'
            ], 200);
        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            throw ValidationException::withMessages([
                'errors' => ['something went wrong ...']
            ]);
            // return response()->json(['errors' => $e->getMessage()]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|confirmed',
        ],
            [
                'email.exists' => "We can't find a user with that e-mail address.!",
            ]);

        $updatePassword = PasswordReset::where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();


        if (!$updatePassword) {
            throw ValidationException::withMessages([
                'error' => ['Invalid token!']
            ]);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        PasswordReset::where(['email' => $request->email])->delete();

        return response()->json([
            'message' => 'Your password has been changed!'
        ], 200);

    }

    public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|confirmed',
        ],
            [
                'email.exists' => "We can't find a user with that e-mail address.!",
            ]);


        $verifyToken = User::where([
            'email' => $request->email,
            'verify_token' => $request->token
        ])->first();

        /*  if ($verifyToken['password_status'] == 0 || empty($verifyToken['password_status']))
          {
              $password = $request->password;
              $password = Hash::make($password);
              User::where('email', $request->email)
                  ->update(['password_status' => 1,  'password' => $password]);
          }*/

        if (!$verifyToken) {
            throw ValidationException::withMessages([
                'error' => ['Invalid token!']
            ]);

        }


        $check = $request->only('email', 'password');
        /**
         * TODO :
         * session base user authentication using sanctum package
         *  if (Auth::attempt($check, true)){
         * $user =  User::where('email', $request->email)
         * ->update(['email_verified_at' => Carbon::now()]);
         * $user = new User();
         * $user = $user->with(['role'])->where('id', Auth::user()->id)->get();
         * return response()->json($user,200);
         * }
         * throw ValidationException::withMessages([
         * 'error' =>['The provided credentials are incorrect.']
         * ]);
         */


        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.']
            ]);

        } else {

            $user = User::where('email', $request->email)
                ->update(['email_verified_at' => Carbon::now(), 'status' => 1]);
            //$user = new User();
//            $user = $user->with(['role'])->where('id', auth('sanctum')->user()->id)->get();
            $user = User::where('email', $request->email)->first();
            $userToken = $user->createToken('auth_token')->plainTextToken;
            $user = $user->with(['role', 'store'])->where('id', $user->id)->get();
            $user['auth_token'] = $userToken;

            return response()->json($user, 200);
        }

    }

    public function index()
    {
        // $users = new User();
//        $users = $users->with(['invoice', 'user', 'products.Monument'])->orderBy('id', 'desc')->get();
        $users = User::with('role', 'store')
            ->whereHas('role', function ($query) {
                //$query->where('title', '!=', 'Admin');
            })
            ->orderBy('id', 'desc')->get();
//        $users = $users->orderBy('id', 'desc')->get();

        return response()->json($users);
    }

    public function getPaginationRecord()
    {
        $users = User::with($this->relations)
            ->whereHas('role', function ($query) {
            })
            ->orderBy('id', 'desc')->paginate(10);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        try {
            $user = json_decode($request->data, true);
            $allUsers = new User();
            $userPasswordStatus = null;
            $rules = [
                'name' => ['required'],
                'email' => ["unique:users,email," . $user['id'] . ",id"],
                'phone_number' => ['required', 'min:10', 'max:20'],
                'role_id' => ['required'],
                'status' => ['required'],
            ];
            $validator = Validator::make($user, $rules);
            if ($validator->fails())
                return response()->json($validator->errors()->all());

            if ($user['id'] == 0 || empty($user['id'])) {

                $token = Str::random(64);
                $params['name'] = $user['name'];
                $params['email'] = $user['email'];
                $params['subject'] = "Create Password for Account to Login";
                $params["title"] = "Create Password";
                $user['verify_token'] = $token;
                $user['password_status'] = 0;
                $params['redirect_link'] = URL::to('/user-createPassword/' . $token);

                \Illuminate\Support\Facades\Mail::to($params['email'])->send(new CreateUserPassword($params));
            } else {
                $userPasswordStatus = User::where([
                    'email' => $user['email'],
                    'id' => $user['id']
                ])->get();
                if ($userPasswordStatus && !empty($userPasswordStatus['email'])) {
                    $user['password_status'] = $userPasswordStatus['password_status'];
                }

            }

            /*if (Auth::user()->role->title == $this->userSupperRoleTitle && isset($user['store_id']) && !empty($user['store_id'])){
                Store::updateOrCreate(['id' =>  $user['store']], $user['store']);
            }
            if (Auth::user()->role->title == $this->userSupperRoleTitle && isset($user['store_id']) && empty($user['store_id'])) {
                $storeID = Store::create(['subdomain' => null]);
                $user['store_id'] = $storeID->id;
            }else if (Auth::user()->role->title == $this->userRoleTitle){
                $user['store_id'] = Auth::user()->store_id;
            }*/
            $userInstance = User::updateOrCreate(['id' => $user['id']], $user);
            return response()->json($userInstance->load(['role', 'store']));

        } catch (Exception $e) {
            ProcessException::dispatch($e->getMessage());
            return response()->json(['errors' => $e->getMessage()]);
        }
    }

    function createPassword(Request $request)
    {

        $message = null;
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|confirmed',
        ],
            [
                'email.exists' => "We can't find a user with that e-mail address.",
            ]);

        $verifyToken = User::where([
            'email' => $request->email,
            'verify_token' => $request->token
        ])->first();

        if ($verifyToken) {
            if ($verifyToken['password_status'] == 0 || empty($verifyToken['password_status'])) {
                $password = $request->password;
                $password = Hash::make($password);
                User::where('email', $request->email)
                    ->update(['password_status' => 1, 'password' => $password, 'email_verified_at' => Carbon::now()]);
                $message = 'Your password is created successfully';
            }
            if (!$message)
                $message = 'You already created password please login';
            return response()->json([
                'message' => $message
            ], 200);
        } else {
            throw ValidationException::withMessages([
                'error' => ['The provided credentials are incorrect.']
            ]);
        }


    }

    public function show(User $user)
    {

        $user = User::where('id', $user->id)->
        whereHas('role', function ($query) {
            $query->where('title', '!=', 'Admin');
            $query->where('title', '!=', 'Supper Admin');
        })
            ->first();
        if ($user) {
            $user->load('role', 'store');
        }
        return response()->json($user);

    }

    public function destroy(User $user)
    {
        /**
         * TODO :
         * 1- Need a better solution here : foreach($quote->products as $product)
         * 2- How to handle dependency injection exception. in this case how to handle exception when $quote not found
         */
        /* foreach ($user->products as $product){
             $product->Monument()->detach();
         }

         $user->products()->delete();
         return $user->delete();*/
        return $user->delete();

    }

    public function getColumns()
    {
        $user = new User();
        $userRole = new UserRole();
        $user = $user->getTableColumns();
        $userRole = $userRole->getTableColumns();
        $data = [];
        $data['user'] = $user;
        $data['role'] = $userRole;
        return response()->json($data);
    }

    public function search(Request $request)
    {

        try {
            $user = new User();
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
            $user = $this->searchQuery($user, $request, 'User');
            if ($columnTableName == 'user') {
                return response()->json($user->with($this->relations)
                    ->whereHas('role', function ($query) {
                        $query->where('title', '!=', 'Admin');
                        $query->where('title', '!=', 'Supper Admin');
                    })
                    ->orderBy($sortByColumn, $sortDirection)->paginate($pagePerPage));
            } else if ($columnTableName == 'idInParentTable') {
                return response()->json($user->with($this->relations)->orderBy(
                    $childClassName::select($sortByColumn)
                        ->whereColumn('id', 'users.' . $foreignKey)
                        ->orderBy($sortByColumn, $sortDirection), $sortDirection
                )
                    ->whereHas('role', function ($query) {
                        $query->where('title', '!=', 'Admin');
                        $query->where('title', '!=', 'Supper Admin');
                    })
                    ->paginate($pagePerPage));
            }
        } catch (Exception $ex) {
            ProcessException::dispatch($ex->getMessage());
            return response()->json($ex);
        }
    }

    public function refineQuery($queryObj)
    {

        if ($queryObj->field->operator == '...') {
            $values = explode("...", $queryObj->field->value);
            $queryObj->query = $queryObj->query->whereBetween($queryObj->field->column, [(int)$values[0], (int)$values[1]]);
        } else if ($queryObj->field->value != '') {

            // If no operator provided, set to equal
            if ($queryObj->field->operator == '') {
                $queryObj->field->operator = 'like';
            }
            if (is_numeric($queryObj->field->value)) {
                if ($queryObj->field->operator == 'like')
                    $queryObj->field->operator = '=';
                elseif ($queryObj->field->operator == 'not like')
                    $queryObj->field->operator = '!=';
                $queryObj->query = $queryObj->query->orWhere($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value);
            } else if ((bool)strtotime($queryObj->field->value)) {
                if ($queryObj->field->operator == 'like')
                    $queryObj->field->operator = '=';

                $queryObj->query = $queryObj->query->orWhere($queryObj->field->column, $queryObj->field->operator, $queryObj->field->value);
            } else {
                $queryObj->query = $queryObj->query->orWhere($queryObj->field->column, $queryObj->field->operator, "%" . $queryObj->field->value . "%");
            }
        }

        return $queryObj->query;
    }

    public function getNextPrevious(User $user)
    {
        return $this->nextPreviousRecord(new User, $this->relations, $user->id);
    }

    public function getDropDownInfo()
    {
        $user = User::select('id', 'name', 'email', 'role_id')
            ->with('role:id,title')
            ->whereHas('role', function ($query) {
                $query->where('title', '!=', 'Admin');
                $query->where('title', '!=', 'Supper Admin');
            })
            ->orderBy('email', 'asc')
            ->get();
        return response()->json($user);
    }

    public function userInfo()
    {
        $userRole = new UserRole();
        return response()->json($userRole->get());
    }
}
