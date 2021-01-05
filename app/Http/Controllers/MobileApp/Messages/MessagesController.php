<?php

namespace App\Http\Controllers\MobileApp\Messages;

use Log;
use Carbon\Carbon;
use App\Models\Customers;
use Illuminate\Http\Request;
use App\Traits\GetAppMessageTrait;
use App\Http\Controllers\Controller;
use App\Models\MobileApp\AppMessage;
use App\Services\SaveAppMessageService;
use App\Models\MobileApp\AppMessageType;

class MessagesController extends Controller
{
    use GetAppMessageTrait;

    public function search(int $customerId)
    {
        return response()->json([
            'success' => true,
            'data'    => self::handleGetMessages($customerId),
        ], 200);
    }

    private static function replaceStringVariables($customerId, $string) 
    {
        $customer = Customers::find($customerId);

        $string = str_replace("##nm_name##", explode(' ', $customer->fullname)[0], $string);

        return $string;
    }

    public function read($customerId, $messageId)
    {
        $message = AppMessage::find($messageId);
        $message->opened_at = Carbon::now()->toDateTimeString();
        $message->save();

        return response()->json([
            'success' => true,
            'data'    => self::handleGetMessages($customerId),
        ], 200);
    }

    public function destroy($customerId, $messageId)
    {
        $message = AppMessage::find($messageId);
        $message->delete();

        return response()->json([
            'success' => true,
            'data'    => self::handleGetMessages($customerId),
        ], 200);
    }

    public function test ($customerId, $type)
    {
        SaveAppMessageService::createMessage($customerId, $type, 'https://foo.com/foo/'.$customerId);
    }

    public function getMessage(int $messageId)
    {
        $message = AppMessage::find($messageId) ?? null;

        if($message) {
            $message->clicks = $message->clicks + 1;
            $message->update();

            return $message;
        }

        return null;
    }
}