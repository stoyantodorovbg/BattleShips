<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefaultGameShotRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return session()->has('battle_ships_grid');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $gridRowsCount = count($this->session()->get('battle_ships_grid'));
        $gridColsCount = count($this->session()->get('battle_ships_grid')[1]);

        return [
            'row' => 'required|integer|min:1|max:' . $gridRowsCount,
            'col' => 'required|integer|min:1|max:' . $gridColsCount,
        ];
    }
}
