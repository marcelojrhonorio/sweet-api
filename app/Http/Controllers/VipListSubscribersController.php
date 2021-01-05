<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VipListSubscribers;
use App\Http\Controllers\Controller;

class VipListSubscribersController extends Controller
{
    protected $model;
    
    public function __construct(VipListSubscribers $model)
    {
        $this->model = $model;
    }

    public function create(Request $request)
    {
        $phone = $request->input('phone');
        $name = $request->input('name');

        $vipListSubscribers = new VipListSubscribers();
        $vipListSubscribers->phone = $phone;
        $vipListSubscribers->name = $name;
        $vipListSubscribers->save();

        return $vipListSubscribers;
    }

    public function verifyPhone(Request $request)
    {
        $phone = $request->input('phone');

        $vipListSubscribers = VipListSubscribers::where('phone', $phone)->first() ?? null;
        
        return $vipListSubscribers;
    }

    public function update(Request $request)
    {
        $phone = $request->input('phone');
        $name = $request->input('name');
        $older_phone = $request->input('older_phone');

        $vipListSubscribers = VipListSubscribers::where('phone', $older_phone)->first() ?? null;

        if($vipListSubscribers) {
            $vipListSubscribers->phone = $phone;
            $vipListSubscribers->name = $name;
            $vipListSubscribers->update();
    
            return $vipListSubscribers;
        }
        return null;
    }
}
