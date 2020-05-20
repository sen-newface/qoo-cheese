<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'start_date' => 'required|date|before_or_equal:end_date|after:yesterday',
            'end_date' => 'required|date|after_or_equal:start_date'
        ];
    }

    public function messages()
    {
        return [
        'name.required' => 'イベント名を入力してください',
        'name.string' => '名前は文字列で入力してください',
        'name.max' => '名前は255文字以内で入力してください',
        'start_date.required' => '公開開始日を入力してください',
        'start_date.date' => '日付の入力が不適切です',
        'start_date.before_or_equal' => '公開終了日以前に設定してください',
        'start_date.after' => '本日以降に設定してください',
        'end_date.required' => '公開終了日を入力してください',
        'end_date.date' => '日付の入力が不適切です',
        'end_date.after_or_equal' => '公開開始日以後に設定してください'
        ];
    }
}
