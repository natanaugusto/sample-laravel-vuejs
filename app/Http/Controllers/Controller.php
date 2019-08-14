<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log as LogLib;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Validate the User Permission
     *
     * @param string $logTag
     * @param Request $request
     * @param string $permission
     * @return boolean|Response
     */
    protected function userHasPermission(string $logTag, Request $request, string $permission)
    {
        if($request->user()->can($permission)) {
           return true;
        }

        $this->registerLog($logTag, 'warning', $request, null, 'The user don\'t has permission');
        return response(null, 401);
    }
    /**
     * Register a Log
     *
     * @param string $tag
     * @param string $type
     * @param Request $request
     * @param JsonResponse $response
     * @param string $message
     * @return void
     */
    protected function registerLog(string $tag, string $type, Request $request = null, JsonResponse $response = null, string $message = '')
    {
        $logText = $tag;
        if(!empty($request)) {
            $logText .= ' :: REQUEST: ' . json_encode($request);
        }
        if(!empty($response)) {
            $logText .= ' :: RESPONSE: ' . json_encode($response);
        }
        if(!empty($message)) {
            $logText .= " :: MESSAGE: {$message}";
        }
        LogLib::{$type}($logText);
    }

    /**
     * Parse a Exception Object to text
     *
     * @param \Exception $e
     * @return string
     */
    protected function parseError(\Exception $e)
    {
        return '(' . $e->getCode() .') ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine();
    }

    protected function validate(array $data, array $rules, array $message = [])
    {
        $validator = Validator::make(
            $data,
            $rules,
            $message
        );
        if($validator->fails()) {
            return response()->json(
                $validator->messages(), 422
            )->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
        return true;
    }
}
