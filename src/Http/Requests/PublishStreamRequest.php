<?php

namespace SquareetLabs\LaravelOpenVidu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PublishStreamRequest
 * @package SquareetLabs\LaravelOpenVidu\Http\Requests
 */
class PublishStreamRequest extends /** @scrutinizer ignore-call */
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
            'rtspUri' => 'string|required',
            'type' => 'string',
            'adaptativeBitrate' => 'boolean',
            'onlyPlayWithSubscribers' => 'boolean',
            'data' => 'string'
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
            'rtspUri.required' => /** @scrutinizer ignore-call */ __('validation.publish.rtspUri_required'),
            'adaptativeBitrate.boolean' => /** @scrutinizer ignore-call */ __('validation.publish.adaptativeBitrate_boolean'),
            'onlyPlayWithSubscribers.boolean' => /** @scrutinizer ignore-call */ __('validation.publish.onlyPlayWithSubscribers_boolean'),
        ];
    }
}
