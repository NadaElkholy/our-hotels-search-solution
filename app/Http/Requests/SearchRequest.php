<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_date'     => 'required|date:Y-m-d',
            'to_date'       => 'required|date:Y-m-d|after:from_date',
            'city'          => 'required|string|size:3',
            'adults_number' => 'required|integer|min:1',
        ];
    }
}
