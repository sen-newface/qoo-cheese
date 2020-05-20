<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'name' => 'required|max:20',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => '名前を入力してください。',
        'email.required' => 'メールアドレスを入力してください。',
        'email.unique' => 'そのメールアドレスは不正です',
        'password.required' => 'パスワードを入力してください。',
        'password.confirmed' => 'パスワードが一致しません。',
        'password.min'    => "パスワードの最小文字数は6文字です"
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $data = [
        'data' => [],
        'status' => 'error',
        'summary' => 'Failed validation.',
        'errors' => $validator->errors()->toArray(),
        ];

        throw new HttpResponseException(response()->json($data, 422));
    }
}
