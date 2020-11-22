<?php

namespace App\Http\Requests\Cards;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'complaint' => ['required', 'string', 'min:2', 'max:255'],
            'content'   => ['required', 'string', 'min:10', 'max:25455']
        ];
    }
}
