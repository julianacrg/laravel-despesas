<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class DespesasRequest extends FormRequest
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
            'description' => ['required', 'max:191'],
            'date' => ['required', 'date', 'before_or_equal:' . Carbon::now()],
            'value' => ['required', 'numeric', 'non_negative']
        ];
    }

    public function messages()
    {
        return [
            'value.non_negative' => 'O valor da despesa deve ser maior que 0 (zero).',
        ];
    }
}
