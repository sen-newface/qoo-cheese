<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\EventRequest;

class UpdateEventRequest extends EventRequest
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
        return [
        'name' => 'required|string|max:255',
        'start_date' => 'required|date|before_or_equal:end_date|',
        'end_date' => 'required|date|after_or_equal:start_date'
        ];
    }
}
