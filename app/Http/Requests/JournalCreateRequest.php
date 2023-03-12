<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JournalCreateRequest extends FormRequest
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
        $client = $this->route('client');
        return [
            'date' => [
                'date',
                'required',
                Rule::unique('journals')->where(function ($query) use ($client) {
                    return $query->where('client_id', $client->id);
                })

            ],
            'text' => [
                'required',
            ],
        ];
    }
}
