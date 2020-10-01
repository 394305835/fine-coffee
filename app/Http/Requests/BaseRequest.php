<?php

namespace App\Http\Requests;

use App\Lib\RestFul\JsonAPI;
use App\Lib\RestFul\RESTFulAPI;
use App\Lib\RetJson;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{

    public function failedValidation(Validator $validator)
    {
        $ret = RetJson::pure()->setStatusCode(400)->error($validator->errors()->first());
        throw new HttpResponseException((new JsonAPI())->reply($ret));
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
