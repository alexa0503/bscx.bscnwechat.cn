<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotterySettingPost extends FormRequest
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
            'winning_odds' => 'required|numeric',
            'max_num' => 'required|numeric',
            'lottery_date' => 'nullable|date',
        ];
    }
}
