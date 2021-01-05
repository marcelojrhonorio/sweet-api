<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Services\PixelService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpenedEmailsController extends Controller
{
    //
    public function getOpenedEmailPixel(Request $request)
    {
        // Get email
        $email = $request->query('email');
        $id = $request->query('id');

        if($id) {
            self::updateById($id);
        }else{
            self::updateByEmail($email);
        }
        // Return pixel
        return PixelService::returnPixel();
    }

    private static function updateByEmail($email)
    {
        return DB::table('customers')
            ->where('email', $email)
            ->increment('count_opened_email',1, [ 'last_opened_email' => Carbon::now()->toDateTimeString()]);
    }

    private static function updateById($id)
    {
        return DB::table('customers')
            ->where('id', $id)
            ->increment('count_opened_email',1, [ 'last_opened_email' => Carbon::now()->toDateTimeString()]);
    }

}
