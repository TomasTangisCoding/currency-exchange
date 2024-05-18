<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Validation\Validator;
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

        if ($this->routeName == 'currencyExchange') {
            $rules = [
                'source' => 'required|string',
                'target' => 'required|string',
                'amount' => 'required|regex:/^\d{1,3}(,?\d{3})*(\.?\d+)?$/',
            ];
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        if ($this->routeName == 'currencyExchange') {
            $validator->after(function ($validator) {

                $requestData = $validator->getData();
                $amount = str_replace(',', '', $requestData['amount']);
                if (is_numeric($amount)) {
                    $this->merge(['amount' => $amount]);
                    // $validator->errors()->add('amount', 'The amount format is invalid.');
                }

            });
        }
    }
}
