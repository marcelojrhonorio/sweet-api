<?php
/**
 * @todo Add docs.
 */

namespace App\Http\Controllers;

use Log;
use App\Models\Action;
use App\Models\Customers;
use App\Models\ActionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActionCategory;
use App\Models\ActionTypeMeta;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @todo Add docs.
 */
class ActionsController extends Controller
{
    /**
     * @todo Add docs.
     */
    protected $fields = [
        'action_category_id',
        'action_type_id',
        'action_type_url',
        'title',
        'order',
        'enabled',
        'description',
        'path_image',
        'grant_points',
        'filter_ddd',
        'filter_gender',
        'filter_cep',
        'filter_operation_begin',
        'filter_age_begin',
        'filter_operation_end',
        'filter_age_end',
        'exchange_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * @todo Add docs.
     */
    protected $rules = [
        'action_category_id' => 'required|numeric',
        'action_type_id'     => 'required|numeric',
        'action_type_url'    => 'required|string',
        'title'              => 'required|string',
        'description'        => 'required|string',
        'path_image'         => 'required|string',
        'grant_points'       => 'required|numeric',
        'order'              => 'required|numeric',
        'enabled'            => 'required',
    ];

    /**
     * @todo Add docs.
     */
    public function __construct()
    {}

    /**
     * @todo Add docs.
     */
    public function index(Request $request)
    {
        $model = Action::with([
            'actionCategory:id,name',
            'actionType:id,name',
            'actionTypeMetas',
        ])->get();   

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }

    public function getAllActions()
    {
        $actions = DB::select("SELECT * FROM sweet.actions WHERE enabled = true AND deleted_at IS NULL ORDER BY sweet.actions.order asc");
       
        if (is_null($actions)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid.'],
                'data'    => [],
            ], 404);
        }   
         
        return response()->json([
            'success' => true, 
            'data'    => $actions,
        ], 200);

    }

    public function showAction($id)
    {
        $model = Action::find($id);

        if (is_null($model)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Action resource.'],
                'data'    => [],
            ], 404);
        } 

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }

    public function getType($id)
    {
        $model = ActionType::find($id);

        if (is_null($model)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid.'],
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }    

    public function getTypeMetas(int $id)
    {
        $actionMeta = ActionTypeMeta::where('action_id', $id)->first();

        if (is_null($actionMeta)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid.'],
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $actionMeta->value,
        ], 200);
    }


    /**
     * @todo Add docs.
     */
    public function listByCategory(Request $request, $id)
    {
        $actions = ActionCategory::find($id)->actions;

        return response()->json([
            'success' => true,
            'data'    => $actions,
        ], 200);
    }

    /**
     * @todo Add docs.
     */
    public function freeActionsAll(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        $customer = Customers::with('checkins')->where('token', $token)->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Unauthorized.'],
            ], 401);
        }

        $blackList = $customer->checkins->map(function ($checkin) {
            return $checkin->actions_id;
        });

        $age = self::getAge($customer->birthdate);
        
        $actions = Action::whereNotIn('id', $blackList)
                   ->with([
                       'actionTypeMetas',
                   ])->where('enabled', true)
                     ->where('action_type_id', '<>', 7)
                     ->orderBy('order', 'asc')
                     ->get();         

        $actions = self::verifyFilterGender($actions, $customer->gender);
        $actions = self::verifyFilterCep($actions, $customer->cep);
        $actions = self::verifyFilterDdd($actions, $customer->ddd);
        $actions = self::verifyFilterAge($actions, $age);
                 
        return response()->json([
            'success' => true,
            'data'    => $actions,
        ], 200);
    }

    private static function verifyFilterDdd($actions, $ddd)
    {
        /**
         * Verificar se existe o filtro de ddd e se o customer atende a ele.
         * A ação será disponibilizada caso o customer atenda ao filtro ou o filtro não exista.
         */

        $array = [];

        foreach($actions as $action)
        {
            if($action->filter_ddd)
            {
                $pattern = '/' . $ddd . '/';//Padrão a ser encontrado 

                if (preg_match($pattern, $action->filter_ddd)) {
                    array_push($array, $action);
                } 
            } else {
                array_push($array, $action);
            } 
        }  

        return $array;        
    }

    private static function verifyFilterCep($actions, $cep)
    {
        /**
         * Verificar se existe o filtro de cep e se o customer atende a ele.
         * A ação será disponibilizada caso o customer atenda ao filtro ou o filtro não exista.
         */

        $array = [];

        foreach($actions as $action)
        {
            if($action->filter_cep)
            {
                $pattern = '/' . $cep . '/';//Padrão a ser encontrado 

                if (preg_match($pattern, $action->filter_cep)) {
                    array_push($array, $action);
                } 
            } else {
                array_push($array, $action);
            } 
        }  

        return $array;        
    }

    private static function verifyFilterGender($actions, $gender)
    {
        /**
         * Verificar se existe o filtro de gênero e se o customer atende a ele.
         * A ação será disponibilizada caso o customer atenda ao filtro ou o filtro não exista.
         */

        $array = [];

        foreach($actions as $action)
        {
            if($action->filter_gender)
            {
                $pattern = '/' . $gender . '/';//Padrão a ser encontrado 

                if (preg_match($pattern, $action->filter_gender)) {
                    array_push($array, $action);
                } 
            } else {
                array_push($array, $action);
            } 
        }  

        return $array;        
    }

    private static function verifyFilterAge($actions, $age)
    {
        /**
         * Verificar se existe o filtro de idade e se o customer atende a ele.
         * A ação será disponibilizada caso o customer atenda ao filtro ou o filtro não exista.
         */

        $array = [];

        foreach($actions as $action)
        {
            if($action->filter_operation_begin && $action->filter_age_begin && $action->filter_operation_end && $action->filter_age_end)
            {                
                $condition1 = self::checkMethodOperation($age, $action->filter_operation_begin, $action->filter_age_begin);
                $condition2 = self::checkMethodOperation($age, $action->filter_operation_end, $action->filter_age_end);

                if($condition1 && $condition2) {
                    array_push($array, $action);
                } 

            } else {
                array_push($array, $action);
            }
        }

        return $array;
    }

    private static function checkMethodOperation($age, $filter_operation, $filter_age)
    {
        $result;

        switch ($filter_operation) {
            case '>':
                $result = $age > $filter_age;                
                break;

            case '>=':
                $result = $age >= $filter_age;      
                break;

            case '=':
                $result = $age == $filter_age;      
                break;

            case '<':
                $result = $age < $filter_age;
                break;

            case '<=':
                $result = $age <= $filter_age;      
                break;

            case '<>':
                $result = $age <> $filter_age;      
                break;
            
            default:
                # code...
                break;
        }

        return $result;
    }

    private static function getAge($birthdate)
    {         
        // Separa em dia, mês e ano
        list($year, $month, $day) = explode('-', $birthdate);
        $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        // Descobre a unix timestamp da data de nascimento
        $birthdate = mktime( 0, 0, 0, $month, $day, $year);
    
        // Cálculo da idade
        $age = floor((((($today - $birthdate) / 60) / 60) / 24) / 365.25);

        return $age;
    }

    /**
     * @todo Add docs.
     */
    public function freeActionsByCategory(Request $request, $categoryId)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        $customer = Customers::with('checkins')->where('token', $token)->first();

        if (is_null($customer)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Unauthorized.'],
            ]);
        }

        $blackList = $customer->checkins->map(function ($checkin) {
            return $checkin->actions_id;
        });

        $category = ActionCategory::where('id', $categoryId)
                        ->with([
                            'actions' => function ($query) use ($blackList) {
                                $query->whereNotIn('id', $blackList);
                            },
                            'actions.actionTypeMetas'
                        ])
                        ->first();

        return response()->json([
            'success' => true,
            'data'    => $category,
        ]);
    }

    /**
     * @todo Add docs.
     */
    public function categories(Request $request) {
        $actions = ActionCategory::all();

        return response()->json([
            'success' => true,
            'data'    => $actions,
        ]);
    }

    /**
     * @todo Add docs.
     */
    public function types(Request $request) {
        $types = ActionType::all();

        return response()->json([
            'success' => true,
            'data'    => $types,
        ]);
    }

    /**
     * @todo Add docs.
     */
    public function show($id)
    {
        $model = Action::find($id);

        if (is_null($model)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Action resource.'],
                'data'    => [],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $model,
        ], 200);
    }

    /**
     * @todo Add docs.
     */
    public function store(Request $request)
    {
        $validated = \Validator::make($request->only($this->fields), $this->rules);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validated->errors(),
                'data'    => [],
            ], 422);
        }       

        $action = Action::create($request->only($this->fields));

        //atualizar ordem de exibição 
        self::updateOrderAction($action);

        $actionTypeMeta = ActionTypeMeta::create([
            'action_id'      => $action->id,
            'action_type_id' => $request->input('action_type_id'),
            'key'            => 'url',
            'value'          => $request->input('action_type_url'),
        ]);

        return response()->json([
            'success' => true,
            'data'    => $action,
        ], 201);
    }

    /**
     * @todo Add docs.
     */
    public function update(Request $request, $id)
    {
        $actionModel = Action::find($id);

        if (is_null($actionModel)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Action resource.'],
                'data'    => [],
            ], 404);
        }

        $validated = \Validator::make($request->only($this->fields), $this->rules);

        if ($validated->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validated->errors(),
                'data'    => [],
            ], 422);
        }

        $actionModel->fill($request->except(['action_type_url']));
        $actionModel->save();

        //atualizar ordem de exibição 
        self::updateOrderAction($actionModel);

        $actionMetaModel = ActionTypeMeta::where('action_id', $id)->update(['value' => $request->input('action_type_url')]);

        return response()->json([
            'success' => true,
            'data'    => $actionModel,
        ], 200);
    }

    private static function updateOrderAction($action)
    {
        $actions = Action::whereNull('deleted_at')
                         ->where('id', '<>', $action->id)->get() ?? null;
       
        foreach($actions as $act)
        {
            if($act->order == $action->order)
            {               
                foreach($actions as $actns)
                {
                    if($actns->order >= $action->order) 
                    {
                        $actns->order = (int) $actns->order + 1;
                        $actns->update();
                    }
                }
            }
        }
    }

    /**
     * @todo Add docs.
     */
    public function destroy($id)
    {
        $model = Action::find($id);

        ActionTypeMeta::where('action_id', $id)->delete();

        if (is_null($model)) {
            return response()->json([
                'success' => false,
                'errors'  => ['not_found' => 'Invalid Action resource.'],
                'data'    => [],
            ], 404);
        }

        $model->delete();

        return response()->json([
            'success' => true,
            'data'    => [],
        ]);
    }
}
