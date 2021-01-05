<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    public function authenticate(Request $request)
    {
        $validator = $request->only('email', 'password');

        $this->validate($request, [
            'email'    => 'required',
            'password' => 'required',
        ]);

        $user = Users::where('email', $request->input('email'))->first();

        $companies = [];

        foreach ($user->getUserCompanies() as $company) {
            $companies[] = $company->id;
        }

        $menu = [];

        foreach ($user->getMenus($user->access_groups_id) as $menus) {
            $menu[] = [
                'id'        => $menus->id,
                'parent_id' => $menus->parent_id,
                'order'     => $menus->order,
                'icon'      => $menus->icon,
                'name'      => $menus->name,
                'route'     => $menus->route,
            ];
        }

        if (is_null($user)) {
            return response()->json(['status' => 'fail', 'api_key' => ''], 401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(['status' => 'fail', 'api_key' => ''], 401);
        }

        $apiKey = base64_encode(str_random(40));

        Users::where('email', $request->input('email'))->update(['api_key' => $apiKey]);

        return response()->json([
            'status'    => 'success',
            'role'      => $user->getUserAccessGroup()->name ?: false,
            'companies' => $companies,
            'access'    => $menu,
            'api_key'   => $apiKey,
        ], 201);
    }
}
