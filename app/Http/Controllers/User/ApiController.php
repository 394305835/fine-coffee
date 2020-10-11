<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMSRequest;
use App\Http\Services\User\ApiService;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;

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
