<?php

namespace App\Http\Requests;

use Illuminate\Http\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * リクエストに適用されるバリデーションチェックに対してメッセージを取得します。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'Email is required.',
            'password.required' => 'Password is required.',
            'email.email' => 'Emai format is wrong',
        ];
    }

    /**
     * @param Validator $validator　バリデーター
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(
                [
                    'status'  => 'error',
                    "message" =>  "The given data was invalid.",
                    'errors' => $validator->errors()->get('*') ,//or ->all() instead of get()
                    "test" => $validator
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
