<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CurrencyExchangeRequest extends FormRequest
{
    protected $routeName;

    public function __construct()
    {
        $this->routeName = Route::currentRouteName();
    }

    protected function failedValidation(Validator $validator)
    {
        $message = $validator->errors();
        throw new HttpResponseException(response(['success' => false, 'message' => $message->first()],400));
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        switch ($this->routeName) {
            case 'currencyExchange':
                $rules = [
                    'source' => 'required|string',
                    'target' => 'required|string',
                    'amount' => 'required|regex:/^\d{1,3}(,?\d{3})*(\.?\d+)?$/',
                ];
                break;
            default:
                $rules = [];
                break;
        }

        return $rules;
    }
}