<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMSRequest;
use App\Http\Services\User\ApiService;

class ApiController extends Controller
{
    public function getSMS(SMSRequest $request, ApiService $service)
    {
        return $this->api->reply($service->sendSMS($request));
    }

    public function upLoadFile(ApiService $service)
    {
        return $this->api->reply($service->saveUserTheme($this->request));
    }
}
