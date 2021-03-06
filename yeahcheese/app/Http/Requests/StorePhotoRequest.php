<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePhotoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'image_path' => 'required|image|mimes:jpeg|max:200'
        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => ':attributeの選択は必須です',
            'image_path.image' => ':attributeを指定してください',
            'image_path.mimes' => ':attributeはjpegで指定してください',
            'image_path.max' => ':max以下の:attributeを指定してください'
        ];
    }

    public function attributes()
    {
        return [
            'image_path' => 'イベント写真'
        ];
    }

    protected function falidValidation(Validator $validator)
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
