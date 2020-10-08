<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SignalRequest
 * @package SquareetLabs\LaravelOpenVidu\Http\Requests
 */
class SignalRequest extends /** @scrutinizer ignore-call */
    FormRequest
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

            'session' => 'string|required',
            'to' => 'array',
            'to.*' => 'string|distinct',
            'type' => 'string',
            'data' => 'string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'session.required' => /** @scrutinizer ignore-call */ __('validation.signal.session_required'),
            'to.array' => /** @scrutinizer ignore-call */ __('validation.signal.to_array')
        ];
    }
}
