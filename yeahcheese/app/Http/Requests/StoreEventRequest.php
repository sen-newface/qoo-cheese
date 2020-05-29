<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\EventRequest;

class StoreEventRequest extends EventRequest
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
     * @return array
     */
    public function rules()
    {
        return parent::rules() + [
        'start_date' => 'after:yesterday',
        ];
    }

    public function messages()
    {
        return parent::messages() +  [
        'start_date.after' => '本日以降に設定してください',
        ];
    }
}
