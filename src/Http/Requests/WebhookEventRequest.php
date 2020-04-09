<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WebhookEventRequest
 * @package SquareetLabs\LaravelOpenVidu\Http\Requests
 */
class WebhookEventRequest extends /** @scrutinizer ignore-call */
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
            'event' => 'string|required'
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
            'event.required' => /** @scrutinizer ignore-call */ __('validation.webhook_event.required'),
        ];
    }
}
